@extends('layout')

@section('content')
<h1>{{ __('messages.welcome')}}</h1>
<p>{{ __('messages.example_with_value',['name' => 'John'])}}</p>
<h1>@lang('messages.welcome')</h1>

<p>{{ trans_choice('messages.plural', 0, ['a'=>1]) }}</p>
<p>{{ trans_choice('messages.plural', 1, ['a'=>1]) }}</p>
<p>{{ trans_choice('messages.plural', 2, ['a'=>1]) }}</p>

<p>UsingJSON: {{ __('Welcome to Laravel!')}}</p>
<p>UsingJSON: {{ __('Hello :name', ['name'=>'Sergio'])}}</p>



<p>this is the content</p>
@endsection
