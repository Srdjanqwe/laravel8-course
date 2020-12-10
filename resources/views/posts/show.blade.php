@extends('layout')

@section('content')
    <h1>{{ $posts->title }}</h1>
    <p>{{ $posts ->content }}</p>

    {{-- <p>Added {{ $posts->created_at }}</p> --}}
    <p>Added {{ $posts->created_at->diffForHumans() }}</p>

    {{-- {{ (new Carbon\Carbon())->diffInMinutes($posts->created_at) }} --}}

    @if ((new Carbon\Carbon())->diffInMinutes($posts->created_at) < 5)
        <strong>New!</strong>
    @endif

    <h4>Comments</h4>

    @forelse($posts->comments as $comment)
        <p>
            {{ $comment->content }}
        </p>
        <p class="text-muted">
            added {{$comment->created_at->diffForHumans() }}
        </p>
    @empty
        <p>No comments yet!</p>
    @endforelse

@endsection('content')
