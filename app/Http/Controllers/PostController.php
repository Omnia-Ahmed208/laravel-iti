<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Carbon;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Str; // slug
use App\Jobs\PruneOldPostsJob;
use File;
use Illuminate\Support\Facades\Storage;
use Image;

class PostController extends Controller
{
    public function index()
    {
        // $allPosts = Post::all(); //return object // all()=>show all records
        $allPosts = Post::paginate(3);

        // dd($allPosts); // dd => die dump ==> print and exit

        $current = new Carbon(); //time format Carbon
        $date = $current->toDateString();


        return view('posts.index',[ // index => show tables
            'posts' => $allPosts,
            'date' => $date,
        ]);

    }


    public function create(){

        $user = User::get();
        return view('posts.create',[
            'Users'=> $user,
        ]);
    }


    public function store(StorePostRequest $request){
        // Validation before save data in (StorePostRequest) File
        // $request->validate([
        //     'title' => ['required', 'min:3'],
        //     'description' => ['required', 'min:10']
        // ],[
        //     'title.required' => "the title shouldn't be empty", // for change default error msg
        //     'title.min' => "minimum length of the title is 3"
        // ]);

        $data = request()->all();
        // or $data = $request->all();

        $title = $data['title']; //==> $data['name on input in html']
        //OR $title = request()->title;
        $description = $data['description'];
        $userId = $data['select_post'];

        $pathImg = $request->file('image')->store('posts'); // store(posts)it inside storage-app-public-posts folder

        Post::create([ // to insert in database
            // 'column-name-in-db'=>'value',
            'title' => $title,
            'description' => $description,
            'user_id' => $userId,
            'slug' => Str::slug($title),
            'image' => $pathImg,
        ]);

        return to_route(route:'posts.index');
    }


    public function show($postId){
        // @dd($postId);
        // $post = Post::find($postId);
        $post = Post::where('slug', $postId)->first();
        // @dd($post->title);

        // for date of show page
        $current = new Carbon();
        $date = $current->isoFormat('LLLL');

        $comments = Comment::get();
        // dd($comments);

        return view('posts.show',[
            'post'=>$post,
            'date'=>$date,
            'comments'=> $comments
        ]);
    }


    public function edit($postId){

        $users = User::get();
        // // dd($users);
        // $post = Post::find($postId);
        $post = Post::where('slug', $postId)->first();
        // dd($post->title);

        return view('posts.edit',[
            'post' => $post,
            'users' => $users
        ]);
    }

    public function update(StorePostRequest $request,$postId){

        // $posts = POST::find($postId);
        $post = Post::where('slug', $postId)->first();

        if($request->hasFile('image')){
            Storage::delete($post->image);
            $post->image = $request->file('image')->store('posts');
        }
        // POST::where('id',$postId)->update([
        POST::where('slug',$postId)->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'user_id' => $request->input('select_post'),
            'slug' => Str::slug($request->input('title')),
            'image' => $post->image,
        ]);

        // OR

        //     $posts = POST::find($postId);
        //     $posts->title = $request->input('title');
        //     $posts->description = $request->input('description');
        //     $posts->user_id = $request->input('select_post');
        //     $posts->update();

        return redirect('/posts');
    }


    public function delete($postId){

        $posts = POST::find($postId);
        // POST::where('id',$postId)->delete();

        Storage::delete($posts->image); // delete img from folder first then delete the post

        $posts->delete();

        return redirect('/posts');
    }

}

