<div class="form-group">
    <label for="title">Title</label>
    <input id="title" type="text" name="title" class="form-control" value="{{ old('title', $post->title ?? null) }}"/>
</div>

@error('title')
<div class="alert alert-danger">{{$message}}</div>
@enderror

<div class="form-group">
    <label for="content">Content</label>
    {{-- <textarea class="form-control" id="content" name="content" value="{{ old('content', $post->content ?? null) }}"/></textarea> --}}
    <input id="content" type="text" name="content" class="form-control" value="{{ old('content', $post->content ?? null) }}"/>
</div>

@if($errors->any())
    <div class="mb-3">
        <ul class="list-group">
            @foreach($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@endif
