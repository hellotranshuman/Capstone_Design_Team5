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

Route::get('/', function () {
    return view('welcome');
});

// Route::post('/dataget', 'axiosTestController@createReview');

// Route::post('/dataget', [
//     'as' => 'axiosTest.createReview',
//     'uses' => 'axiosTestController@createReview'
// ]);

Route::post('/dataget', function () {
    return "a";
    //return view('dataGet');
});

Route::get('createCoupon', function () {
    return view('restaurant.createCoupon');
});
?>