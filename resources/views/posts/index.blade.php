@extends('layout')

@section('content')
<div class="row">
    <div class="col-8">
            @forelse ($posts as $post)
                    <p>
                        <h3>
                            @if($post->trashed())
                                <del>
                            @endif
                            <a class="{{ $post->trashed() ? 'text-muted' : ''}}"
                                href="{{ route('posts.show', ['post'=> $post->id]) }}">{{ $post->title }}</a>
                            @if($post->trashed())
                                </del>
                            @endif
                        </h3>

                        <x-updated date="{{ $post->updated_at->diffForHumans() }}" name="{{ $post->user->name }}">
                        </x-updated>

                        {{-- <x-tags tags="{{ $post->tags }}"></x-tags> --}}
                        {{-- <x-tags>{{ $post->tags->name }}</x-tags> --}}
                        {{-- <x-tags>Proba</x-tags> --}}

                        @if($post->comments_count)
                            <p>{{ $post->comments_count}} comments</p>
                        @else
                            <p>No comments yet!</p>
                        @endif

                        <div class="mb-3">
                            @auth
                                @can('update', $post)
                                    <a href="{{ route('posts.edit', ['post'=> $post->id]) }}" class="btn btn-primary">Edit</a>
                                @endcan
                            @endauth

                            @auth
                                @if(!$post->trashed())
                                    @can('delete', $post)
                                        <form class="d-inline" action="{{ route('posts.destroy', ['post'=> $post->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <input type="submit" value="Delete" class="btn btn-primary">
                                        </form>
                                    @endcan
                                @endif
                            @endauth
                        </div>

                    </p>
                @empty
                    <p>No Blog post yet!</p>
                @endforelse

    </div>
    <div class="col-4">
        <div class="container">
            <div class="row">
                <x-card title="Most Commented">
                    @slot('subtitle')
                        What people are currently talking about
                    @endslot
                    @slot('items')
                        @foreach ($mostCommented as $post)
                            <li class="list-group-item"><a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a></li>
                        @endforeach
                    @endslot
                </x-card>
            </div>

            <div class="row mt-4">
                <x-card title="Most Active">
                    @slot('subtitle')
                        Members with the most Posts written
                    @endslot
                    @slot('items', collect($mostActive)->pluck('name'))
                </x-card>
            </div>

            <div class="row mt-4">
                <x-card title="Most Active Last Month">
                    @slot('subtitle')
                        Users with most posts written in the month
                    @endslot
                    @slot('items', collect($mostActiveLastMonth)->pluck('name'))
                </x-card>
            </div>

        </div>
    </div>
</div>
@endsection('content')
