@extends('layouts.app')

@section('title') index @endsection

@section('content')

    <div class="d-grid gap-2 col-6 mx-auto">
        <a href="{{route('posts.create')}}" class="btn btn-primary mt-4 mb-4">Create Post</a>
    </div>

  <table class="table mt-4">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Posted by</th>
      <th scope="col">Created At</th>
      <th scope="col">Image</th>
      <th scope="col">Slug</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>

    @foreach($posts as $index=>$post)

    {{-- @dd($post) ==>//  print first row in array and die --}}
    <tr>
        {{--<th scope="row">{{$post['id']}}</th>--}}
        {{--<td>{{$post['title']}}</td>--}}
        {{--<td>{{$post['posted_by']}}</td>--}}
        {{--<td>{{$post['created_at']}}</td>--}}
      <th scope="row">{{++$index}}</th>

      <td>{{$post->title}}</td>

        {{--@if($post->user)--}}
            {{--<td>{{$post->user->name}}</td>--}}
        {{--@else--}}
            {{--<td>User not Found</td>--}}
        {{--@endif--}}

        {{--<td>{{$post->user?->name}}</td>--}}

        {{--<td>{{$post->user ? $post->user->name : "Not Found"}}</td>--}}

        <td>{{$post->user->name ?? "Not Found"}}</td>

        {{--<td>{{$post->user}}</td> Errorrrr--}}

        {{--<td>{{$post->created_at}}</td>--}}
        <td>{{$date}}</td>{{--date from carbon--}}

        {{-- <td><img src="/images/{{$post->image}}" style="width:100px" alt=""></td> --}}
        <td><img src="{{ asset('/storage/'.$post->image)}}" style="width:100px" alt=""></td>

        <td>{{$post->slug}}</td>

        <td>
            {{--<!-- <a href="/posts/{{$post['id']}}" class="btn btn-secondary">View</a> -->--}}
            {{-- <a href="{{route('posts.show', $post->id)}}" class="btn btn-secondary">View</a> --}}
            <a href="{{route('posts.show', $post->slug)}}" class="btn btn-secondary">View</a>
            <a href="{{route('posts.edit', $post->slug)}}" class="btn btn-primary">Edit</a>
            <a href="{{route('posts.delete', $post->id)}}" onclick="return confirm('Are you sure to delete it?')"
            class="btn btn-danger deleteBtn">Delete</a>
        </td>

    </tr>
    @endforeach
  </tbody>
  </table>

  {{$posts->links()}} {{--Paginator--}}

  @endsection
