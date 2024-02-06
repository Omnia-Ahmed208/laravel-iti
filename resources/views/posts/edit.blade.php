
@extends('layouts.app')

@section('title') Create @endsection

@section('content')

    @if ($errors->any()) {{--for validation--}}
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- <form action="/posts/update/{{$post->id}}" method="POST"> --}}
    <form action="/posts/update/{{$post->slug}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Title</label>
            <input name='title' type="text" class="form-control" id="exampleFormControlInput1" value="{{$post->title}}">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$post->description}}</textarea>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Image</label>
            <input name='image' type="file" class="form-control" id="exampleFormControlInput1">
            <img src="{{ asset('/storage/'.$post->image)}}"style="width:500px;margin-top:10px" alt="">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Post Creator</label>
            <select class="form-control" name="select_post">
                <option value="{{$post->user_id}}">{{$post->user->name ?? 'Not Found'}}</option>

                @foreach($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach

            </select>
        </div>
        <button class="btn btn-primary mt-4 mb-4" type="submit">Update</button>
    </form>

@endsection
