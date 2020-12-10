<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js' )}}" defer></script>
    <title>Document</title>
</head>
<body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom shadow-sm mb-3">
        <h5 class="my-0 mr-md-auto font-weight-normal">Laravel app</h5>
        <nav class="my-2 my-md-0 mr-md-3" >
                <a class="p-2 text-dark" href="{{ route('home')}}">Home</a>
                <a class="p-2 text-dark" href="{{ route('contact')}}">Contact</a>
                {{-- <li><a class="p-2 text-dark" href="{{ route('blog-post', ['id'=>1])}}">Blog post</a></li> --}}
                <a class="p-2 text-dark" href="{{ route('posts.index')}}">Blog post</a>
                <a class="p-2 text-dark" href="{{ route('posts.create')}}">Add Blog Post</a>
        </nav>
    </div>

    {{-- <ul> --}}

    {{-- <li><a href="{{ route('home')}}">Home</a></li> --}}
    {{-- <li><a href="{{ route('contact')}}">Contact</a></li> --}}
    {{-- <li><a href="{{ route('blog-post', ['id'=>1])}}">Blog post</a></li> --}}
    {{-- <li><a href="{{ route('posts.index')}}">Blog post</a></li> --}}
    {{-- <li><a href="{{ route('posts.create')}}">Add Blog Post</a></li> --}}

    {{-- </ul> --}}

    <div class="container">
        @if(session()->has('status'))
            {{-- <p style="color: green">{{ session()->get('status')}}</p> --}}
            <div style="background: green;color:white">{{ session()->get('status')}}</div>

        @endif

    @yield('content')
    </div>
</body>
</html>
