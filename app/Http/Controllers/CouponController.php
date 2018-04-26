<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Coupon;

class CouponController extends Controller
{
    public function showCouponForm() {
        return view('restaurant.createCoupon');
    }

    // <-- create Coupon in
    // Coupon Table
    public function createCoupon(Request $request) {

         \App\Coupon::create([
            'name' => $request->get('name'),
            'shop_id' => $request->get('shop_id'),
            'category' => $request->get('category'),
            'discount' => $request->get('discount'),
            'price_condition' => $request->get('price_condition'),
            'start_date' => $request->get('start_date'),
            'expiry_date' => $request->get('expiry_date'),
            'add_product' => $request->get('add_product'),
        ]);


        return response()->json([
           'content' => '등록이 완료되었습니다',
        ]);

    }

    public function getCouponList(Request $request) {

        $couponList = Coupon::where('shop_id', $request->get('shop_id'))
                        ->get();

        $couponNum = Coupon::where('shop_id', $request->get('shop_id'))
                        ->get()
                        ->count();

        return response()->json([
            'coupon'      => $couponList,
            'couponNum'   => $couponNum,
        ]);
    }
}
