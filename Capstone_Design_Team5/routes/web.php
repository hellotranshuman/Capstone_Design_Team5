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
/*
Route::get('register', [
    'as' => 'register.showRegisterForm',
    'uses' => 'RegisterController@showRegisterForm'
]); */

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

// <-- User Restaurant Route
Route::get('owner/createRestaurant', array(
    'as' => 'restaurant.showRestaurantForm',
    'uses' => 'RestaurantController@showRestaurantForm'
));

Route::get('owner/{shop_id}/editRestaurant', array(
    'as' => 'restaurant.showRestaurantForm',
    'uses' => 'RestaurantController@showRestaurantForm'
));

Route::post('owner/createRestaurant', [
    'as' => 'restaurant.createRestaurant',
    'uses' => 'RestaurantController@createRestaurant'
]);

Route::get('restaurant/{shop_id}/info', [
    'as' => 'restaurant.showRestaurantInfoForm',
    'uses' => 'RestaurantController@showRestaurantInfoForm'
]);

Route::get('restaurant/{shop_id}/getInfo', [
    'as' => 'restaurant.showRestaurantInfo',
    'uses' => 'RestaurantController@showRestaurantInfo'
]);

// <-- Owner Menu Setting

Route::get('owner/{shop_id}/menu',[
    'as' => 'menu.showMenuForm',
    'uses' => 'MenuController@showMenuForm'
]);

Route::get('owner/{shop_id}/menuOperate',[
    'as' => 'menu.showCreateMenuForm',
    'uses' => 'MenuController@showCreateMenuForm'
]);

Route::post('owner/createMenu',[
    'as' => 'menu.createMenu',
    'uses' => 'MenuController@createMenu'
]);

Route::get('owner/{shop_id}/menuList', [
    'as' => 'menu.showMenuList',
    'uses' => 'MenuController@showMenuList'
]);

// <-- Owner Coupon Page
Route::get('owner/{shop_id}/createCoupon', [
    'as' => 'coupon.showCouponForm',
    'uses' => 'CouponController@showCouponForm'
]);

Route::post('owner/createCoupon', [
    'as' => 'coupon.createCoupon',
    'uses' => 'CouponController@createCoupon'
]);

Route::post('owner/getCouponList', [
    'as' => 'coupon.getCouponList',
    'uses' => 'CouponController@getCouponList'
]);

// <-- User Review Route
Route::get('restaurant/{shop_id}/review', [
    'as' => 'review.showReviewForm',
    'uses' => 'ReviewController@showReviewForm'
]);

Route::get('restaurant/{shop_id}/writeReview', [
    'as' =>  'review.showWriteReviewForm',
    'uses' => 'ReviewController@showWriteReviewForm'
]);

Route::post('review/writeReview', [
    'as' =>  'review.createReview',
    'uses' => 'ReviewController@createReview'
]);

Route::post('review', [
    'as' =>  'review.getReviewData',
    'uses' => 'ReviewController@getReviewData'
]);

// <-- User Reservation Route

Route::get('/restaurant/{shop_id}/addReservation',[
    'as' => 'reservation.showAddReservationForm',
    'uses' => 'ReservationController@showAddReservationForm'
]);

// <-- Owner Reservation List

Route::get('/owner/{shop_id}/ownerReservationList', [
   'as' => 'reservation.showReservationList',
   'uses' => 'ReservationController@showReservationList'
]);

Route::get('/owner/{shop_id}/ownerReservationAccept', [
    'as' => 'reservation.showReservationAccept',
    'uses' => 'ReservationController@showReservationAccept'
]);

Route::get('/owner/{shop_id}/ownerReservationSetting', [
    'as' => 'reservation.showReservationSetting',
    'uses' => 'ReservationController@showReservationSetting'
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


