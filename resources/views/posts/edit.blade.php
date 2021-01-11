@extends('layout')

@section('content')
    <form method="POST" action="{{ route('posts.update',['post'=> $posts->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('posts._form')

       <button type="submit">Update</button>


    </form>

@endsection
