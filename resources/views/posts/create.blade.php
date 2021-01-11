@extends('layout')

@section('content')
    <form method="POST" action="{{ route('posts.store')}}" enctype="multipart/form-data">
        @csrf

        @include('posts._form')

        <div><input type="submit" value="Create" class="btn btn-primary btn-block"></div>

    </form>

@endsection
