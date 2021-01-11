@extends('layout')

@section('content')
<div class="row">
    <div class="col-8">
        @if($posts->image)
        <div style="background-image: url('{{ $posts->image->url() }}'); min-height: 500px; color: white; text-align: center; background-attachment: fixed;">
            <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
        @else
            <h1>
        @endif

        {{ $posts->title }}
            <x-badge show="{{ now()->diffInMinutes($posts->created_at) < 10 }}">
                Brand new post!
            </x-badge>

        @if($posts->image)
            </h1>
        </div>
        @else
            </h1>
        @endif

        <p>{{ $posts ->content }}</p>

        {{-- <img src="{{ $posts->image->url() }}" /> --}}

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

        @include('comments._form')

        @forelse($posts->comments as $comment)
            <p>
                {{ $comment->content }}
            </p>

        <x-updated date="{{ $comment->created_at->diffForHumans() }}" name="{{ $comment->user->name }}">
        </x-updated>

        @empty
            <p>No comments yet!</p>
        @endforelse
    </div>
    <div class="col-4">
        @include('posts._activity')
    </div>
@endsection('content')
