@extends('master')

@section('content')
<div class="container">
    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="post" action="{{ route('restaurant.createRestaurantTest') }}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        타이틀이미지 : <input type="file" name="titleImg"/>
        <input type="file" name="img[]" multiple/>
        <br /><br />
        <input type="submit" value="Upload" />
    </form>
</div>
@endsection