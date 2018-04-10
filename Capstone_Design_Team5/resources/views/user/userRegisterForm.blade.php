@extends('master')

@section('content')
<div class="container">
<form method="post" action="{{ route('register.createMember') }}">
{!! csrf_field() !!}
    <input type="hidden" name="category" value="user">
    ID <input type="text" name="id" class="form-control"value="{{ old('id') }}" >
    {{ $errors->first('id') }}
    PW <input type="password" name="password" class="form-control" >
    {{ $errors->first('password') }}
    PW confirm <input type="password" name="password_confirmation" class="form-control" >
    {{ $errors->first('password_confirm') }}
    Name <input type="text" name="name" class="form-control" value="{{ old('name') }}" >
    {{ $errors->first('name') }}
    Email <input type="text" name="email" class="form-control" value="{{ old('email') }}" >
    {{ $errors->first('email') }}
    Gender<br/>
    male <input type="radio" name="gender" class="form-control" value="male" {{ (old('gender') == 'male') ? 'checked' : '' }}>
    Female <input type="radio" name="gender" class="form-control" value="female" {{ (old('gender') == 'female') ? 'checked' : '' }}>
    {{ $errors->first('gender') }}
    Country
    <select name = "country" size = "5" multiple class="form-control" >
        <option value = "korea" {{ (old('country') == 'korea') ? 'selected' : '' }}>korea</option>
        <option value = "japan" {{ (old('country') == 'japan') ? 'selected' : '' }}>japan</option>
        <option value = "china" {{ (old('country') == 'china') ? 'selected' : '' }}>china</option>
        <option value = "united states" {{ (old('country') == 'united states') ? 'selected' : '' }}>united states</option>
        <option value = "kazakhstan" {{ (old('kazakhstan') == 'korea') ? 'selected' : '' }}>Kazakhstan</option>
        <option value = "uzbekistan" {{ (old('country') == 'uzbekistan') ? 'selected' : '' }}>Uzbekistan</option>
    </select>
    {{ $errors->first('country') }}
    Date Of Birth <br/>
    Year
    <input type="text" name="year" class="form-control" value="{{ old('year') }}" >
    {{ $errors->first('year') }}
    Month
    <select name = "month" size = "3" multiple class="form-control">
        <option value = "1">1</option>
        <option value = "2">2</option>
        <option value = "3">3</option>
        <option value = "4">4</option>
        <option value = "5">5</option>
        <option value = "6">6</option>
        <option value = "7">7</option>
        <option value = "8">8</option>
        <option value = "9">9</option>
        <option value = "10">10</option>
        <option value = "11">11</option>
        <option value = "12">12</option>
    </select>
    {{ $errors->first('month') }}
    Day
    <input type="text" name="day" class="form-control" value="{{ old('day') }}" >
    {{ $errors->first('day') }}
    Favorite1
    <input type="text" name="favorite_1" class="form-control" value="{{ old('favorite_1') }}">
    Favorite2
    <input type="text" name="favorite_2" class="form-control" value="{{ old('favorite_2') }}">
    Favorite3
    <input type="text" name="favorite_3" class="form-control" value="{{ old('favorite_3') }}">

    <input type="submit" value="Join" class="btn btn-primary">

</form>
</div>
@endsection
