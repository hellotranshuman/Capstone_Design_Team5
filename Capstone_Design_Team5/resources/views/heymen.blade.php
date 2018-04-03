<!-- <meta name="csrf-token" content="{{csrf_token()}}"> -->

<?php
// 데이터 넘어가는거 확인용
// echo print_r($_POST); 

foreach ($_GET as $key => $value){
    echo "$key : $value <br>";
}
echo '-------------------------------------<br>';
foreach ($_FILES as $key => $value){
    echo "$key : $value <br>";
}
?>