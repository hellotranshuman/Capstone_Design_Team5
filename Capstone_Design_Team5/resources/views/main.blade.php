@extends('master')

@section('content')


    {{auth()->user()->id}}
    {{auth()->user()->birthday}}
    {{auth()->user()->email}}
    {{auth()->user()->name . ' 님 환영합니다'}}
    <a href="{{ URL::to('logout') }}">Logout</a>

<div id="app">
    <example></example>
</div>

<script src="{{ mix('js/app.js') }}"></script>

@endsection