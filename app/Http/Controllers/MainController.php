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

            // 현재 사용자의 주문 데이터 불러오기
            $orderListData = Order_List::join('users', 'users.id', '=', 'user_num')
                ->join('restaurants', 'order_list.shop_id', '=', 'restaurants.id')
                ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                ->join('order_option', 'order_option.order_menu_id', 'order_menu.id')
                ->join('menu_option', 'order_option.op_num', '=', 'menu_option.opnum')
                ->leftJoin('suboption', 'order_option.subop_num', '=', 'suboption.sub_opnum')
                ->select(DB::raw('order_list.order_num as order_num, 
                                        restaurants.name as restaurant_name,
                                        order_list.order_date as order_date,
                                        order_list.total as total,
                                        menu.name as menu_name,
                                        menu.price as menu_price,
                                        menu_option.name as option_name,
                                        suboption.name as suboption_name'))
                ->where('users.id', auth()->user()->id)
                ->get()
                ->toArray();

            return var_dump($orderListData);

    }



}
