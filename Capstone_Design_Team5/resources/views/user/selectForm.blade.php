@extends('master')

@section('content')

    <h1>회원 가입 유형을 선택하세요</h1>

    <button onclick="location.href='{{ URL::to('register/user') }}'" class="btn btn-light">
        개인회원
    </button>

    <button onclick="location.href='{{ URL::to('register/owner') }}'" class="btn btn-light">
        사장회원
    </button>
@endsection