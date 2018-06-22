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

    Route::get('/topList', array(
        'as' => 'main.showMainPage',
        'uses' => 'MainController@showMainPage'
    ));

    Route::get('/search', array(
        'as' => 'main.showMainPage',
        'uses' => 'MainController@showMainPage'
    ));

    Route::post('/getSearchData', array(
        'as' => 'main.getSearchData',
        'uses' => 'MainController@getSearchData'
    ));

    Route::post('/getUserOrderList', array(
        'as' => 'main.getUserOrderList',
        'uses' => 'MainController@getUserOrderList'
    ));

    Route::post('/getUserCouponList', array(
        'as' => 'main.getUserCouponList',
        'uses' => 'MainController@getUserCouponList'
    ));

    Route::post('/getUserReservationList', array(
        'as' => 'main.getUserReservationList',
        'uses' => 'MainController@getUserReservationList'
    ));

    Route::post('/getUserReservationOrderInfo', array(
        'as' => 'main.getUserReservationOrderInfo',
        'uses' => 'MainController@getUserReservationOrderInfo'
    ));

    Route::post('/getRecommendShopData', array(
        'as' => 'main.getRecommendShopData',
        'uses' => 'MainController@getRecommendShopData'
    ));

    Route::post('/getRegionShopData', array(
        'as' => 'main.getRegionShopData',
        'uses' => 'MainController@getRegionShopData'
    ));

    Route::post('/getTypeShopData', array(
        'as' => 'main.getTypeShopData',
        'uses' => 'MainController@getTypeShopData'
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

// <-- User Info Get
    Route::post('getUserInfo', [
        'as' => 'users.getUserInfo',
        'uses' => 'UsersController@getUserInfo'
    ]);

// <-- User Info Edit
    Route::post('editUserInfo', [
        'as' => 'users.editUserInfo',
        'uses' => 'UsersController@editUserInfo'
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

    Route::post('owner/updateRestaurantInfo', [
        'as' => 'restaurant.updateRestaurantInfo',
        'uses' => 'RestaurantController@updateRestaurantInfo'
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

    Route::get('menu/getMenu/{shop_id}/{category}', [
        'as' => 'menu.getMenu',
        'uses' => 'MenuController@getMenu'
    ]);

    Route::post('menu/getLayoutNumber', [
        'as' => 'menu.getLayoutNumber',
        'uses' => 'MenuController@getLayoutNumber'
    ]);

    Route::post('restaurantsLike', [
        'as' => 'restaurant.restaurantsLike',
        'uses' => 'RestaurantController@restaurantsLike'
    ]);

    Route::post('getShopLikeData', [
        'as' => 'main.getShopLikeData',
        'uses' => 'MainController@getShopLikeData'
    ]);

// <-- User Order Page
    Route::post('makeOrder', [
        'as' => 'order.makeOrder',
        'uses' => 'OrderController@makeOrder'
    ]);

    Route::post('translateOrder', [
        'as' => 'order.translateOrder',
        'uses' => 'OrderController@translateOrder'
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

    Route::post('saveCustomLayout', [
        'as' => 'layout.saveCustomLayout',
        'uses' => 'LayoutController@saveCustomLayout'
    ]);

    Route::post('saveSelectedLayout', [
        'as' => 'layout.saveSelectedLayout',
        'uses' => 'LayoutController@saveSelectedLayout'
    ]);

    Route::post('updateCustomLayout', [
        'as' => 'layout.updateCustomLayout',
        'uses' => 'LayoutController@updateCustomLayout'
    ]);

    Route::post('loadCustomLayout', [
        'as' => 'layout.loadCustomLayout',
        'uses' => 'LayoutController@loadCustomLayout'
    ]);

    Route::post('deleteSelectedLayout', [
        'as' => 'layout.deleteSelectedLayout',
        'uses' => 'LayoutController@deleteSelectedLayout'
    ]);




    Route::post('deleteMenu', [
        'as' => 'menu.deleteMenu',
        'uses' => 'MenuController@deleteMenu'
    ]);

    Route::post('updateMenu', [
        'as' => 'menu.updateMenu',
        'uses' => 'MenuController@updateMenu'
    ]);

// <-- User Coupon Page
    Route::post('userCouponCreate', [
        'as' => 'coupon.userCouponCreate',
        'uses' => 'CouponController@userCouponCreate'
    ]);

    Route::post('getCouponList', [
        'as' => 'coupon.getCouponList',
        'uses' => 'CouponController@getCouponList'
    ]);

    Route::post('getCouponTransData', [
        'as' => 'coupon.getCouponTransData',
        'uses' => 'CouponController@getCouponTransData'
    ]);

    Route::post('setCouponUpdate', [
        'as' => 'coupon.setCouponUpdate',
        'uses' => 'CouponController@setCouponUpdate'
    ]);

    Route::post('deleteUserCoupon', [
        'as' => 'coupon.deleteUserCoupon',
        'uses' => 'CouponController@deleteUserCoupon'
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

    Route::post('/userReservationWaitCancel',[
        'as' => 'reservation.userReservationWaitCancel',
        'uses' => 'ReservationController@userReservationWaitCancel'
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

    Route::post('/updateReservationSelectMenu', [
        'as' => 'reservation.updateReservationSelectMenu',
        'uses' =>  'ReservationController@updateReservationSelectMenu'
    ]);

    Route::post('/getReservationMenuList', [
        'as' => 'reservation.getReservationMenuList',
        'uses' =>  'ReservationController@getReservationMenuList'
    ]);

    Route::post('/setOwnerReservation', [
        'as' => 'reservation.setOwnerReservation',
        'uses' =>  'ReservationController@setOwnerReservation'
    ]);



// <— Owner Statistics Page
    Route::get('/owner/{shop_id}/totalStatistics', [
        'as' => 'statistic.showStatisticsForm',
        'uses' => 'StatisticController@showStatisticsForm'
    ]);

    Route::post('/owner/getRatingScore', [
        'as' => 'statistic.getRatingScore',
        'uses' => 'StatisticController@getRatingScore'
    ]);

    Route::post('/owner/getCustomerScore', [
        'as' => 'statistic.getCustomerScore',
        'uses' => 'StatisticController@getCustomerScore'
    ]);

    Route::post('/owner/getGenderScore', [
        'as' => 'statistic.getGenderScore',
        'uses' => 'StatisticController@getGenderScore'
    ]);

    Route::post('/owner/getAgeScore', [
        'as' => 'statistic.getAgeScore',
        'uses' => 'StatisticController@getAgeScore'
    ]);

    Route::post('/owner/getCountryScore', [
        'as' => 'statistic.getCountryScore',
        'uses' => 'StatisticController@getCountryScore'
    ]);

    Route::post('/owner/getMenuData', [
        'as' => 'statistic.getMenuData',
        'uses' => 'StatisticController@getMenuData'
    ]);

    Route::post('/owner/getSalesData', [
        'as' => 'statistic.getSalesData',
        'uses' => 'StatisticController@getSalesData'
    ]);

    Route::post('/owner/getSalesMenuData', [
        'as' => 'statistic.getSalesMenuData',
        'uses' => 'StatisticController@getSalesMenuData'
    ]);

    Route::post('/owner/getCustomerNumber', [
        'as' => 'statistic.getCustomerNumber',
        'uses' => 'StatisticController@getCustomerNumber'
    ]);

    Route::post('/owner/getSalesNumber', [
        'as' => 'statistic.getSalesNumber',
        'uses' => 'StatisticController@getSalesNumber'
    ]);

    Route::post('/owner/getGenderSalesData', [
        'as' => 'statistic.getGenderSalesData',
        'uses' => 'StatisticController@getGenderSalesData'
    ]);

    Route::post('/owner/getCountrySalesData', [
        'as' => 'statistic.getCountrySalesData',
        'uses' => 'StatisticController@getCountrySalesData'
    ]);

    Route::post('/owner/getAgesSalesData', [
        'as' => 'statistic.getAgesSalesData',
        'uses' => 'StatisticController@getAgesSalesData'
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

    // <-- User Menu Route
    Route::get('/userCoupon', [
        'as' => 'main.showUserMenuPage',
        'uses' => 'MainController@showUserMenuPage'
    ]);

    Route::get('/userPageReservation', [
        'as' => 'main.showUserMenuPage',
        'uses' => 'MainController@showUserMenuPage'
    ]);

    Route::get('/userOrderHistory', [
        'as' => 'main.showUserMenuPage',
        'uses' => 'MainController@showUserMenuPage'
    ]);

    Route::get('/userReviewHistory', [
        'as' => 'main.showUserMenuPage',
        'uses' => 'MainController@showUserMenuPage'
    ]);

    Route::get('/editInformation', [
        'as' => 'main.showUserMenuPage',
        'uses' => 'MainController@showUserMenuPage'
    ]);

});

/*
// <— Test
Route::get('translatedText',[
    'as' =>  'main.translatedText',
    'uses' => 'MainController@translatedText'
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