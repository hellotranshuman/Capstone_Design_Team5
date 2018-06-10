<?php

namespace App\Http\Controllers;

use App\Hashtag;
use App\Reservation;
use App\Restaurant;
use App\Upload;
use App\UserCoupon;
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

    public function showUserMenuPage() {
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
                    $optionNumName  = 'optionNum' . $menuIndex;

                    $currentOrderArray[$optionName]     = $orderListData[$orderIndex]['option_name'];
                    $currentOrderArray[$subOptionName]  = $orderListData[$orderIndex]['suboption_name'];
                    $currentOrderArray[$optionNumName]  = $optionIndex;
                    $optionIndex++;

                } // <-- for End

                $currentOrderArray['menuNum'] = $menuIndex;
                // 현재 주문내역 -> 전체 주문내역에 저장
                array_push($orderArray, $currentOrderArray);

            } // <-- foreach End

            return response()->json([
               'order_data' => $orderArray,
            ]);

    }

    // <-- 사용자 예약 내역 출력
    public function getUserReservationList() {

        // 예약 신청 완료된 예약 List
        $resAcceptData = Reservation::join('restaurants', 'reservation.shop_id', '=', 'restaurants.id')
                        ->select(DB::raw('
                            reservation.id as id,
                            restaurants.name as name,
                            restaurants.id as restaurant_id,
                            reservation.reservation_date as reservation_date,
                            reservation.person as person,
                            reservation.child as child,
                            reservation.message as message,
                            reservation.order_num as order_num
                        '))
                        ->where('reservation.user_num', auth()->user()->id)
                        ->where('reservation.accept', true)
                        ->orderByRaw('reservation.reservation_date DESC')
                        ->get()
                        ->toArray();


        // 예약 수락중인 예약 List
        $resWaitData = Reservation::join('restaurants', 'reservation.shop_id', '=', 'restaurants.id')
                       ->select(DB::raw('
                            reservation.id as id,
                            restaurants.name as name,
                            restaurants.id as restaurant_id,
                            reservation.reservation_date as reservation_date,
                            reservation.person as person,
                            reservation.child as child,
                            reservation.message as message,
                            reservation.order_num as order_num
                        '))
                        ->where('reservation.user_num', auth()->user()->id)
                        ->whereNull('reservation.accept')
                        ->orderByRaw('reservation.reservation_date DESC')
                        ->get()
                        ->toArray();

        // 예약 취소 된 예약 List (이후에 취소 메세지 넣어야함 **** Model 수정 필)
        $resCancelData =  Reservation::join('restaurants', 'reservation.shop_id', '=', 'restaurants.id')
                              ->select(DB::raw('
                                                reservation.id as id,
                                                restaurants.name as name,
                                                restaurants.id as restaurant_id,
                                                reservation.reservation_date as reservation_date,
                                                reservation.person as person,
                                                reservation.child as child,
                                                reservation.message as message,
                                                reservation.order_num as order_num
                                            '))
                                ->where('reservation.user_num', auth()->user()->id)
                                ->where('reservation.accept', false)
                                ->orderByRaw('reservation.reservation_date DESC')
                                ->get()
                                ->toArray();

        return response()->json([
            'resAcceptData'  => $resAcceptData,
            'resWaitData'    => $resWaitData,
            'resCancelData'  => $resCancelData,
        ]);
    }

    public function getUserReservationOrderInfo(Request $request) {
        // 예약 번호 받아오기
        $reservationNum = $request->get('id');

        // 예약번호로 해당 예약번호의 주문 번호 조회
       $resData = Reservation::where('id', $reservationNum)
                    ->first();

        $currentOrderNum = $resData->order_num;

        // 주문번호에 맞는 메뉴내역 가져오기

        // 전체 주문 내역
        $orderArray         = array();
        // 현재 주문번호의 주문 내역
        $currentOrderArray  = array();

        // 현재 주문번호와 메뉴, 옵션 갯수 Count
        $orderCountData = Order_List::join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                            ->join('order_option', 'order_option.order_menu_id', 'order_menu.id')
                            ->select(DB::raw('order_list.order_num as order_num, 
                                                           count(order_list.order_num) as orderCount'))
                            ->where('order_list.order_num', $currentOrderNum)
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
            $orderListData = Order_List::join('restaurants', 'order_list.shop_id', '=', 'restaurants.id')
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
                $optionNumName  = 'optionNum' . $menuIndex;

                $currentOrderArray[$optionName]     = $orderListData[$orderIndex]['option_name'];
                $currentOrderArray[$subOptionName]  = $orderListData[$orderIndex]['suboption_name'];
                $currentOrderArray[$optionNumName]  = $optionIndex;
                $optionIndex++;

            } // <-- for End

            $currentOrderArray['menuNum'] = $menuIndex;

            // 현재 주문내역 -> 전체 주문내역에 저장
            array_push($orderArray, $currentOrderArray);

        } // <-- foreach End

        return response()->json([
            'currentOrder' => $orderArray,
        ]);

    }

    // <-- 사용자 쿠폰 내역 출력
    public function getUserCouponList() {

      // 현재 사용자의 쿠폰 내역 조회
      $couponData =  UserCoupon::join('coupon', 'coupon.id', '=', 'user_coupon.coupon_id')
                        ->join('restaurants', 'restaurants.id', '=', 'coupon.shop_id')
                        ->join('menu', 'menu.id', '=', 'coupon.add_product')
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
                        ->where('user_coupon.user_num', auth()->user()->id)
                        ->get()
                        ->toArray();

      return response()->json([
         'coupon_data' => $couponData,
      ]);
    }

    public function getRecommendShopData() {
        // <-- 추천 리스트
        // 1. 현재 유저의 취향... ex) 메뉴, 선호하는 지역 조건
        // 2. 평점순으로 정렬
        // 3. 검색이 많이 된 순
        /*
         * ㅡㅡㅡ(로그인 했으면)ㅡㅡㅡ
            선호지역 평점 베스트
            선호지역 리뷰 수 베스트
            선호음식1 평점 베스트
            선호음식1 리뷰 수 베스트
       * */
        // 선호지역 평점
        $regionShopRatingData   = null;
        // 선호지역 리뷰건수
        $regionShopReviewData   = null;
        // 선호음식 평점
        $favoriteShopReviewData = null;
        // 선호음식 리뷰수
        $favoriteShopRatingData = null;

        if(auth()->check()) {
            if(!is_null(auth()->user()->favorite_region)) {
                // 선호지역 평점 베스트
                $regionShopRatingData = Restaurant::join('review', 'review.shop_id', '=', 'restaurants.id')
                                            ->select(DB::raw('
                                                ROUND(AVG(review.rating), 2) as totalRating,
                                                restaurants.id   as shop_id,
                                                restaurants.name as shop_name,
                                                restaurants.type as shop_type,
                                                restaurants.explanation as shop_explanation,
                                                restaurants.phone as shop_phone,
                                                restaurants.dodobuken as shop_ddobuken,
                                                restaurants.cities as shop_cities,
                                                restaurants.address as shop_address
                                            '))
                                            ->where('restaurants.dodobuken', auth()->user()->favorite_region)
                                            ->groupBy('review.shop_id')
                                            ->orderByRaw('totalRating desc')
                                            ->limit()
                                            ->get()
                                            ->toArray();

                // 선호지역 리뷰수 베스트
                $regionShopReviewData = Restaurant::join('review', 'review.shop_id', '=', 'restaurants.id')
                                            ->select(DB::raw('
                                                    count(review.id) as reviewCount,,
                                                    restaurants.id   as shop_id,
                                                    restaurants.name as shop_name,
                                                    restaurants.type as shop_type,
                                                    restaurants.explanation as shop_explanation,
                                                    restaurants.phone as shop_phone,
                                                    restaurants.dodobuken as shop_ddobuken,
                                                    restaurants.cities as shop_cities,
                                                    restaurants.address as shop_address
                                            '))
                                            ->where('restaurants.dodobuken', auth()->user()->favorite_region)
                                            ->groupBy('review.shop_id')
                                            ->orderByRaw('reviewCount desc')
                                            ->limit()
                                            ->get()
                                            ->toArray();

            }

            if(is_null(auth()->user()->favorite_1)) {
                // 선호 음식 1 평점 리스트
                $favoriteShopRatingData =  Restaurant::join('review', 'review.shop_id', '=', 'restaurants.id')
                                                ->select(DB::raw('
                                                    ROUND(AVG(review.rating), 2) as totalRating,
                                                    restaurants.id   as shop_id,
                                                    restaurants.name as shop_name,
                                                    restaurants.type as shop_type,
                                                    restaurants.explanation as shop_explanation,
                                                    restaurants.phone as shop_phone,
                                                    restaurants.dodobuken as shop_ddobuken,
                                                    restaurants.cities as shop_cities,
                                                    restaurants.address as shop_address
                                                '))
                                                ->where('restaurants.type', auth()->user()->favorite_1)
                                                ->groupBy('review.shop_id')
                                                ->orderByRaw('totalRating desc')
                                                ->limit()
                                                ->get()
                                                ->toArray();

                // 선호 음식 1 리뷰 수 베스트
                $favoriteShopReviewData =  Restaurant::join('review', 'review.shop_id', '=', 'restaurants.id')
                                                    ->select(DB::raw('
                                                            count(review.id) as reviewCount,,
                                                            restaurants.id   as shop_id,
                                                            restaurants.name as shop_name,
                                                            restaurants.type as shop_type,
                                                            restaurants.explanation as shop_explanation,
                                                            restaurants.phone as shop_phone,
                                                            restaurants.dodobuken as shop_ddobuken,
                                                            restaurants.cities as shop_cities,
                                                            restaurants.address as shop_address
                                                    '))
                                                    ->where('restaurants.dodobuken', auth()->user()->favorite_1)
                                                    ->groupBy('review.shop_id')
                                                    ->orderByRaw('reviewCount desc')
                                                    ->limit()
                                                    ->get()
                                                    ->toArray();
                }

            }

        return response()->json([
            'regionShopRatingData'      => $regionShopRatingData,
            'regionShopReviewData'      => $regionShopReviewData,
            'favoriteShopRatingData'    => $favoriteShopRatingData,
            'favoriteShopReviewData'    => $favoriteShopReviewData,
        ]);

    }

    // <-- 지역별 평점 기준 가게 데이터
    public function getRegionShopData(Request $request) {
        /*
         * 지역별 평점 베스트 (6개)
            도쿄 베스트, 후쿠오카 베스트, 오사카 베스트,
            OO 베스트, OO 베스트, OO 베스트
            식종별 평점 베스트 (3개)
            한식 베스트, 일식 베스트, 중식 베스트
         * */

      // <-- 지역별 가게 추천 Data
      $regionData   = $request->get('region');
      $limit        = $request->get('limit');

      $regionShopData =  Restaurant::join('review', 'review.shop_id', '=', 'restaurants.id')
                            ->select(DB::raw('
                                ROUND(AVG(review.rating), 2) as totalRating,
                                restaurants.id   as shop_id,
                                restaurants.name as shop_name,
                                restaurants.type as shop_type,
                                restaurants.explanation as shop_explanation,
                                restaurants.phone as shop_phone,
                                restaurants.dodobuken as shop_ddobuken,
                                restaurants.cities as shop_cities,
                                restaurants.address as shop_address
                            '))
                            ->where('restaurants.dodobuken', $regionData)
                            ->groupBy('review.shop_id')
                            ->orderByRaw('totalRating desc')
                            ->limit($limit)
                            ->get()
                            ->toArray();

      // <-- 각 가게 이미지 가져오기
      $regionShopIdData =  Restaurant::join('review', 'review.shop_id', '=', 'restaurants.id')
            ->select(DB::raw('ROUND(AVG(review.rating), 2) as totalRating,
            restaurants.id   as shop_id'))
            ->where('restaurants.dodobuken', $regionData)
            ->groupBy('review.shop_id')
            ->orderByRaw('totalRating desc')
            ->limit($limit)
            ->get();

      $fileNameArray = array();

      foreach ($regionShopIdData as $regionShopId) {
          $currentId = $regionShopId->shop_id;

          $fileName = Upload::select('filename')
                        ->where('shop_id', $currentId)
                        ->first();

          array_push($fileNameArray, $fileName);
      }

      return response()->json([
          'regionShopData'      => $regionShopData,
          'fileName'            => $fileNameArray,
      ]);
   }

    // <-- 업종별 평점 기준 가게 데이터
   public function getTypeShopData(Request $request) {

       // <-- 각 업종의 가게 Data
       $type = $request->get('');
       $limitData    = $request->get('limit');

       $typeShopData =  Restaurant::join('review', 'review.shop_id', '=', 'restaurants.id')
                               ->select(DB::raw('
                                    ROUND(AVG(review.rating), 2) as totalRating,
                                    restaurants.id   as shop_id,
                                    restaurants.name as shop_name,
                                    restaurants.type as shop_type,
                                    restaurants.explanation as shop_explanation,
                                    restaurants.phone as shop_phone,
                                    restaurants.dodobuken as shop_ddobuken,
                                    restaurants.cities as shop_cities,
                                    restaurants.address as shop_address
                                '))
                               ->where('restaurants.type', $type)
                               ->groupBy('review.shop_id')
                               ->orderByRaw('totalRating desc')
                               ->limit()
                               ->get()
                               ->toArray();

       return response()->json([
           'typeShopData'      => $typeShopData,
       ]);
   }

    // <-- 검색을 누른 키워드에 대한 데이터 get
    public function getSearchData(Request $request) {

        // <-- 가게 이름으로 검색
        $shopNameKeyword = '%' . $request->get('searchData') . '%';

        $shopSearchData = Restaurant::select(DB::raw('id, name, type,
                            explanation, phone, dodobuken, cities, address'))
                            ->where('name', 'like', '%う%')
                            ->get()
                            ->toArray();

        echo  var_dump($shopSearchData);
        echo '<br>-----------------------------<br>';

        // <-- 식당 위치 지역 명으로 검색
        $regionKeyword = '%' . $request->get('searchData') . '%';

        $regionSearchData = Restaurant::leftJoin('review', 'review.shop_id', '=', 'restaurants.id')
                                ->select(DB::raw('
                                    restaurants.id as shop_id,
                                    restaurants.name as shop_name,
                                    restaurants.type as shop_type,
                                    restaurants.explanation as shop_explanation,
                                    restaurants.phone as shop_phone,
                                    concat(dodobuken, cities, address) as shop_address,
                                    AVG(review.rating) as totalRating
                                '))
                                ->where('address', 'like', '%天神%')
                                ->groupBy('restaurants.id')
                                ->orderByRaw('totalRating desc')
                                ->get()
                                ->toArray();

        echo  var_dump($regionSearchData);

        // <-- 해시태그로 검색
        $hashTagKeyword = '%' . $request->get('searchData') . '%';

        $tagSearchData =  Hashtag::join('review', 'review.id', '=', 'hashtag.review_id')
                            ->join('restaurants', 'review.shop_id', '=', 'restaurants.id')
                            ->select(DB::raw('
                                restaurants.id   as shop_id,
                                restaurants.name as shop_name,
                                restaurants.type as shop_type,
                                restaurants.explanation as shop_explanation,
                                restaurants.phone as shop_phone,
                                restaurants.dodobuken as shop_ddobuken,
                                restaurants.cities as shop_cities,
                                restaurants.address as shop_address
                            '))
                            ->where('hashtag.tag', 'like', '%ㅋㅋ%')
                            ->groupBy('shop_id')
                            ->get()
                            ->toArray();

        echo '<br>-----------------------------<br>';
        echo  var_dump($tagSearchData);

        return response()->json([
            'shopSearchData'    => $shopSearchData,
            'regionSearchData'  => $regionSearchData,
            'tagSearchData'     => $tagSearchData
        ]);
    }

}
