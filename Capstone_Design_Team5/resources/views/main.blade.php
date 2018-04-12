@extends('master')

@section('content')


    {{-- {{auth()->user()->id}}
    {{auth()->user()->birthday}}
    {{auth()->user()->email}}
    {{auth()->user()->name . ' 님 환영합니다'}}
    <a href="{{ URL::to('logout') }}">Logout</a> --}}

<div id="app">
    <example></example>
</div>

<script src="{{ mix('js/app.js') }}"></script>
<link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
@endsection