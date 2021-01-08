@extends('layout')

@section('content')
<div class="row">
    <div class="col-8">
        <h1>{{ $posts->title }}
            <x-badge show="{{ now()->diffInMinutes($posts->created_at) < 10 }}">
                Brand new post!
            </x-badge>
        </h1>

        <p>{{ $posts ->content }}</p>

        <x-updated date="{{ $posts->created_at->diffForHumans() }}" name="{{ $posts->user->name }}">
        </x-updated>

        <x-updated date="{{ $posts->updated_at->diffForHumans() }}">
            Updated
        </x-updated>

        {{-- <x-tags tags="{{ $post->tags }}"></x-tags> --}}
        {{-- <x-tags>{{ $post->tags }}</x-tags> --}}
        @tags(['tags' => $posts->tags])@endtags  {{-- sa aliasComponent radi --}}

        <p>Currently read by {{ $counter }} people</p>

        <h4>Comments</h4>

        @forelse($posts->comments as $comment)
            <p>
                {{ $comment->content }}
            </p>

        <x-updated date="{{ $comment->created_at->diffForHumans() }}">
        </x-updated>

        @empty
            <p>No comments yet!</p>
        @endforelse
    </div>
    <div class="col-4">
        @include('posts._activity')
    </div>
@endsection('content')
