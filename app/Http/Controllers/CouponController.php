<?php

namespace App\Http\Controllers;

use App\Menu;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use \App\Coupon;
use \App\UserCoupon;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function showCouponForm() {
        return view('restaurant.createCoupon');
    }

    // <-- create Coupon in Coupon Table
    public function createCoupon(Request $request) {

        // 메뉴 제공을 선택했을 경우
        if($request->get('add_product') == 0)
            $addProduct = NULL;
        else
            $addProduct = $request->get('add_product');

         \App\Coupon::create([
            'name'            => $request->get('name'),
            'shop_id'         => $request->get('shop_id'),
            'category'        => $request->get('category'),
            'discount'        => $request->get('discount'),
            'price_condition' => $request->get('price_condition'),
            'start_date'      => $request->get('start_date'),
            'expiry_date'     => $request->get('expiry_date'),
            'coupon_count'     => $request->get('count'),
            'add_product'     => $addProduct,
        ]);

        return response()->json([
           'content' => true,
        ]);

    }

    // <-- get Coupon List in Coupon Table
    public function getCouponList(Request $request) {

        $couponList = Coupon::leftJoin('menu', 'menu.id', '=', 'coupon.add_product')
                        ->select(DB::raw('coupon.id as id, coupon.category as category,
                                           coupon.name as name, coupon.discount as discount,
                                           coupon.price_condition as price_condition,
                                           coupon.add_product as add_product,
                                           coupon.start_date as start_date,
                                           coupon.expiry_date as expiry_date,
                                           coupon.coupon_count as coupon_count,
                                           menu.name as menu_name'))
                        ->where('coupon.shop_id', $request->get('shop_id'))
                        ->get()
                        ->toArray();

        $couponNum = Coupon::where('shop_id', $request->get('shop_id'))
                        ->get()
                        ->count();

        $menuList = Menu::select('id', 'name')
                    ->where('shop_id', $request->get('shop_id'))
                    ->get()
                    ->toArray();

        return response()->json([
            'coupon'      => $couponList,
            'couponNum'   => $couponNum,
            'menuList'    => $menuList,
        ]);
    }

    // <-- 사장 쿠폰 삭제
    public function deleteCoupon(Request $request) {
        $couponId = $request->get('coupon_id');

        Coupon::where('id', '=' ,$couponId)
                ->delete();

        return response()->json([
           'msg'        => true,
        ]);
    }

    // <-- Add Coupon in User Coupon Table
    public function userCouponCreate(Request $request) {

        $currentCouponId = $request->get('id');

        // 현재 받을려는 쿠폰이 이미 존재하는 것인지 확인
        $userCouponCount = UserCoupon::where('user_num', auth()->user()->id)
                            ->where('coupon_id', $currentCouponId)
                            ->count();

        if($userCouponCount != 0)
            return response()->json([
               'msg' => false,
            ]);

        // 현재 받을려는 쿠폰 갯수 확인
        $couponData = Coupon::where('id', $currentCouponId)
                        ->get()
                        ->first();

        $expiryDate = $couponData->expiry_date;
        $startDate = $couponData->start_date;
        $couponCount = $couponData->coupon_count;

        if(is_null($couponCount) || $couponCount != 0) {
            UserCoupon::create([
                'user_num' => auth()->user()->id,
                'coupon_id' => $currentCouponId,
                'use_check' => false,
                'start_date' => $startDate,
                'expiry_date' => $expiryDate
            ]);

            if(!is_null($couponCount)) {

                Coupon::where('id', $currentCouponId)
                    ->update([
                       'coupon_count' => --$couponCount,
                    ]);

            }

            return response()->json([
                'msg' => true,
            ]);
        }

        else {
            return response()->json([
                'msg' => false,
            ]);
        }

    }

    public function getCouponTransData(Request $request) {
        $userCouponId = $request->get('id');

        if($userCouponId == null)
            return response()->json([
                'msg' => false,
            ]);

        // 현재 유저 쿠폰 조회
        $couponData =  UserCoupon::join('coupon', 'coupon.id', '=', 'user_coupon.coupon_id')
                        ->join('restaurants', 'restaurants.id', '=', 'coupon.shop_id')
                        ->leftjoin('menu', 'menu.id', '=', 'coupon.add_product')
                        ->select(DB::raw('user_coupon.id as id,
                                coupon.name as name,
                                coupon.category as category,
                                coupon.discount as discount,
                                coupon.price_condition as price_condition,
                                coupon.add_product as add_product,
                                menu.name as menu_name,
                                restaurants.name as restaurants_name,
                                user_coupon.use_check as use_check,
                                user_coupon.start_date as start_date,
                                user_coupon.expiry_date as expiry_date'))
                        ->where('user_coupon.id', $userCouponId)
                        ->first()
                        ->toArray();


        return response()->json([
           'couponData' => $couponData,
        ]);
    }

    // <-- 유저가 쿠폰 사용하기
    public function setCouponUpdate(Request $request) {
        // 현재 user Coupon Id
        $userCouponId = $request->get('id');
        // 오늘 날짜
        $currentDate = date("Y-m-d H:i:s");

        $couponData =  UserCoupon::join('coupon', 'coupon.id', '=', 'user_coupon.coupon_id')
            ->join('restaurants', 'restaurants.id', '=', 'coupon.shop_id')
            ->leftjoin('menu', 'menu.id', '=', 'coupon.add_product')
            ->select(DB::raw('user_coupon.id as id,
                                                coupon.name as name,
                                                coupon.category as category,
                                                coupon.discount as discount,
                                                coupon.price_condition as price_condition,
                                                menu.name as menu_name,
                                                restaurants.name as restaurants_name,
                                                user_coupon.use_check as use_check,
                                                user_coupon.start_date as start_date,
                                                user_coupon.expiry_date as expiry_date'))
            ->where('user_coupon.id', $userCouponId)
            ->first();

        $str_currentDate = strtotime($currentDate);
        $str_expiryDate  = strtotime($couponData->expiry_date);


        // 사용 기간 check 후 사용
        if($str_expiryDate < $str_currentDate) {
            return response()->json([
                'msg' => false,
            ]);
        }
        else {
            UserCoupon::where('user_coupon.id', $userCouponId)
                ->update([
                   'use_check' => true,
                ]);

            return response()->json([
                'msg' => true,
            ]);
        }
    }

    // <-- 유저 쿠폰 삭제
    public function deleteUserCoupon(Request $request) {
        $couponId = $request->get('id');

        UserCoupon::where('id', $couponId)
            ->delete();

        return response()->json([
           'msg'    => true,
        ]);
    }
}
