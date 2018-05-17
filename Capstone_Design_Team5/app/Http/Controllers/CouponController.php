<?php

namespace App\Http\Controllers;

use App\Menu;
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

        $couponList = Coupon::join('menu', 'menu.id', '=', 'coupon.add_product')
                        ->select(DB::raw('coupon.id as id, coupon.category as category,
                                           coupon.name as name, coupon.discount as discount,
                                           coupon.price_condition as price_condition,
                                           coupon.add_product as add_product,
                                           coupon.start_date as start_date,
                                           coupon.expiry_date as expiry_date,
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

    // 쿠폰 삭제 -> coupon id가 0이 전송되어 쿼리가 제대로 작동x
    public function deleteCoupon(Request $request) {
        $couponId = $request->get('coupon_id');

        Coupon::where('id', '=' ,$couponId)
                ->delete();

        return response()->json([
           'msg'        => '삭제되었습니다',
        ]);
    }

    // <-- Add Coupon in User Coupon Table
    public function userCouponCreate(Request $request) {

        $currentCouponId = $request->get('id');

         $couponData = Coupon::where('id', $currentCouponId)
                        ->get()
                        ->first();

        $expiryDate = $couponData->expiry_date;
        $startDate = $couponData->start_date;

        UserCoupon::create([
            'user_num' => auth()->user()->id,
            'coupon_id' => $currentCouponId,
            'use_check' => false,
            'start_date' => $startDate,
            'expiry_date' => $expiryDate
        ]);

        return response()->json([
            'msg' => '쿠폰 발급이 완료되었습니다!'
        ]);


    }
}
