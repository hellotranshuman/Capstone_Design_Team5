<?php

namespace App\Http\Controllers;

use App\UserCoupon;
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

    // <-- 사용자 주문 내역 출력
    public function getUserOrderList() {
            // 전체 주문 내역
            $orderArray         = array();
            // 현재 주문번호의 주문 내역
            $currentOrderArray  = array();

            // 현재 유저의 전체 주문번호와 메뉴, 옵션 갯수 Count
            $orderCountData = Order_List::join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                                ->join('order_option', 'order_option.order_menu_id', 'order_menu.id')
                                ->select(DB::raw('order_list.order_num as order_num, 
                                           count(order_list.order_num) as orderCount'))
                                ->where('order_list.user_num', auth()->user()->id)
                                ->groupBy('order_list.order_num')
                                ->orderByRaw('order_list.order_date DESC')
                                ->get();

            // 현재 주문번호의 데이터 받아와 전체 주문 내역에 저장
            foreach ($orderCountData as $orderCount) {
                // 현재 주문번호의 행 갯수
                $currentOrderCount = $orderCount->orderCount;
                // 현재 주문번호
                $currentOrderNum = $orderCount->order_num;

                // 현재 주문번호의 데이터
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
                                    ->where('order_list.order_num', $currentOrderNum)
                                    ->orderByRaw('order_list.order_date DESC')
                                    ->get()
                                    ->toArray();

                // 메뉴 정보 Index
                $menuIndex      = 0;
                // 옵션 정보 Index
                $optionIndex    = 1;
                // 맨 처음 메뉴정보가 담겨있는지 확인할 때 사용할 Index Name
                $menuName       = 'menu_name1';

                // 현재 주문번호에 맞는 데이터 가져오기
                for ( $orderIndex = 0 ; $orderIndex < $currentOrderCount ; $orderIndex++ ) {

                    // 주문 기본 정보 삽입
                    if($orderIndex == 0) {
                        $currentOrderArray['order_num']         = $currentOrderNum;
                        $currentOrderArray['order_date']        = $orderListData[$orderIndex]['order_date'];
                        $currentOrderArray['restaurant_name']   = $orderListData[$orderIndex]['restaurant_name'];
                        $currentOrderArray['total']             = $orderListData[$orderIndex]['total'];
                    }

                    // 주문한 메뉴 정보 삽입
                    if($orderIndex == 0 || $currentOrderArray[$menuName] !=  $orderListData[$orderIndex]['menu_name']) {
                        $menuIndex++;
                        $optionIndex    = 1;

                        $menuName       = 'menu_name' . $menuIndex;
                        $menuPriceName  = 'menu_price' . $menuIndex;

                        $currentOrderArray[$menuName]       = $orderListData[$orderIndex]['menu_name'];
                        $currentOrderArray[$menuPriceName]  = $orderListData[$orderIndex]['menu_price'];
                    }

                    // 주문한 메뉴에 맞는 옵션 데이터 삽입
                    $optionName     = 'menu' . $menuIndex . '-option' . $optionIndex;
                    $subOptionName  = 'menu' . $menuIndex . '-subOption' . $optionIndex;

                    $currentOrderArray[$optionName]     = $orderListData[$orderIndex]['option_name'];
                    $currentOrderArray[$subOptionName]  = $orderListData[$orderIndex]['suboption_name'];

                    $optionIndex++;

                } // <-- for End
                // 현재 주문내역 -> 전체 주문내역에 저장
                array_push($orderArray, $currentOrderArray);

            } // <-- foreach End

            return response()->json([
               'order_data' => $orderArray,
            ]);

    }

    // <-- 사용자 예약 내역 출력
    public function getUserReservationList() {

    }

    // <-- 사용자 쿠폰 내역 출력
    public function getUserCouponList() {

      // 현재 사용자의 쿠폰 내역 조회
      $couponData =  UserCoupon::join('coupon', 'coupon.id', '=', 'user_coupon.coupon_id')
                        ->join('restaurants', 'restaurants.id', '=', 'coupon.shop_id')
                        ->join('menu', 'menu.id', '=', 'coupon.add_product')
                        ->select(DB::raw('user_coupon.id as id,
                                    coupon.name as coupon_name,
                                    coupon.category as category,
                                    coupon.discount as discount,
                                    coupon.price_condition as price_condition,
                                    menu.name as menu_name,
                                    restaurants.name as restaurants_name,
                                    user_coupon.use_check as use_check,
                                    user_coupon.start_date as start_date,
                                    user_coupon.expiry_date as expiry_date'))
                        ->where('user_coupon.user_num', auth()->user()->id)
                        ->get()
                        ->toArray();

      return response()->json([
         'coupon_data' => $couponData,
      ]);
    }


}
