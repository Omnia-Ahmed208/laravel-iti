@extends('layouts.app')

@section('title') Show @endsection

@section('content')

<div class="card mt-4">
  <h5 class="card-header">Post Info</h5>
  <div class="card-body">

    <span class="card-title" style="font-weight:bold">Title:</span>
    <span>{{$post->title}}</span>
    <br><br>
    <span class="card-title" style="font-weight:bold">Description:</span>
    <span class="card-title">{{$post->description}}</span>
    <br><br>
    @if(!(empty($post->image)))
    <span class="card-title" style="font-weight:bold">Image:</span>
    <span class="card-title"><img src="{{ asset('/storage/'.$post->image)}}" style="width:300px" alt=""></span>
    @endif
  </div>
</div>

<div class="card mt-4">
  <h5 class="card-header">Post created Info</h5>
  <div class="card-body">

    <span class="card-title" style="font-weight:bold">Name:</span>
    <span>{{$post->user->name ?? 'not Found'}}</span>
    <br><br>
    <span class="card-title" style="font-weight:bold">Created_at:</span>
    {{--<span class="card-title">{{$post->created_at}}</span>--}}
    <span class="card-title">{{$date}}</span>
  </div>
</div>

{{--show comments--}}
<ul class="list-group list-group-flush mt-4">
    @foreach($comments as $comment)
        @if($comment->commentable_type == $post->id && $comment->commentable_id == $post->user_id )
        <li class="list-group-item" style="color: red;display:flex">
            <p style="width: 100%;">{{$comment->body}}</p>
            <div style="display: flex;width: 100%;place-content: flex-end;align-items: center;">
                <a href="{{route('comments.edit', $comment->id)}}" class="btn btn-primary editBtn"
                style="margin-right: 15px;">Edit</a>
                <a href="{{route('comments.delete',$comment->id)}}" onclick="return confirm('Are you sure to delete it?')"
                class="btn btn-danger deleteBtn">Delete</a>
            </div>
        </li>
        @endif
    @endforeach
</ul>

<div class="add mb-4" style="display: block;">
    <form action="/comments/{{$post->id}}" method="POST">
        @csrf {{-- to store method--}}
        <div class="card mt-4">
            <h5 class="card-header"><button class="btn btn-primary mt-4 mb-4" type="submit">Add Comment</button></h5>
            <div class="card-body">
                <input type="text" name="comment" class="form-control" id="exampleFormControlInput1">
                <input type="hidden" name="userId" value="{{$post->user_id}}">
                <input type="hidden" name="postId" value="{{$post->id}}">
            </div>
        </div>
    </form>
</div>

@endsection
