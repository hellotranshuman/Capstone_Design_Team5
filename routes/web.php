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

    /* Main Page */

    // <-- Show Main Page
    Route::get('/', array(
        'as' => 'main.showMainPage',
        'uses' => 'MainController@showMainPage'
    ));

    // <-- Show Recommend Restaurant List Page
    Route::get('/topList', array(
        'as' => 'main.showMainPage',
        'uses' => 'MainController@showMainPage'
    ));

    // <-- Show Search Result Page
    Route::get('/search', array(
        'as' => 'main.showMainPage',
        'uses' => 'MainController@showMainPage'
    ));

    // <-- Get Search Restaurant Data
    Route::post('/getSearchData', array(
        'as' => 'main.getSearchData',
        'uses' => 'MainController@getSearchData'
    ));

    // <-- Get User's GPS Data and get Current Location Restaurant Data
    Route::post('/getGPSData', array(
        'as' => 'main.getGPSData',
        'uses' => 'MainController@getGPSData'
    ));

    // <-- Get Recommend Shop by User Rating Data
    Route::post('/getRecommendShopData', array(
        'as' => 'main.getRecommendShopData',
        'uses' => 'MainController@getRecommendShopData'
    ));

    // <-- Get Region Restaurants Data by User Rating
    Route::post('/getRegionShopData', array(
        'as' => 'main.getRegionShopData',
        'uses' => 'MainController@getRegionShopData'
    ));

    // <-- Get Type Restaurants Data by User Rating
    Route::post('/getTypeShopData', array(
        'as' => 'main.getTypeShopData',
        'uses' => 'MainController@getTypeShopData'
    ));

    // <-- Login
    Route::post('login', [
        'as' => 'users.doLogin',
        'uses' => 'UsersController@doLogin'
    ]);

    // <-- Logout
    Route::get('logout', [
        'as' => 'users.doLogout',
        'uses' => 'UsersController@doLogout'
    ]);

    // <-- Show Register Page
    Route::post('register', [
        'as' => 'register.createMember',
        'uses' => 'RegisterController@createMember'
    ]);

    //* Owner Restaurant */

    // <-- Show Restaurant Create
    Route::get('owner/createRestaurant', array(
        'as' => 'restaurant.showRestaurantForm',
        'uses' => 'RestaurantController@showRestaurantForm'
    ));

    // <-- Show Edit Restaurant Page
    Route::get('owner/{shop_id}/editRestaurant', array(
        'as' => 'restaurant.showRestaurantForm',
        'uses' => 'RestaurantController@showRestaurantForm'
    ));

    // <-- Registration Restaurant Data
    Route::post('owner/createRestaurant', [
        'as' => 'restaurant.createRestaurant',
        'uses' => 'RestaurantController@createRestaurant'
    ]);

    // <-- Update Restaurant Data
    Route::post('owner/updateRestaurantInfo', [
        'as' => 'restaurant.updateRestaurantInfo',
        'uses' => 'RestaurantController@updateRestaurantInfo'
    ]);

    /* User Restaurant Route */

    // <-- Show Restaurant Page
    Route::get('restaurant/{shop_id}/info', [
        'as' => 'restaurant.showRestaurantInfoForm',
        'uses' => 'RestaurantController@showRestaurantInfoForm'
    ]);

    // <-- Get Restaurant Info
    Route::get('restaurant/{shop_id}/getInfo', [
        'as' => 'restaurant.showRestaurantInfo',
        'uses' => 'RestaurantController@showRestaurantInfo'
    ]);

    // <-- Show Restaurant Menu Page
    Route::get('restaurant/{shop_id}/menu', [
        'as' => 'menu.showUserMenuForm',
        'uses' => 'MenuController@showUserMenuForm'
    ]);

    // <-- Get Menu Category Data
    Route::post('menu/getCategory', [
        'as' => 'menu.getCategory',
        'uses' => 'MenuController@getCategory'
    ]);

    // <-- Get Menu Data By Category
    Route::get('menu/getMenu/{shop_id}/{category}', [
        'as' => 'menu.getMenu',
        'uses' => 'MenuController@getMenu'
    ]);

    // <-- Get Selected Layout Data
    Route::post('menu/getLayoutNumber', [
        'as' => 'menu.getLayoutNumber',
        'uses' => 'MenuController@getLayoutNumber'
    ]);

    // <-- Restaurant Like
    Route::post('restaurantsLike', [
        'as' => 'restaurant.restaurantsLike',
        'uses' => 'RestaurantController@restaurantsLike'
    ]);

    // <-- Get User's Restaurant Like Data
    Route::post('getShopLikeData', [
        'as' => 'main.getShopLikeData',
        'uses' => 'MainController@getShopLikeData'
    ]);

    /* User Order Page */

    // <-- Make Order
    Route::post('makeOrder', [
        'as' => 'order.makeOrder',
        'uses' => 'OrderController@makeOrder'
    ]);

    // <-- Translate Order Data
    Route::post('translateOrder', [
        'as' => 'order.translateOrder',
        'uses' => 'OrderController@translateOrder'
    ]);

    /* Owner Menu Setting */

    // <-- Show Menu Registration Page
    Route::get('owner/{shop_id}/menuOperate',[
        'as' => 'menu.showCreateMenuForm',
        'uses' => 'MenuController@showCreateMenuForm'
    ]);

    // <-- Create Menu
    Route::post('owner/createMenu',[
        'as' => 'menu.createMenu',
        'uses' => 'MenuController@createMenu'
    ]);

    // <-- Show MenuList Page 
    Route::get('owner/{shop_id}/menuList', [
        'as' => 'menu.showMenuList',
        'uses' => 'MenuController@showMenuList'
    ]);

    // <-- Show MenuLayout Setting Page
    Route::get('owner/{shop_id}/menuLayout', [
        'as' => 'menu.showMenuLayout',
        'uses' => 'MenuController@showMenuLayout'
    ]);

    // <-- Get Selected Layout Data
    Route::get('owner/{shop_id}/getLayout', [
        'as' => 'layout.getSelectedLayout',
        'uses' => 'LayoutController@getSelectedLayout'
    ]);

    // <-- Save Custom Layout Data
    Route::post('saveCustomLayout', [
        'as' => 'layout.saveCustomLayout',
        'uses' => 'LayoutController@saveCustomLayout'
    ]);

    // <-- Save Current Select Layout Setting
    Route::post('saveSelectedLayout', [
        'as' => 'layout.saveSelectedLayout',
        'uses' => 'LayoutController@saveSelectedLayout'
    ]);

    // <-- Update Custom Layout Data
    Route::post('updateCustomLayout', [
        'as' => 'layout.updateCustomLayout',
        'uses' => 'LayoutController@updateCustomLayout'
    ]);

    // <-- Load Custom Layout Data
    Route::post('loadCustomLayout', [
        'as' => 'layout.loadCustomLayout',
        'uses' => 'LayoutController@loadCustomLayout'
    ]);

    // <-- Delete Custom Layout Data
    Route::post('deleteSelectedLayout', [
        'as' => 'layout.deleteSelectedLayout',
        'uses' => 'LayoutController@deleteSelectedLayout'
    ]);

    // <-- Delete Menu Data
    Route::post('deleteMenu', [
        'as' => 'menu.deleteMenu',
        'uses' => 'MenuController@deleteMenu'
    ]);

    // <-- Update Menu Data
    Route::post('updateMenu', [
        'as' => 'menu.updateMenu',
        'uses' => 'MenuController@updateMenu'
    ]);

    /* User Coupon Page */

    // <-- Create User Coupon Download Data
    Route::post('userCouponCreate', [
        'as' => 'coupon.userCouponCreate',
        'uses' => 'CouponController@userCouponCreate'
    ]);

    // <-- Get Current User Coupon Data
    Route::post('getCouponList', [
        'as' => 'coupon.getCouponList',
        'uses' => 'CouponController@getCouponList'
    ]);

    // <-- Get Coupon Translate Data
    Route::post('getCouponTransData', [
        'as' => 'coupon.getCouponTransData',
        'uses' => 'CouponController@getCouponTransData'
    ]);

    // <-- Update Coupon Data (Coupon Use)
    Route::post('setCouponUpdate', [
        'as' => 'coupon.setCouponUpdate',
        'uses' => 'CouponController@setCouponUpdate'
    ]);

    // <-- Delete User Coupon
    Route::post('deleteUserCoupon', [
        'as' => 'coupon.deleteUserCoupon',
        'uses' => 'CouponController@deleteUserCoupon'
    ]);

    /* Owner Coupon Page */

    // <-- Show Create Coupon Page
    Route::get('owner/{shop_id}/createCoupon', [
        'as' => 'coupon.showCouponForm',
        'uses' => 'CouponController@showCouponForm'
    ]);

    // <-- Create Coupon Data
    Route::post('owner/createCoupon', [
        'as' => 'coupon.createCoupon',
        'uses' => 'CouponController@createCoupon'
    ]);

    // <-- Get Coupon List Data
    Route::post('owner/getCouponList', [
        'as' => 'coupon.getCouponList',
        'uses' => 'CouponController@getCouponList'
    ]);

    // <-- Delete Coupon Data
    Route::post('owner/deleteCoupon', [
        'as' => 'coupon.deleteCoupon',
        'uses' => 'CouponController@deleteCoupon'
    ]);

    /* User Review Route */

    // <-- Show Restaurant Review Page
    Route::get('restaurant/{shop_id}/review', [
        'as' => 'review.showReviewForm',
        'uses' => 'ReviewController@showReviewForm'
    ]);

    // <-- Show Restaurant Review Write Page
    Route::get('restaurant/{shop_id}/writeReview', [
        'as' =>  'review.showWriteReviewForm',
        'uses' => 'ReviewController@showWriteReviewForm'
    ]);

    // <-- Create Review Data
    Route::post('review/writeReview', [
        'as' =>  'review.createReview',
        'uses' => 'ReviewController@createReview'
    ]);

    // <-- Get Review Data
    Route::post('review', [
        'as' =>  'review.getReviewData',
        'uses' => 'ReviewController@getReviewData'
    ]);

    // <-- Create Review Like Data
    Route::post('review/like', [
        'as' =>  'review.getReviewLike',
        'uses' => 'ReviewController@getReviewLike'
    ]);

    // <-- Get Current User's Review Data
    Route::post('getUserReviewList', [
        'as' =>  'review.getUserReviewList',
        'uses' => 'ReviewController@getUserReviewList'
    ]);

    /* User Reservation Route */

    // <-- Show Reservation Form
    Route::get('/restaurant/{shop_id}/addReservation',[
        'as' => 'reservation.showAddReservationForm',
        'uses' => 'ReservationController@showAddReservationForm'
    ]);

    // <-- Request Reservation
    Route::post('/requestReservation',[
        'as' => 'reservation.requestReservation',
        'uses' => 'ReservationController@requestReservation'
    ]);

    // <-- Cancel Reservation (Status : Wait)
    Route::post('/userReservationWaitCancel',[
        'as' => 'reservation.userReservationWaitCancel',
        'uses' => 'ReservationController@userReservationWaitCancel'
    ]);

    /* Owner Reservation List */

    // <-- Show Reservation List Page
    Route::get('/owner/{shop_id}/ownerReservationList', [
        'as' => 'reservation.showReservationList',
        'uses' => 'ReservationController@showReservationList'
    ]);

    // <-- Show Reservation Accept Page
    Route::get('/owner/{shop_id}/ownerReservationAccept', [
        'as' => 'reservation.showReservationAccept',
        'uses' => 'ReservationController@showReservationAccept'
    ]);

    // <-- Show Reservation Setting Page
    Route::get('/owner/{shop_id}/ownerReservationSetting', [
        'as' => 'reservation.showReservationSetting',
        'uses' => 'ReservationController@showReservationSetting'
    ]);

    // <-- Get Reservation Request List Data
    Route::post('/getReservationRequestList', [
        'as' => 'reservation.getReservationRequestList',
        'uses' => 'ReservationController@getReservationRequestList'
    ]);

    // <-- Save Reservation Accept Data
    Route::post('/acceptReservation', [
        'as' => 'reservation.acceptReservation',
        'uses' => 'ReservationController@acceptReservation'
    ]);

    // <-- Get Reservation List Data
    Route::post('/getReservationList', [
        'as' => 'reservation.getReservationList',
        'uses' => 'ReservationController@getReservationList'
    ]);

    // <-- Save Reservation Setting Data
    Route::post('/setReservationSetting', [
       'as' => 'reservation.setReservationSetting',
       'uses' =>  'ReservationController@setReservationSetting'
    ]);

    // <-- Get Reservation Setting List Data
    Route::post('/getReservationSettingList', [
        'as' => 'reservation.getReservationSettingList',
        'uses' =>  'ReservationController@getReservationSettingList'
    ]);

    // <-- Delete Reservation Setting Data
    Route::post('/deleteReservationSetting', [
        'as' => 'reservation.deleteReservationSetting',
        'uses' =>  'ReservationController@deleteReservationSetting'
    ]);

    // <-- Get Reservation Setting List Data by Date
    Route::post('/getReservationSettingByDate', [
        'as' => 'reservation.getReservationSettingByDate',
        'uses' =>  'ReservationController@getReservationSettingByDate'
    ]);

    // <-- Update Reservation Setting Data- Select Menu
    Route::post('/updateReservationSelectMenu', [
        'as' => 'reservation.updateReservationSelectMenu',
        'uses' =>  'ReservationController@updateReservationSelectMenu'
    ]);

    // <-- Get Reservation Setting Data- Select Menu
    Route::post('/getReservationMenuList', [
        'as' => 'reservation.getReservationMenuList',
        'uses' =>  'ReservationController@getReservationMenuList'
    ]);

    // <-- Create Owner Reservation Data
    Route::post('/setOwnerReservation', [
        'as' => 'reservation.setOwnerReservation',
        'uses' =>  'ReservationController@setOwnerReservation'
    ]);

    /* Owner Statistics Page */

    // <-- Show Statistics Page
    Route::get('/owner/{shop_id}/totalStatistics', [
        'as' => 'statistic.showStatisticsForm',
        'uses' => 'StatisticController@showStatisticsForm'
    ]);

    // <-- Get Rating Score Data
    Route::post('/owner/getRatingScore', [
        'as' => 'statistic.getRatingScore',
        'uses' => 'StatisticController@getRatingScore'
    ]);

    // <-- Get Customer Score Data
    Route::post('/owner/getCustomerScore', [
        'as' => 'statistic.getCustomerScore',
        'uses' => 'StatisticController@getCustomerScore'
    ]);

    // <-- Get Customer Gender Score Data
    Route::post('/owner/getGenderScore', [
        'as' => 'statistic.getGenderScore',
        'uses' => 'StatisticController@getGenderScore'
    ]);

    // <-- Get Customer Age Score Data
    Route::post('/owner/getAgeScore', [
        'as' => 'statistic.getAgeScore',
        'uses' => 'StatisticController@getAgeScore'
    ]);

    // <-- Get Customer Country Score Data
    Route::post('/owner/getCountryScore', [
        'as' => 'statistic.getCountryScore',
        'uses' => 'StatisticController@getCountryScore'
    ]);

    // <-- Get Menu Statistics Data
    Route::post('/owner/getMenuData', [
        'as' => 'statistic.getMenuData',
        'uses' => 'StatisticController@getMenuData'
    ]);

    // <-- Get Sales Statistics Data
    Route::post('/owner/getSalesData', [
        'as' => 'statistic.getSalesData',
        'uses' => 'StatisticController@getSalesData'
    ]);

    // <-- Get Sales Menu Statistics Data
    Route::post('/owner/getSalesMenuData', [
        'as' => 'statistic.getSalesMenuData',
        'uses' => 'StatisticController@getSalesMenuData'
    ]);

    // <-- Get Customer Number Data
    Route::post('/owner/getCustomerNumber', [
        'as' => 'statistic.getCustomerNumber',
        'uses' => 'StatisticController@getCustomerNumber'
    ]);

    // <-- Get Customer Sales Data
    Route::post('/owner/getSalesNumber', [
        'as' => 'statistic.getSalesNumber',
        'uses' => 'StatisticController@getSalesNumber'
    ]);

    // <-- Get Customer Gender Sales Data
    Route::post('/owner/getGenderSalesData', [
        'as' => 'statistic.getGenderSalesData',
        'uses' => 'StatisticController@getGenderSalesData'
    ]);

    // <-- Get Customer Country Sales Data
    Route::post('/owner/getCountrySalesData', [
        'as' => 'statistic.getCountrySalesData',
        'uses' => 'StatisticController@getCountrySalesData'
    ]);

    // <-- Get Customer Age Sales Data
    Route::post('/owner/getAgesSalesData', [
        'as' => 'statistic.getAgesSalesData',
        'uses' => 'StatisticController@getAgesSalesData'
    ]);

    /* Communication Routes */

    // <-- Show Emoticon List Page
    Route::post('/getEmoticonList', [
        'as' => 'communication.getEmoticonList',
        'uses' => 'CommunicationController@getEmoticonList'
    ]);

    // <-- Create User Emoticon Bookmark Data
    Route::post('/addUserBookmark', [
        'as' => 'communication.addUserBookmark',
        'uses' => 'CommunicationController@addUserBookmark'
    ]);

    /* User Menu Route */

    // <-- Show Current User's Coupon Page
    Route::get('/userCoupon', [
        'as' => 'main.showUserMenuPage',
        'uses' => 'MainController@showUserMenuPage'
    ]);

    // <-- Show Current User's Reservation Page
    Route::get('/userPageReservation', [
        'as' => 'main.showUserMenuPage',
        'uses' => 'MainController@showUserMenuPage'
    ]);

    // <-- Show Current User's OrderHistory Page
    Route::get('/userOrderHistory', [
        'as' => 'main.showUserMenuPage',
        'uses' => 'MainController@showUserMenuPage'
    ]);

    // <-- Show Current User's ReviewHistory Page
    Route::get('/userReviewHistory', [
        'as' => 'main.showUserMenuPage',
        'uses' => 'MainController@showUserMenuPage'
    ]);

    // <-- Show User Info Edit Page
    Route::get('/editInformation', [
        'as' => 'main.showUserMenuPage',
        'uses' => 'MainController@showUserMenuPage'
    ]);

    // <-- get User's Order List Data
    Route::post('/getUserOrderList', array(
        'as' => 'main.getUserOrderList',
        'uses' => 'MainController@getUserOrderList'
    ));

    // <-- Get User's Coupon List Data
    Route::post('/getUserCouponList', array(
        'as' => 'main.getUserCouponList',
        'uses' => 'MainController@getUserCouponList'
    ));

    // <-- Get User's Reservation List Data
    Route::post('/getUserReservationList', array(
        'as' => 'main.getUserReservationList',
        'uses' => 'MainController@getUserReservationList'
    ));

    // <-- Get Usesr's Current Reservation Order Data
    Route::post('/getUserReservationOrderInfo', array(
        'as' => 'main.getUserReservationOrderInfo',
        'uses' => 'MainController@getUserReservationOrderInfo'
    ));

    // <-- Get User Info Data
    Route::post('getUserInfo', [
        'as' => 'users.getUserInfo',
        'uses' => 'UsersController@getUserInfo'
    ]);

    // <-- Edit User Info
    Route::post('editUserInfo', [
        'as' => 'users.editUserInfo',
        'uses' => 'UsersController@editUserInfo'
    ]);
});

