<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Coupon;
use \App\UserCoupon;

class CouponController extends Controller
{
    public function showCouponForm() {
        return view('restaurant.createCoupon');
    }

    // <-- create Coupon in Coupon Table
    public function createCoupon(Request $request) {

         \App\Coupon::create([
            'name'            => $request->get('name'),
            'shop_id'         => $request->get('shop_id'),
            'category'        => $request->get('category'),
            'discount'        => $request->get('discount'),
            'price_condition' => $request->get('price_condition'),
            'start_date'      => $request->get('start_date'),
            'expiry_date'     => $request->get('expiry_date'),
            'add_product'     => $request->get('add_product'),
        ]);


        return response()->json([
           'content' => '등록이 완료되었습니다',
        ]);

    }

    // <-- get Coupon List in Coupon Table
    public function getCouponList(Request $request) {

        $couponList = Coupon::where('shop_id', $request->get('shop_id'))
                        ->get()
                        ->toArray();

        $couponNum = Coupon::where('shop_id', $request->get('shop_id'))
                        ->get()
                        ->count();

        return response()->json([
            'coupon'      => $couponList,
            'couponNum'   => $couponNum,
        ]);
    }

    // 쿠폰 삭제 -> coupon id가 0이 전송되어 쿼리가 제대로 작동x
    public function deleteCoupon(Request $request) {
        $couponId = $request->get('coupon_id');

        Coupon::where('id', '=' ,$couponId)
                ->delete();

        return response()->json([
           'msg'        => '삭제되었습니다',
        ]);
    }

    // 쿠폰 id..만 있으면 되는데..
    public function userCouponCreate(Request $request) {

        $currentCouponId = $request->get('coupon_id');
        // case1. 기간은 넉넉하게 있고 발급후 7일 이런식일 경우...
        // case2. 정말 유효기간까지 인 경우....
         $couponData = Coupon::where('id', $currentCouponId)
                        ->get()
                        ->first();

        $expiryDate = $couponData->expiry_date;
        $startDate = $couponData->start_date;

        UserCoupon::create([
            'user_num' => auth()->user()->id,
            'coupon_id' => $currentCouponId,
            'use_check' => false,
            'startDate' => $startDate,
            'expiryDate' => $expiryDate
        ]);

        return response()->json([
            'msg' => '쿠폰 발급이 완료되었습니다!'
        ]);


    }
}
