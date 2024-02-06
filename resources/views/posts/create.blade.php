@extends('layouts.app')

@section('title') Create @endsection

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="/posts" method="POST" enctype="multipart/form-data">
        @csrf {{-- to store method--}}
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Title</label>
            <input name="title" type="text" class="form-control" id="exampleFormControlInput1">
        </div>

        {{--if the title is empty--}}
        {{-- @if ($errors->has('title'))
        <div class="alert alert-danger">
            <ul>
                <li>title error</li>
            </ul>
        </div>
        @endif --}}

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Image</label>
            <input name="image" type="file" class="form-control" id="exampleFormControlInput1">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Post Creator</label>
            <select name="select_post" class="form-control" id="select_post">
                @foreach($Users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary mt-4 mb-4" type="submit">Submit</button>
    </form>

@endsection
