@extends('layouts.app')

@section('title') Create @endsection

@section('content')

<div class="update mb-4">
    <form action="/comments/update/{{$comment->id}}" method="POST">
        @csrf
        @method('PUT')
        <div class="card mt-4">
            <h5 class="card-header"><button class="btn btn-success mt-4 mb-4" type="submit">Update</button></h5>
            <div class="card-body">
                <input type="text" name="comment" class="form-control" id="exampleFormControlInput1" value="{{$comment->body}}">
            </div>
        </div>
    </form>
</div>

@endsection
