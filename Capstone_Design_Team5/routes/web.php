<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route Test
Route::get('login', function () {

    $user = [
        'id' => 'aaa',
        'password' => 'aaa'
    ];

    if( !auth()->attempt($user)) {
        return 'false';
    }

});

Route::get('main', function () {
    if( !auth()->check())
        return 'false';

    return auth()->user()->name . '님 환영합니다';
});
*/

Route::get('createRestaurant', array(
    'as' => 'restaurant.showRestaurantForm',
    'uses' => 'RestaurantController@showRestaurantForm'
));

// <-- Show Main Page
Route::get('main', array(
    'as' => 'main.showMainPage',
    'uses' => 'MainController@showMainPage'
));

Route::get('/', array(
    'as' => 'main.showMainPage',
    'uses' => 'MainController@showMainPage'
));

// <-- Show Login Form
Route::get('login', [
    'as' => 'users.showLogin',
    'uses' => 'UsersController@showLogin'
]);

// <-- Login Request Process
Route::post('login', [
    'as' => 'users.doLogin',
    'uses' => 'UsersController@doLogin'
]);

// <-- Logout Process
Route::get('logout', [
    'as' => 'users.doLogout',
    'uses' => 'UsersController@doLogout'
]);

// <-- select Type
Route::get('register/selectType', function (){
    return view('user.selectForm');
});

// <-- show Register Form
Route::get('register/user', function (){
    return view('user.userRegisterForm');
});

Route::get('register/owner', function (){
    return view('user.ownerRegisterForm');
});

Route::post('register', [
    'as' => 'register.createMember',
    'uses' => 'RegisterController@createMember'
]);

Route::get('createRestaurant', array(
    'as' => 'restaurant.showRestaurantForm',
    'uses' => 'RestaurantController@showRestaurantForm'
));

Route::post('createRestaurant', [
    'as' => 'restaurant.createRestaurant',
    'uses' => 'RestaurantController@createRestaurant'
]);

/*
Route::get('restaurant/{shop_id}/info', function (){
    return view('user.userRestaurant');
});*/
/*
Route::get('restaurant/{shop_id}/info', [
    'as' => 'restaurant.showRestaurantInfo',
    'uses' => 'RestaurantController@showRestaurantInfo'
]);*/

Route::get('restaurant/info', function () {
   return view('user.userRestaurant');
});

Route::post('restaurant/info', [
    'as' => 'restaurant.showRestaurantInfo',
    'uses' => 'RestaurantController@showRestaurantInfo'
]) ;


Route::get('createCoupon', function () {
    return view('restaurant.createCoupon');
});

Route::get('review', [
   'as' =>  'review.showReview',
    'uses' => 'ReviewController@showReview'
]);

Route::get('review/writeReview', [
    'as' =>  'review.showReviewForm',
    'uses' => 'ReviewController@showReviewForm'
]);

Route::post('review/writeReview', [
    'as' =>  'review.createReview',
    'uses' => 'ReviewController@createReview'
]);

// <-- Test
Route::get('test',[
    'as' =>  'main.test',
    'uses' => 'MainController@test'
]);

// <-- Image Route
Route::get('images/{shop_id}/{image}', function($shop_id, $image = null)
{
    $path = storage_path().'/app/public/img/' . $shop_id.'/' .$image;
    if (file_exists($path)) {
        return Response::download($path);
    }
    else
        return $path;
});

Route::get('images/review/{image}', function($image = null)
{
    $path = storage_path().'/app/public/img/review' .$image;

    if (file_exists($path)) {
        return Response::download($path);
    }
    else
        return $path;
});


