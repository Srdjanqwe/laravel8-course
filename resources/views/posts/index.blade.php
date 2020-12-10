@extends('layout')

@section('content')
   {{-- @foreach ($posts as $post)
        <p>
        <h3>{{ $post->title }}</h3>
        </p>
   @endforeach --}}

   @forelse ($posts as $post)
        <p>
            <h3><a href="{{ route('posts.show', ['post'=> $post->id]) }}">{{ $post->title }}</a></h3>

            @if($post->comments_count)
                <p>{{ $post->comments_count}} comments</p>
            @else
                <p>No comments yet!</p>
            @endif

            <div class="mb-3">
                <a href="{{ route('posts.edit', ['post'=> $post->id]) }}" class="btn btn-primary">Edit</a>

                <form class="d-inline" action="{{ route('posts.destroy', ['post'=> $post->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <input type="submit" value="Delete" class="btn btn-primary">
                </form>

            </div>

        </p>
    @empty
        <p>No Blog post yet!</p>
    @endforelse
@endsection('content')
