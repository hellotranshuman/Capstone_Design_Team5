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
    const client_id     = "yW2oDpUuRW0O7sbIKUJ2";
    const client_secret = "pevANwIHvX";

    private $url     = "https://openapi.naver.com/v1/language/translate";
    private $is_post = true;
    private $headers = array();

    function __construct()
    {
        $this->headers[] = "X-Naver-Client-Id: ".OrderController::client_id ;
        $this->headers[] = "X-Naver-Client-Secret: ".OrderController::client_secret ;
    }

    public function showCouponForm() {
        return view('restaurant.createCoupon');
    }

    // <-- create Coupon in Coupon Table
    public function createCoupon(Request $request) {

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
            'add_product'     => $addProduct,
        ]);

        return response()->json([
           'content' => '등록이 완료되었습니다',
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


        // 현재 받을려는 쿠폰이 이미 존재하는 것인지 확인
        $userCouponCount = UserCoupon::where('user_num', auth()->user()->id)
                            ->where('coupon_id', $currentCouponId)
                            ->count();

        if($userCouponCount != 0)
            return response()->json([
               'msg' => false,
            ]);

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

    public function getCouponTransData(Request $request) {

        $source = '';
        $userCouponId = $request->get('id');

        switch (auth()->user()->country) {

            case 'korea' :
                {
                    $source = 'ko';
                    break;
                }

            case 'china' :
                {
                    $source = 'zh-CN';
                    break;
                }

            case 'usa' :
                {
                    $source = 'en';
                    break;
                }

        } // <-- switch end

        // 현재 유저 쿠폰 조회
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

        $beforeTransText = '쿠폰 이름 : ' . $couponData->name . '#카테고리 : ' . $couponData->category;

        if ($couponData->category == '가격 할인')
            $beforeTransText .= '#할인 가격 : ' . $couponData->discount .
                                '#쿠폰 조건 : ' . $couponData->price_condition;
        else if($couponData->category == '상품 제공')
            $beforeTransText .= '#제공 상품 : ' . $couponData->menu_name .
                '#쿠폰 조건 : ' . $couponData->price_condition;

        $beforeTransText .= '#사용 기간 : ' . $couponData->start_date . '~' . $couponData->expiry_date;

        $encText = urlencode($beforeTransText);
        $postValues = 'source=' . $source . '&target=ja&text='.$encText;
        $ch  = curl_init();

        curl_setopt($ch,CURLOPT_URL, $this->url);
        curl_setopt($ch,CURLOPT_POST, $this->is_post);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $postValues);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch,CURLOPT_HTTPHEADER, $this->headers);

        $response    = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close ($ch);

        if($status_code == 200)
            return response()->json([
                'content' => $response,
            ]);
        else
            return response()->json([
                'content' =>'error! ' . $response,
            ]);
    }

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

    public function deleteUserCoupon(Request $request) {
        $couponId = $request->get('id');

        UserCoupon::where('id', $couponId)
            ->delete();

        return response()->json([
           'msg'    => true,
        ]);
    }
}
