<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Carbon;

class CommentController extends Controller
{

    public function store(){
        $data = request()->all();

        $body = $data['comment'];
        $commentable_id = $data['userId']; // user id
        $commentable_type = $data['postId']; // post id

        $comment = Comment::create([
            'body' => $body,
            'commentable_id' => $commentable_id,
            'commentable_type' => $commentable_type,
        ]);

        $posts = Post::get();
        $comments = Comment::get();
        $current = new Carbon();
        $date = $current->isoFormat('LLLL');

        foreach($posts as $post){
            if($comment->commentable_type == $post->id){

                return view('posts.show',[
                    'comments' => $comments,
                    'post' => $post,
                    'date'=>$date,
                ]);
            }
        }
    }


    public function edit($commentId){

        $comment = Comment::find($commentId);

        return view('posts.editComment',['comment' => $comment,]);
    }


    public function update(Request $request,$commentId){

        $comment = Comment::find($commentId);

        $comments = Comment::get();
        $posts = Post::get();

        $current = new Carbon();
        $date = $current->isoFormat('LLLL');

        Comment::where('id',$commentId)->update([
            'body' => $request->input('comment'),
        ]);

        foreach($posts as $post){
            if($comment->commentable_type == $post->id){

                return view('posts.show',[
                    'comments' => $comments,
                    'comment' => $comment,
                    'post' => $post,
                    'date'=>$date,
                ]);
            }
        }
    }


    public function delete($commentId){

        $comment = Comment::find($commentId);
        $comment->delete();

        $comments = Comment::get();
        $posts = Post::get();

        $current = new Carbon();
        $date = $current->isoFormat('LLLL');

        foreach($posts as $post){
            if($comment->commentable_type == $post->id){

                return view('posts.show',[
                    'comments' => $comments,
                    'post' => $post,
                    'date'=>$date,
                ]);
            }
        }
    }
}