/* Image Route */

// <-- Restaurant Title Image, Gallery Image Route
Route::get('images/{shop_id}/{image}', function($shop_id, $image = null)
{
    $path = storage_path().'/app/public/img/' . $shop_id.'/' .$image;
    if (file_exists($path)) {
        return Response::download($path);
    }
    else
        return $path;
});

// <-- Menu Image Route
Route::get('images/menu/{shop_id}/{image}', function($shop_id, $image = null)
{
    $path = storage_path().'/app/public/img/menu/' . $shop_id.'/' .$image;
    if (file_exists($path)) {
        return Response::download($path);
    }
    else
        return $path;
});

// <-- Review Image Route
Route::get('images/review/{image}', function($image = null)
{
    $path = storage_path().'/app/public/img/review' .$image;

    if (file_exists($path)) {
        return Response::download($path);
    }
    else
        return $path;
});

// <-- Country Flag Image Route
Route::get('images/flag/{image}', function($image = null)
{
    $path = storage_path().'/app/public/img/flag' .$image;

    if (file_exists($path)) {
        return Response::download($path);
    }
    else
        return $path;
});

// <-- Template Image Route
Route::get('images/template/{image}', function($image = null)
{
    $path = storage_path().'/app/public/img/template' .$image;

    if (file_exists($path)) {
        return Response::download($path);
    }
    else
        return $path;
});

// <-- Communication Button Image Route
Route::get('images/emoticon/{image}', function($image = null)
{
    $path = storage_path().'/app/public/img/emoticon' .$image;

    if (file_exists($path)) {
        return Response::download($path);
    }
    else
        return $path;
});