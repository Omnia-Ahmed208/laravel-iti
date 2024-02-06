<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Support\Str; // slug

class PostController extends Controller
{
    public function index(){

        // $posts = Post::all(); // return collection
        $posts = Post::paginate(3);

        // $response = [];
        // // we don't want show everything to the user so will make arr for json arr from db
        // foreach($posts as $post){
        //     $response [] = [
        //         'id' => $post->id,
        //         'title' => $post->title,
        //         'description' => $post->description
        //     ];
        // }
        // return $response;

        return PostResource::collection($posts);// PostResource has all attributes
    }

    public function show($postId){

        $post = Post::find($postId); // one object of type model

        return new PostResource($post);
    }

    public function store(StorePostRequest $request){

        $data = request()->all();

        $title = $data['title'];
        $description = $data['description'];
        $userId = $data['select_post'];

        $pathImg = $request->file('image')->store('posts'); // store(posts)it inside storage-app-public-posts folder

        $post = Post::create([
            'title' => $title,
            'description' => $description,
            'user_id' => $userId,
            'slug' => Str::slug($title),
            'image' => $pathImg,
        ]);

        return $post;
    }
}
