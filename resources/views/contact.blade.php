@extends('layout')


@section('content')
	<h1>Contact</h1>
    <p>hello this is contact</p>

    @can('home.secret')
        <p>
            <a href="{{ route('secret')}}">
                Go to special contact details!
            </a>
        </p>
    @endcan
@endsection



