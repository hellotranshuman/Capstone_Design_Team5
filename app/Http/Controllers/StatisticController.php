<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Illuminate\Support\Facades\DB;
use App\Order_List;

class StatisticController extends Controller
{
    // <-- Show statistics page
    public function showStatisticsForm() {
        return view('restaurant.ownerStatistics');
    }

    // <-- Restaurant Score (5 Score) -> total, taste, service, mood, price
    // <-- 해당 가게 별점 5종류
    public function getRatingScore(Request $request) {

        // get Shop Id
        $shopId = $request->get('shop_id');

        // get start date and end date
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        // <-- start date & end date X
        if($start_date == null && $end_date == null)
        {
            // select Rating Data
            $ratingData = Review::select(DB::raw('ROUND(AVG(rating),2) as totalRating, 
                                ROUND(AVG(taste),2) as taste, ROUND(AVG(service),2) as service, 
                                ROUND(AVG(mood),2) as mood, ROUND(AVG(price),2) as price'))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        // <-- end date O
        else if($start_date == null){
            // select Rating Data
            $ratingData = Review::select(DB::raw('ROUND(AVG(rating),2) as totalRating, 
                                ROUND(AVG(taste),2) as taste, ROUND(AVG(service),2) as service, 
                                ROUND(AVG(mood),2) as mood, ROUND(AVG(price),2) as price'))
                ->where('shop_id', $shopId)
                ->where('reg_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        // <-- start date O
        else if($end_date == null){
            // select Rating Data
            $ratingData = Review::select(DB::raw('ROUND(AVG(rating),2) as totalRating, 
                                ROUND(AVG(taste),2) as taste, ROUND(AVG(service),2) as service, 
                                ROUND(AVG(mood),2) as mood, ROUND(AVG(price),2) as price'))
                ->where('shop_id', $shopId)
                ->where('reg_date', '>', $start_date)
                ->get()
                ->toArray();
        }
        // <-- start date ~ end date data select
        else {
            // <-- select Rating Data
            $ratingData = Review::select(DB::raw('ROUND(AVG(rating),2) as totalRating, 
                                ROUND(AVG(taste),2) as taste, ROUND(AVG(service),2) as service, 
                                ROUND(AVG(mood),2) as mood, ROUND(AVG(price),2) as price'))
                ->where('shop_id', $shopId)
                ->whereBetween('reg_date', [$start_date, $end_date])
                ->get()
                ->toArray();
        }

        return response()->json([
           'ratingData' => $ratingData,
        ]);

    }

    // <-- Restaurant Customer Score
    // <-- 해당 가게 손님 수
    public function getCustomerScore(Request $request) {

        // get Shop Id
        $shopId = $request->get('shop_id');

        // get start date and end date
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        // <-- start date & end date X
        if($start_date == null && $end_date == null) {
            $customerData = Order_List::select(DB::raw('count(shop_id) as customer'))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        // <-- end date O
        else if ($start_date == null){
            $customerData = Order_List::select(DB::raw('count(shop_id) as customer'))
                ->where('shop_id', $shopId)
                ->where('order_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        // <-- start date O
        else if ($end_date == null){
            $customerData = Order_List::select(DB::raw('count(shop_id) as customer'))
                ->where('shop_id', $shopId)
                ->where('order_date', '>', $start_date)
                ->get()
                ->toArray();
        }
        // <-- start date ~ end date data select
        else {
            $customerData = Order_List::select(DB::raw('count(shop_id) as customer'))
                ->where('shop_id', $shopId)
                ->whereBetween('order_date', [$start_date, $end_date])
                ->get()
                ->toArray();

        }
        return response()->json([
            'customerData' => $customerData,
        ]);

    }

    // <-- Restaurant Customer's Gender Score
    // <-- 해당 가게 손님 성비
    public function getGenderScore(Request $request)
    {
        // get Shop Id
        $shopId     = $request->get('shop_id');

        // get start date and end date
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        // <-- start date & end date X
        if($start_date == null && $end_date == null) {

            $genderData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.gender=true, 1, null)) as male,
                                  count(if(users.gender=false, 1, null)) as female'))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        // <-- end date O
        else if ($start_date == null) {
            $genderData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.gender=true, 1, null)) as male,
                                  count(if(users.gender=false, 1, null)) as female'))
                ->where('shop_id', $shopId)
                ->where('order_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        // <-- start date O
        else if ($end_date == null) {
            $genderData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.gender=true, 1, null)) as male,
                                  count(if(users.gender=false, 1, null)) as female'))
                ->where('shop_id', $shopId)
                ->where('order_date', '>', $start_date)
                ->get()
                ->toArray();
        }
        // <-- start date ~ end date data select
        else {
            $genderData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.gender=true, 1, null)) as male,
                                  count(if(users.gender=false, 1, null)) as female'))
                ->where('shop_id', $shopId)
                ->whereBetween('order_date', [$start_date, $end_date])
                ->get()
                ->toArray();
        }

        return response()->json([
            'genderData' => $genderData,
        ]);

    }

    // <-- Restaurant Customer's Age Score
    // <-- 해당 가게 손님 연령대
    public function getAgeScore(Request $request) {

        // get Shop Id
        $shopId = $request->get('shop_id');

        // get start date and end date
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        // <-- start date & end date X
        if($start_date == null && $end_date == null) {
            $ageData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9 , 1, 0)) as 0s,
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19 , 1, 0)) as 10s,

                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29 , 1, 0)) as 20s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39 , 1, 0)) as 30s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49 , 1, 0)) as 40s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59 , 1, 0)) as 50s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 99 , 1, 0)) as 60s
                        
                        '))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        // <-- end date O
        else if ($start_date == null) {
            $ageData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9 , 1, 0)) as 0s,
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19 , 1, 0)) as 10s,

                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29 , 1, 0)) as 20s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39 , 1, 0)) as 30s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49 , 1, 0)) as 40s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59 , 1, 0)) as 50s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 99 , 1, 0)) as 60s

                        '))
                ->where('shop_id', $shopId)
                ->where('order_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        // <-- start date O
        else if ($end_date == null) {
            $ageData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9 , 1, 0)) as 0s,
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19 , 1, 0)) as 10s,

                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29 , 1, 0)) as 20s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39 , 1, 0)) as 30s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49 , 1, 0)) as 40s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59 , 1, 0)) as 50s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 99 , 1, 0)) as 60s
                       
                        '))
                ->where('shop_id', $shopId)
                ->where('order_date', '>', $start_date)
                ->get()
                ->toArray();
        }
        // <-- start date ~ end date data select
        else{
            $ageData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9 , 1, 0)) as 0s,
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19 , 1, 0)) as 10s,

                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29 , 1, 0)) as 20s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39 , 1, 0)) as 30s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49 , 1, 0)) as 40s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59 , 1, 0)) as 50s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 99 , 1, 0)) as 60s
     
                        '))
                ->where('shop_id', $shopId)
                ->whereBetween('order_date', [$start_date, $end_date])
                ->get()
                ->toArray();
        }

        return response()->json([
            'ageData' => $ageData,
        ]);

    }

    // <-- Restaurant Customer's Country Score
    // <-- 해당 가게 손님 국적
    public function getCountryScore(Request $request) {
        // get Shop Id
        $shopId      = $request->get('shop_id');

        // get start date and end date
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        // <-- start date & end date X
        if($start_date == null && $end_date == null) {
            $countryData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.country=\'korea\', 1, null)) as korea,
                                
                                count(if(users.country=\'japan\', 1, null)) as japan,
                                
                                count(if(users.country=\'china\', 1, null)) as china,
                                
                                count(if(users.country=\'usa\', 1, null)) as usa
                                
                                '))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        // <-- end date O
        else if ($start_date == null) {
            $countryData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.country=\'korea\', 1, null)) as korea,
                                
                                count(if(users.country=\'japan\', 1, null)) as japan,
                                
                                count(if(users.country=\'china\', 1, null)) as china,
                                
                                count(if(users.country=\'usa\', 1, null)) as usa
                                
                                '))
                ->where('shop_id', $shopId)
                ->where('order_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        // <-- start date O
        else if ($end_date == null) {
            $countryData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.country=\'korea\', 1, null)) as korea,
                                
                                count(if(users.country=\'japan\', 1, null)) as japan,
                                
                                count(if(users.country=\'china\', 1, null)) as china,
                                
                                count(if(users.country=\'usa\', 1, null)) as usa
                                '))
                ->where('shop_id', $shopId)
                ->where('order_date', '>', $start_date)
                ->get()
                ->toArray();
        }
        // <-- start date ~ end date data select
        else {
            $countryData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.country=\'korea\', 1, null)) as korea,
                                
                                count(if(users.country=\'japan\', 1, null)) as japan,
                                
                                count(if(users.country=\'china\', 1, null)) as china,
                                
                                count(if(users.country=\'usa\', 1, null)) as usa
                                '))
                ->where('shop_id', $shopId)
                ->whereBetween('order_date', [$start_date, $end_date])
                ->get()
                ->toArray();
        }

        return response()->json([
            'countryData' => $countryData,
        ]);


    }

    // <-- Restaurant's Menu Score
    // <-- 해당 가게 메뉴 통계
    public function getMenuData(Request $request) {
        // get Shop Id
        $shopId      = $request->get('shop_id');

        // get start date and end date
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        // country, age, gender filtering data
        $country = null;
        $ages = null;
        $gender = null;

        // <-- filtering by selected country
       switch ($request->get('ranking_country')) {

           case 1 : {
               $country = 'china';
               break;
            }
           case 2 : {
               $country = 'japan';
               break;
           }
           case 3 : {
               $country = 'korea';
               break;
           }
           case 4 : {
               $country = 'usa';
               break;
           }

       }

        // <-- filtering by selected gender
        switch ($request->get('ranking_gender')) {
           case 1 : {
                $gender = true;
                break;
            }
            case 2 : {
                $gender = false;
                break;
            }
        }

        // <-- filtering by selected age
        switch ($request->get('ranking_age')) {

            case 1 : {
                $ages = 'date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9';
                break;
            }
            case 2 : {
                $ages = 'date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19';
                break;
            }
            case 3 : {
                $ages = 'date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29';
                break;
            }
            case 4 : {
                $ages = 'date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39';
                break;
            }
            case 5 : {
                $ages = 'date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49';
                break;
            }
            case 6 : {
                $ages = 'date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59';
                break;
            }
            case 7 : {
                $ages = 'date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 99';
                break;
            }
        }

        // <-- start date & end date X
        if($start_date == null && $end_date == null) {
           // all data
           if(is_null($gender) && is_null($country) && is_null($ages)) {
               $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                   ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                   ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                   ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                   ->where('order_list.shop_id', $shopId)
                   ->groupBy('menu.name')
                   ->orderByRaw('menuCount DESC')
                   ->get()
                   ->toArray();
           }
           // filtering by country
           else if(is_null($ages) && is_null($gender)) {
               $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                   ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                   ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                   ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                   ->where('order_list.shop_id', $shopId)
                   ->where('users.country', $country)
                   ->groupBy('menu.name')
                   ->orderByRaw('menuCount DESC')
                   ->get()
                   ->toArray();
           }
           // filtering by age
           else if(is_null($country) && is_null($gender)) {
               $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                   ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                   ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                   ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                   ->where('order_list.shop_id', $shopId)
                   ->whereRaw($ages)
                   ->groupBy('menu.name')
                   ->orderByRaw('menuCount DESC')
                   ->get()
                   ->toArray();
           }
           // filtering by gender
           else if(is_null($country) && is_null($ages)) {
               $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                   ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                   ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                   ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                   ->where('order_list.shop_id', $shopId)
                   ->where('users.gender', $gender)
                   ->groupBy('menu.name')
                   ->orderByRaw('menuCount DESC')
                   ->get()
                   ->toArray();
           }
           // filtering by age & country
           else if(is_null($gender)) {
               $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                   ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                   ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                   ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                   ->where('order_list.shop_id', $shopId)
                   ->whereRaw($ages)
                   ->where('users.country', $country)
                   ->groupBy('menu.name')
                   ->orderByRaw('menuCount DESC')
                   ->get()
                   ->toArray();
           }
           // filtering by country & gender
           else if(is_null($ages)) {
               $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                   ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                   ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                   ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                   ->where('order_list.shop_id', $shopId)
                   ->where('users.country', $country)
                   ->where('users.gender', $gender)
                   ->groupBy('menu.name')
                   ->orderByRaw('menuCount DESC')
                   ->get()
                   ->toArray();
           }
           // filtering by age & gender
           else if(is_null($country)) {
               $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                   ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                   ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                   ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                   ->where('order_list.shop_id', $shopId)
                   ->whereRaw($ages)
                   ->where('users.gender', $gender)
                   ->groupBy('menu.name')
                   ->orderByRaw('menuCount DESC')
                   ->get()
                   ->toArray();
           }
           // filtering by age & country & gender
           else {
               $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                   ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                   ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                   ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                   ->where('order_list.shop_id', $shopId)
                   ->whereRaw($ages)
                   ->where('users.country', $country)
                   ->where('users.gender', $gender)
                   ->groupBy('menu.name')
                   ->orderByRaw('menuCount DESC')
                   ->get()
                   ->toArray();
           }
        }
        // <-- end date O
        else if ($start_date == null) {
            // all data
            if(is_null($country) && is_null($ages) && is_null($gender)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();

            }
            // filtering by country
            else if(is_null($ages) && is_null($gender)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->where('users.country', $country)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age
            else if(is_null($country) && is_null($gender)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->whereRaw($ages)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by gender
            else if(is_null($country) && is_null($ages)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & country
            else if(is_null($gender)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->whereRaw($ages)
                    ->where('users.country', $country)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by country & gender
            else if(is_null($ages)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->where('users.country', $country)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & gender
            else if(is_null($country)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->whereRaw($ages)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & country & gender
            else {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->whereRaw($ages)
                    ->where('users.country', $country)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }

        }
        // <-- start date O
        else if ($end_date == null) {
            // all data
            if(is_null($country) && is_null($ages) && is_null($gender)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by country
            else if(is_null($ages) &&is_null($gender)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->where('users.country', $country)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age
            else if(is_null($country) && is_null($gender)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->whereRaw($ages)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by gender
            else if(is_null($country) && is_null($ages)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('users.gender', $gender)
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & country
            else if(is_null($gender)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->whereRaw($ages)
                    ->where('users.country', $country)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by country & gender
            else if(is_null($ages)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->where('users.country', $country)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & gender
            else if(is_null($country)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->whereRaw($ages)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & country & gender
            else {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->whereRaw($ages)
                    ->where('users.country', $country)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }

        }
        // <-- start date ~ end date data select
        else {
            // all data
           if(is_null($gender) && is_null($country) && is_null($ages) ) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();

            }
            // filtering by country
            else if(is_null($ages) && is_null($gender)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->where('users.country', $country)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();

            }
            // filtering by age
            else if(is_null($country) && is_null($gender)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->whereRaw($ages)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();

            }
            // filtering by gender
            else if(is_null($country) && is_null($ages)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();

            }
            // filtering by age & country
            else if(is_null($gender)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->whereRaw($ages)
                    ->where('users.country', $country)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();

            }
            // filtering by country & gender
            else if(is_null($ages)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->where('users.country', $country)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();

            }
            // filtering by age & gender
            else if(is_null($country)) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->whereRaw($ages)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();

            }
            // filtering by age & country & gender
            else {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->whereRaw($ages)
                    ->where('users.country', $country)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();

            }

        }

        return response()->json([
            'menuData' => $menuData,
            'gender'   => $request->get('ranking_gender'),
            'country'  => $request->get('ranking_country'),
            'age'       => $request->get('ranking_age'),
        ]);

    }

    // <-- 총 매출
    // <-- Restaurant's Sales Data
    public function getSalesData(Request $request) {
        // get Shop Id
        $shopId = $request->get('shop_id');

        // get start date and end date
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        // <-- start date & end date X
        if($start_date == null && $end_date == null) {
            $salesData = Order_List::select(DB::raw('sum(total) as total'))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        // <-- end date O
        else if ($start_date == null){
            $salesData = Order_List::select(DB::raw('sum(total) as total'))
                ->where('shop_id', $shopId)
                ->where('order_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        // <-- start date O
        else if ($end_date == null){
            $salesData = Order_List::select(DB::raw('sum(total) as total'))
                ->where('shop_id', $shopId)
                ->where('order_date', '>', $start_date)
                ->get()
                ->toArray();
        }
        // <-- start date ~ end date data select
        else {
            $salesData = Order_List::select(DB::raw('sum(total) as total'))
                ->where('shop_id', $shopId)
                ->whereBetween('order_date', [$start_date, $end_date])
                ->get()
                ->toArray();

        }
        return response()->json([
            'salesData' => $salesData,
        ]);
    }

    public function getSalesMenuData(Request $request) {
        // get Shop Id
        $shopId      = $request->get('shop_id');

        // get start date and end date
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        // country, age, gender filtering data
        $country = null;
        $ages = null;
        $gender = null;

        // <-- filtering by selected country
        switch ($request->get('ranking_country')) {
            case 1 : {
                $country = 'china';
                break;
            }
            case 2 : {
                $country = 'japan';
                break;
            }
            case 3 : {
                $country = 'korea';
                break;
            }

            case 4 : {
                $country = 'usa';
                break;
            }
        }

        // <-- filtering by selected gender
        switch ($request->get('ranking_gender')) {
            case 1 : {
                $gender = true;
                break;
            }
            case 2 : {
                $gender = false;
                break;
            }
        }

        // <-- filtering by selected age
        switch ($request->get('ranking_age')) {
            case 1 : {
                $ages = 'date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9';
                break;
            }
            case 2 : {
                $ages = 'date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19';
                break;
            }
            case 3 : {
                $ages = 'date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29';
                break;
            }
            case 4 : {
                $ages = 'date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39';
                break;
            }
            case 5 : {
                $ages = 'date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49';
                break;
            }
            case 6 : {
                $ages = 'date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59';
                break;
            }
            case 7 : {
                $ages = 'date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 99';
                break;
            }
        }

        // <-- start date & end date X
        if($start_date == null && $end_date == null) {
            // all data
            if(is_null($country) && is_null($ages) && is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by country
            else if(is_null($ages) && is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('users.country', $country)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age
            else if(is_null($country) && is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereRaw($ages)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by gender
            else if(is_null($country) && is_null($ages)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & country
            else if(is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereRaw($ages)
                    ->where('users.country', $country)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by country & gender
            else if(is_null($ages)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('users.country', $country)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & gender
            else if(is_null($country)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereRaw($ages)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & country & gender
            else {
               $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereRaw($ages)
                    ->where('users.country', $country)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
        }
        // <-- end date O
        else if ($start_date == null) {
            // all data
            if(is_null($country) && is_null($ages) && is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();

            }
            // filtering by country
            else if(is_null($ages) && is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->where('users.country', $country)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age
            else if(is_null($country) && is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->whereRaw($ages)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by gender
            else if(is_null($country) && is_null($ages)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & country
            else if(is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->whereRaw($ages)
                    ->where('users.country', $country)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by country & gender
            else if(is_null($ages)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->where('users.country', $country)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & gender
            else if(is_null($country)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->whereRaw($ages)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & country & gender
            else {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '<', $end_date)
                    ->whereRaw($ages)
                    ->where('users.country', $country)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }

        }
        // <-- start date O
        else if ($end_date == null) {
            // all data
            if(is_null($country) && is_null($ages) && is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by country
            else if(is_null($ages) && is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->where('users.country', $country)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age
            else if(is_null($country) && is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->whereRaw($ages)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by gender
            else if(is_null($country) && is_null($ages)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & country
            else if(is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->whereRaw($ages)
                    ->where('users.country', $country)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by country & gender
            else if(is_null($ages)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->where('users.country', $country)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & gender
            else if(is_null($country)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->whereRaw($ages)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & country & gender
            else {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->whereRaw($ages)
                    ->where('users.country', $country)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }

        }
        // <-- start date ~ end date data select
        else {
            // all data
            if(is_null($country) && is_null($ages) && is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by country
            else if(is_null($ages) && is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->where('users.country', $country)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age
            else if(is_null($country) && is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->whereRaw($ages)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by gender
            else if(is_null($country) && is_null($ages)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & country
            else if(is_null($gender)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->whereRaw($ages)
                    ->where('users.country', $country)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by country & gender
            else if(is_null($ages)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->where('users.country', $country)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & gender
            else if(is_null($country)) {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->whereRaw($ages)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }
            // filtering by age & country & gender
            else {
                $salesData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, sum(menu.price) as menuTotal'))
                    ->where('order_list.shop_id', $shopId)
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->whereRaw($ages)
                    ->where('users.country', $country)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuTotal DESC')
                    ->get()
                    ->toArray();
            }

        } // <-- if End

        return response()->json([
            'salesData' => $salesData,
        ]);
    }

    // <-- Restaurant's Customer Score by Month
    // <-- 해당 가게 손님 수
    public function getCustomerNumber(Request $request) {

        // get Shop Id
        $shopId = $request->get('shop_id');

        // Customer Month Score
        $monthData1 = Order_List::select(DB::raw('count(shop_id) as customer'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day1'), $request->get('end_date1')])
            ->get()
            ->toArray();

        $monthData2 = Order_List::select(DB::raw('count(shop_id) as customer'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day2'), $request->get('end_date2')])
            ->get()
            ->toArray();

        $monthData3 = Order_List::select(DB::raw('count(shop_id) as customer'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day3'), $request->get('end_date3')])
            ->get()
            ->toArray();

        $monthData4 = Order_List::select(DB::raw('count(shop_id) as customer'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day4'), $request->get('end_date4')])
            ->get()
            ->toArray();

        $monthData5 = Order_List::select(DB::raw('count(shop_id) as customer'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day5'), $request->get('end_date5')])
            ->get()
            ->toArray();

        $monthData6 = Order_List::select(DB::raw('count(shop_id) as customer'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day6'), $request->get('end_date6')])
            ->get()
            ->toArray();

        $monthData7 = Order_List::select(DB::raw('count(shop_id) as customer'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day7'), $request->get('end_date7')])
            ->get()
            ->toArray();

        $monthData8 = Order_List::select(DB::raw('count(shop_id) as customer'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day8'), $request->get('end_date8')])
            ->get()
            ->toArray();

        $monthData9 = Order_List::select(DB::raw('count(shop_id) as customer'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day9'), $request->get('end_date9')])
            ->get()
            ->toArray();

        $monthData10 = Order_List::select(DB::raw('count(shop_id) as customer'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day10'), $request->get('end_date10')])
            ->get()
            ->toArray();

        $monthData11 = Order_List::select(DB::raw('count(shop_id) as customer'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day11'), $request->get('end_date11')])
            ->get()
            ->toArray();

        $monthData12 = Order_List::select(DB::raw('count(shop_id) as customer'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day12'), $request->get('end_date12')])
            ->get()
            ->toArray();

        return response()->json([
            'customerData' => [$monthData1, $monthData2, $monthData3, $monthData4, $monthData5, $monthData6,
                $monthData7, $monthData8, $monthData9, $monthData10, $monthData11, $monthData12]
        ]);
    }

    // <-- Restaurant's Sales Data by Month
    // <-- 해당 가게 월별 매출
    public function getSalesNumber(Request $request) {
        // get Shop Id
        $shopId = $request->get('shop_id');

        // Sales Month Score
        $monthData1 = Order_List::select(DB::raw('sum(total) as total'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day1'), $request->get('end_date1')])
            ->get()
            ->toArray();

        $monthData2 = Order_List::select(DB::raw('sum(total) as total'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day2'), $request->get('end_date2')])
            ->get()
            ->toArray();

        $monthData3 = Order_List::select(DB::raw('sum(total) as total'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day3'), $request->get('end_date3')])
            ->get()
            ->toArray();

        $monthData4 = Order_List::select(DB::raw('sum(total) as total'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day4'), $request->get('end_date4')])
            ->get()
            ->toArray();

        $monthData5 = Order_List::select(DB::raw('sum(total) as total'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day5'), $request->get('end_date5')])
            ->get()
            ->toArray();

        $monthData6 = Order_List::select(DB::raw('sum(total) as total'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day6'), $request->get('end_date6')])
            ->get()
            ->toArray();

        $monthData7 = Order_List::select(DB::raw('sum(total) as total'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day7'), $request->get('end_date7')])
            ->get()
            ->toArray();

        $monthData8 = Order_List::select(DB::raw('sum(total) as total'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day8'), $request->get('end_date8')])
            ->get()
            ->toArray();

        $monthData9 = Order_List::select(DB::raw('sum(total) as total'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day9'), $request->get('end_date9')])
            ->get()
            ->toArray();

        $monthData10 = Order_List::select(DB::raw('sum(total) as total'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day10'), $request->get('end_date10')])
            ->get()
            ->toArray();

        $monthData11 = Order_List::select(DB::raw('sum(total) as total'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day11'), $request->get('end_date11')])
            ->get()
            ->toArray();

        $monthData12 = Order_List::select(DB::raw('sum(total) as total'))
            ->where('shop_id', $shopId)
            ->whereBetween('order_date', [$request->get('start_day12'), $request->get('end_date12')])
            ->get()
            ->toArray();

        return response()->json([
            'salesData' => [$monthData1, $monthData2, $monthData3, $monthData4, $monthData5, $monthData6,
                $monthData7, $monthData8, $monthData9, $monthData10, $monthData11, $monthData12]
        ]);
    }

    // <-- Restaurant's Sales Data by Gender
    // <-- 성별 별 매출
    public function getGenderSalesData(Request $request){
        // get Shop Id
        $shopId     = $request->get('shop_id');

        // get start date and end date
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        // <-- start date & end date X
        if($start_date == null && $end_date == null) {

            $genderData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw(' sum(if(users.gender=true, order_list.total, 0)) as maleSales,
                          
                          sum(if(users.gender=false, order_list.total, 0)) as femaleSales
                          '))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        // <-- end date O
        else if ($start_date == null) {
            $genderData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(users.gender=true, order_list.total, 0)) as maleSales,
                                      
                          sum(if(users.gender=false, order_list.total, 0)) as femaleSales
                          '))
                ->where('shop_id', $shopId)
                ->where('order_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        // <-- start date O
        else if ($end_date == null) {
            $genderData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(users.gender=true, order_list.total, 0)) as maleSales,
                                      
                          sum(if(users.gender=false, order_list.total, 0)) as femaleSales
                          '))
                ->where('shop_id', $shopId)
                ->where('order_date', '>', $start_date)
                ->get()
                ->toArray();
        }
        // <-- start date ~ end date data select
        else {
            $genderData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(users.gender=true, order_list.total, 0)) as maleSales,
                                      
                          sum(if(users.gender=false, order_list.total, 0)) as femaleSales
                          '))
                ->where('shop_id', $shopId)
                ->whereBetween('order_date', [$start_date, $end_date])
                ->get()
                ->toArray();
        }

        return response()->json([
            'genderData' => $genderData,
        ]);
    }

    // <-- Restaurant's Sales Data by Country
    // <-- 국적별 매출
    public function getCountrySalesData(Request $request){
        // get Shop Id
        $shopId      = $request->get('shop_id');

        // get start date and end date
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        // <-- start date & end date X
        if($start_date == null && $end_date == null) {
            $countryData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(users.country=\'korea\', order_list.total, 0)) as koreaSales,

                                sum(if(users.country=\'japan\', order_list.total, 0)) as japanSales,
                                
                                sum(if(users.country=\'china\', order_list.total, 0)) as chinaSales,
                                
                                sum(if(users.country=\'usa\', order_list.total, 0)) as usaSales
                                
                                '))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        // <-- end date O
        else if ($start_date == null) {
            $countryData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(users.country=\'korea\', order_list.total, 0)) as koreaSales,

                                sum(if(users.country=\'japan\', order_list.total, 0)) as japanSales,
                                
                                sum(if(users.country=\'china\', order_list.total, 0)) as chinaSales,
                                
                                sum(if(users.country=\'usa\', order_list.total, 0)) as usaSales
                                
                                '))
                ->where('shop_id', $shopId)
                ->where('order_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        // <-- start date O
        else if ($end_date == null) {
            $countryData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(users.country=\'korea\', order_list.total, 0)) as koreaSales,

                                sum(if(users.country=\'japan\', order_list.total, 0)) as japanSales,
                                
                                sum(if(users.country=\'china\', order_list.total, 0)) as chinaSales,
                                
                                sum(if(users.country=\'usa\', order_list.total, 0)) as usaSales
                                '))
                ->where('shop_id', $shopId)
                ->where('order_date', '>', $start_date)
                ->get()
                ->toArray();
        }
        // <-- start date ~ end date data select
        else {
            $countryData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(users.country=\'korea\', order_list.total, 0)) as koreaSales,
                                
                                sum(if(users.country=\'japan\', order_list.total, 0)) as japanSales,
                                
                                sum(if(users.country=\'china\', order_list.total, 0)) as chinaSales,
                                
                                sum(if(users.country=\'usa\', order_list.total, 0)) as usaSales
                                '))
                ->where('shop_id', $shopId)
                ->whereBetween('order_date', [$start_date, $end_date])
                ->get()
                ->toArray();
        } // <-- if End

        return response()->json([
            'countryData' => $countryData,
        ]);

    }

    // <-- Restaurant's Sales Data by Age
    // <-- 연령별 매출
    public function getAgesSalesData(Request $request){
        // get Shop Id
        $shopId = $request->get('shop_id');

        // get start date and end date
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        // <-- start date & end date X
        if($start_date == null && $end_date == null) {
            $ageData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9 , order_list.total, 0)) as 0sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19 , order_list.total, 0)) as 10sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29 , order_list.total, 0)) as 20sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39 , order_list.total, 0)) as 30sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49 , order_list.total, 0)) as 40sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59 , order_list.total, 0)) as 50sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 99 , order_list.total, 0)) as 60sSales
                        '))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        // <-- end date O
        else if ($start_date == null) {
            $ageData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9 , order_list.total, 0)) as 0sSales,

                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19 , order_list.total, 0)) as 10sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29 , order_list.total, 0)) as 20sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39 , order_list.total, 0)) as 30sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49 , order_list.total, 0)) as 40sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59 , order_list.total, 0)) as 50sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 99 , order_list.total, 0)) as 60sSales
                        '))
                ->where('shop_id', $shopId)
                ->where('order_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        // <-- start date O
        else if ($end_date == null) {
            $ageData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9 , order_list.total, 0)) as 0sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19 , order_list.total, 0)) as 10sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29 , order_list.total, 0)) as 20sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39 , order_list.total, 0)) as 30sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49 , order_list.total, 0)) as 40sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59 , order_list.total, 0)) as 50sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 99 , order_list.total, 0)) as 60sSales
                        '))
                ->where('shop_id', $shopId)
                ->where('order_date', '>', $start_date)
                ->get()
                ->toArray();
        }
        // <-- start date ~ end date data select
        else{
            $ageData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9 , order_list.total, 0)) as 0sSales,

                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19 , order_list.total, 0)) as 10sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29 , order_list.total, 0)) as 20sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39 , order_list.total, 0)) as 30sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49 , order_list.total, 0)) as 40sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59 , order_list.total, 0)) as 50sSales,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 99 , order_list.total, 0)) as 60sSales
                        '))
                ->where('shop_id', $shopId)
                ->whereBetween('order_date', [$start_date, $end_date])
                ->get()
                ->toArray();
        } // <-- if End

        return response()->json([
            'ageData' => $ageData,
        ]);

    }

}
