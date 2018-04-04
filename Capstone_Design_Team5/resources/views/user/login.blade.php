
<!doctype html>
<html>
<head>
<title>--Login--</title>
</head>
<body>

<h1>Login</h1>

<p>
    {{ $errors->first('id') }}
    {{ $errors->first('password') }}
</p>

<form method="post" action="{{ route('users.doLogin') }}">
{!! csrf_field() !!}
    ID : <input type="text" name="id" value="{{ old('id') }}">
    PW : <input type="text" name="password" value="{{ old('password') }}">
    <button type="submit">
        Sign in
    </button>
</form>

<button onclick="location.href='{{ URL::to('register/selectType') }}'">
 회원가입
</button>

