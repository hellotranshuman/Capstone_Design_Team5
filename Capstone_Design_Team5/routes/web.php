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
Route::group(['middleware' => 'web'], function () {
    // <-- Show Main Page
    Route::get('/', array(
        'as' => 'main.showMainPage',
        'uses' => 'MainController@showMainPage'
    ));

    Route::get('/search', array(
        'as' => 'main.showMainPage',
        'uses' => 'MainController@showMainPage'
    ));

    Route::get('/test', array(
        'as' => 'main.getReviewData',
        'uses' => 'MainController@getReviewData'
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
    Route::get('register', function (){
        return view('user.selectForm');
    });

// <-- show Register Form
    Route::post('register', [
        'as' => 'register.createMember',
        'uses' => 'RegisterController@createMember'
    ]);

// <-- Owner Restaurant Route
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

// <-- user Restaurant Route
    Route::get('restaurant/{shop_id}/info', [
        'as' => 'restaurant.showRestaurantInfoForm',
        'uses' => 'RestaurantController@showRestaurantInfoForm'
    ]);

    Route::get('restaurant/{shop_id}/getInfo', [
        'as' => 'restaurant.showRestaurantInfo',
        'uses' => 'RestaurantController@showRestaurantInfo'
    ]);

    Route::get('restaurant/{shop_id}/menu', [
        'as' => 'menu.showUserMenuForm',
        'uses' => 'MenuController@showUserMenuForm'
    ]);

    Route::post('menu/getCategory', [
        'as' => 'menu.getCategory',
        'uses' => 'MenuController@getCategory'
    ]);
/*
    // Test
    Route::get('menu/getMenu', [
        'as' => 'menu.getMenu',
        'uses' => 'MenuController@getMenu'
    ]); */

    Route::get('menu/getMenu/{shop_id}/{category}', [
        'as' => 'menu.getMenu',
        'uses' => 'MenuController@getMenu'
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

    Route::get('owner/{shop_id}/menuLayout', [
        'as' => 'menu.showMenuLayout',
        'uses' => 'MenuController@showMenuLayout'
    ]);

    Route::get('owner/{shop_id}/getLayout', [
        'as' => 'layout.getSelectedLayout',
        'uses' => 'LayoutController@getSelectedLayout'
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

    Route::post('owner/deleteCoupon', [
        'as' => 'coupon.deleteCoupon',
        'uses' => 'CouponController@deleteCoupon'
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

    Route::post('review/like', [
        'as' =>  'review.getReviewLike',
        'uses' => 'ReviewController@getReviewLike'
    ]);

    Route::post('getUserReviewList', [
        'as' =>  'review.getUserReviewList',
        'uses' => 'ReviewController@getUserReviewList'
    ]);

// <— User Reservation Route

    Route::get('/restaurant/{shop_id}/addReservation',[
        'as' => 'reservation.showAddReservationForm',
        'uses' => 'ReservationController@showAddReservationForm'
    ]);

    Route::post('/requestReservation',[
        'as' => 'reservation.requestReservation',
        'uses' => 'ReservationController@requestReservation'
    ]);

// <— Owner Reservation List

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

    Route::post('/getReservationRequestList', [
        'as' => 'reservation.getReservationRequestList',
        'uses' => 'ReservationController@getReservationRequestList'
    ]);

    Route::post('/acceptReservation', [
        'as' => 'reservation.acceptReservation',
        'uses' => 'ReservationController@acceptReservation'
    ]);

    Route::post('/getReservationList', [
        'as' => 'reservation.getReservationList',
        'uses' => 'ReservationController@getReservationList'
    ]);

    Route::post('/setReservationSetting', [
       'as' => 'reservation.setReservationSetting',
       'uses' =>  'ReservationController@setReservationSetting'
    ]);

    Route::post('/getReservationSettingList', [
        'as' => 'reservation.getReservationSettingList',
        'uses' =>  'ReservationController@getReservationSettingList'
    ]);

    Route::post('/deleteReservationSetting', [
        'as' => 'reservation.deleteReservationSetting',
        'uses' =>  'ReservationController@deleteReservationSetting'
    ]);

    Route::post('/getReservationSettingByDate', [
        'as' => 'reservation.getReservationSettingByDate',
        'uses' =>  'ReservationController@getReservationSettingByDate'
    ]);

// <— Owner Statistics Page
    Route::get('/owner/{shop_id}/totalStatistics', [
        'as' => 'reservation.showReservationSetting',
        'uses' => 'ReservationController@showReservationSetting'
    ]);

    Route::get('/owner/{shop_id}/getRatingScore', [
        'as' => 'statistic.getRatingScore',
        'uses' => 'StatisticController@getRatingScore'
    ]);

// <-- Communication Routes

    Route::post('/getEmoticonList', [
        'as' => 'communication.getEmoticonList',
        'uses' => 'CommunicationController@getEmoticonList'
    ]);

    Route::post('/addUserBookmark', [
        'as' => 'communication.addUserBookmark',
        'uses' => 'CommunicationController@addUserBookmark'
    ]);
});

/*
// <— Test
Route::get('test',[
    'as' =>  'main.test',
    'uses' => 'MainController@test'
]);*/

// <— Image Route

// 가게 타이틀, 갤러리 이미지 Route
Route::get('images/{shop_id}/{image}', function($shop_id, $image = null)
{
    $path = storage_path().'/app/public/img/' . $shop_id.'/' .$image;
    if (file_exists($path)) {
        return Response::download($path);
    }
    else
        return $path;
});

// 메뉴 이미지 Route
Route::get('images/menu/{shop_id}/{image}', function($shop_id, $image = null)
{
    $path = storage_path().'/app/public/img/menu/' . $shop_id.'/' .$image;
    if (file_exists($path)) {
        return Response::download($path);
    }
    else
        return $path;
});

// 리뷰 이미지 Route
Route::get('images/review/{image}', function($image = null)
{
    $path = storage_path().'/app/public/img/review' .$image;

    if (file_exists($path)) {
        return Response::download($path);
    }
    else
        return $path;
});

// 국가 마크 이미지 Route
Route::get('images/flag/{image}', function($image = null)
{
    $path = storage_path().'/app/public/img/flag' .$image;

    if (file_exists($path)) {
        return Response::download($path);
    }
    else
        return $path;
});

// Template 이미지 Route

Route::get('images/template/{image}', function($image = null)
{
    $path = storage_path().'/app/public/img/template' .$image;

    if (file_exists($path)) {
        return Response::download($path);
    }
    else
        return $path;
});

// 커뮤니케이션 버튼 이미지 Route
Route::get('images/emoticon/{image}', function($image = null)
{
    $path = storage_path().'/app/public/img/emoticon' .$image;

    if (file_exists($path)) {
        return Response::download($path);
    }
    else
        return $path;
});