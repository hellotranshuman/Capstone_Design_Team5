<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .aa {
        height : 300px;
    }
</style>
<body>
@foreach($totalRating as $total)
<p> {{ $total->totalRating}}</p>
@endforeach
@foreach($review as $re)
  <p> {{ $re->id }} </p>
  <p> {{ $re->content }} </p>
  <p> {{ $re->rating}}</p>
@endforeach
</body>
</html>