<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Capstone Design Team5</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="app">
        </div>
    </body>

    <script>
        // window.Laravel을 설정하는 이유는 bootstrap.js에서 
        // window.Laravel.csrfToken을 axios 기본 헤더로 설정하고 있어서 
        // 에러가 나지 않도록 하려고 추가하였습니다.
           window.Laravel = 
           <?php echo json_encode(['csrfToken' => csrf_token()]); ?>
    </script>
    <script src="{{asset('js/app.js')}}"></script>
</html>