<?php

namespace App\Http\Controllers;

use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use \App\Review;
use App\Order_List;

class MainController extends Controller
{
    public function showMainPage(Request $request) {

       if($request->session()->has('restaurantId'))
       {
           // 사장일 경우 레스토랑 페이지로 자동 이동
           $restaurantId = $request->session()->get('restaurantId');

           $link = 'owner/' . $restaurantId . '/menu';

           return Redirect::to($link);
       }

        return view('user.userMain');
    }

    public function getReviewData() {
        $review = Review::join('restaurants', 'review.shop_id', '=', 'restaurants.id')
            ->select('restaurants.*', DB::raw('MAX(review.reg_date)'))
            ->groupBy('review.shop_id')
            ->get()
            ->toArray();

        return var_dump($review);
    }

    public function getRecommendShopData() {

    }

    public function getOrderList() {



    }



}
