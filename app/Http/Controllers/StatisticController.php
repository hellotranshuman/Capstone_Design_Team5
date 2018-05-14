<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Illuminate\Support\Facades\DB;
use App\Order_List;

class StatisticController extends Controller
{
    public function showStatisticsForm() {
        return view('restaurant.ownerStatistics');
    }

    // <-- 해당 가게 별점 5종류
    public function getRatingScore(Request $request) {

        // get Shop Id
        $shopId = $request->get('shop_id');


        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');


        if($start_date == null && $end_date == null)
        {
            // <-- select Rating Data
            $ratingData = Review::select(DB::raw('ROUND(AVG(rating),2) as totalRating, 
                                ROUND(AVG(taste),2) as taste, ROUND(AVG(service),2) as service, 
                                ROUND(AVG(mood),2) as mood, ROUND(AVG(price),2) as price'))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        else if($start_date == null){
            // <-- select Rating Data
            $ratingData = Review::select(DB::raw('ROUND(AVG(rating),2) as totalRating, 
                                ROUND(AVG(taste),2) as taste, ROUND(AVG(service),2) as service, 
                                ROUND(AVG(mood),2) as mood, ROUND(AVG(price),2) as price'))
                ->where('shop_id', $shopId)
                ->where('reg_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        else if($end_date == null){
            // <-- select Rating Data
            $ratingData = Review::select(DB::raw('ROUND(AVG(rating),2) as totalRating, 
                                ROUND(AVG(taste),2) as taste, ROUND(AVG(service),2) as service, 
                                ROUND(AVG(mood),2) as mood, ROUND(AVG(price),2) as price'))
                ->where('shop_id', $shopId)
                ->where('reg_date', '>', $start_date)
                ->get()
                ->toArray();
        }
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

    // <-- 해당 가게 손님 수
    public function getCustomerScore(Request $request) {

        // get Shop Id
        $shopId = $request->get('shop_id');

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        if($start_date == null && $end_date == null) {
            $customerData = Order_List::select(DB::raw('count(shop_id) as customer'))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        else if ($start_date == null){
            $customerData = Order_List::select(DB::raw('count(shop_id) as customer'))
                ->where('shop_id', $shopId)
                ->where('order_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        else if ($end_date == null){
            $customerData = Order_List::select(DB::raw('count(shop_id) as customer'))
                ->where('shop_id', $shopId)
                ->where('order_date', '>', $start_date)
                ->get()
                ->toArray();
        }
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

    // <-- 해당 가게 손님 성비
    public function getGenderScore(Request $request)
    {
        // get Shop Id
        $shopId     = $request->get('shop_id');

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        if($start_date == null && $end_date == null) {

            $genderData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.gender=true, 1, null)) as male,
                            
                                      count(if(users.gender=false, 1, null)) as female'))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        else if ($start_date == null) {
            $genderData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.gender=true, 1, null)) as male,
                            
                                      count(if(users.gender=false, 1, null)) as female'))
                ->where('shop_id', $shopId)
                ->where('order_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        else if ($end_date == null) {
            $genderData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.gender=true, 1, null)) as male,
                            
                                      count(if(users.gender=false, 1, null)) as female'))
                ->where('shop_id', $shopId)
                ->where('order_date', '>', $start_date)
                ->get()
                ->toArray();
        }
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

    // <-- 해당 가게 손님 연령대
    public function getAgeScore(Request $request) {

        // get Shop Id
        $shopId = $request->get('shop_id');

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        if($start_date == null && $end_date == null) {
            $ageData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9 , 1, 0)) as 0s,
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19 , 1, 0)) as 10s,

                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29 , 1, 0)) as 20s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39 , 1, 0)) as 30s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49 , 1, 0)) as 40s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59 , 1, 0)) as 50s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 69 , 1, 0)) as 60s'))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        else if ($start_date == null) {
            $ageData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9 , 1, 0)) as 0s,
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19 , 1, 0)) as 10s,

                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29 , 1, 0)) as 20s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39 , 1, 0)) as 30s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49 , 1, 0)) as 40s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59 , 1, 0)) as 50s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 69 , 1, 0)) as 60s'))
                ->where('shop_id', $shopId)
                ->where('order_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        else if ($end_date == null) {
            $ageData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9 , 1, 0)) as 0s,
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19 , 1, 0)) as 10s,

                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29 , 1, 0)) as 20s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39 , 1, 0)) as 30s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49 , 1, 0)) as 40s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59 , 1, 0)) as 50s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 69 , 1, 0)) as 60s'))
                ->where('shop_id', $shopId)
                ->where('order_date', '>', $start_date)
                ->get()
                ->toArray();
        }
        else{
            $ageData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9 , 1, 0)) as 0s,
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19 , 1, 0)) as 10s,

                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29 , 1, 0)) as 20s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39 , 1, 0)) as 30s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49 , 1, 0)) as 40s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59 , 1, 0)) as 50s,
                        
                        sum(if(date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 69 , 1, 0)) as 60s'))
                ->where('shop_id', $shopId)
                ->whereBetween('order_date', [$start_date, $end_date])
                ->get()
                ->toArray();
        }

        return response()->json([
            'ageData' => $ageData,
        ]);

    }

    // <-- 해당 손님 국적
    public function getCountryScore(Request $request) {
        // get Shop Id
        $shopId      = $request->get('shop_id');

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        if($start_date == null && $end_date == null) {
            $countryData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.country=\'korea\', 1, null)) as korea,
                                
                                count(if(users.country=\'japan\', 1, null)) as japan,
                                
                                count(if(users.country=\'china\', 1, null)) as china,
                                
                                count(if(users.country=\'usa\', 1, null)) as usa'))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        else if ($start_date == null) {
            $countryData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.country=\'korea\', 1, null)) as korea,
                                
                                count(if(users.country=\'japan\', 1, null)) as japan,
                                
                                count(if(users.country=\'china\', 1, null)) as china,
                                
                                count(if(users.country=\'usa\', 1, null)) as usa'))
                ->where('shop_id', $shopId)
                ->where('order_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        else if ($end_date == null) {
            $countryData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.country=\'korea\', 1, null)) as korea,
                                
                                count(if(users.country=\'japan\', 1, null)) as japan,
                                
                                count(if(users.country=\'china\', 1, null)) as china,
                                
                                count(if(users.country=\'usa\', 1, null)) as usa'))
                ->where('shop_id', $shopId)
                ->where('order_date', '>', $start_date)
                ->get()
                ->toArray();
        }
        else {
            $countryData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                ->select(DB::raw('count(if(users.country=\'korea\', 1, null)) as korea,
                                
                                count(if(users.country=\'japan\', 1, null)) as japan,
                                
                                count(if(users.country=\'china\', 1, null)) as china,
                                
                                count(if(users.country=\'usa\', 1, null)) as usa'))
                ->where('shop_id', $shopId)
                ->whereBetween('order_date', [$start_date, $end_date])
                ->get()
                ->toArray();
        }

        return response()->json([
            'ageData' => $countryData,
        ]);


    }

    public function getMenuData(Request $request) {
        // get Shop Id
        $shopId      = $request->get('shop_id');

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $country = null;
        $ages = null;
        $gender = null;

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
       }

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

        if($start_date == null && $end_date == null) {
           if($country == null && $ages == null && $gender == null) {
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
           else if($ages == null && $gender == null) {
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
           else if($country == null && $gender == null) {
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
           else if($country == null && $ages == null) {
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
        else if ($start_date == null) {
            if($country == null && $ages == null && $gender == null) {
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
            else if($ages == null && $gender == null) {
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
            else if($country == null && $gender == null) {
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
            else if($country == null && $ages == null) {
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
        else if ($end_date == null) {
            if($country == null && $ages == null && $gender == null) {
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
            else if($ages == null && $gender == null) {
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
            else if($country == null && $gender == null) {
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
            else if($country == null && $ages == null) {
                $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('menu.name as menuName, count(order_menu.menu_id) as menuCount'))
                    ->where('order_list.shop_id', $shopId)
                    ->where('order_date', '>', $start_date)
                    ->where('users.gender', $gender)
                    ->groupBy('menu.name')
                    ->orderByRaw('menuCount DESC')
                    ->get()
                    ->toArray();
            }
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
        else {
            if($country == null && $ages == null && $gender == null) {
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
            else if($ages == null && $gender == null) {
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
            else if($country == null && $gender == null) {
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
            else if($country == null && $ages == null) {
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
        ]);

    }

    // <-- 총 매출
    public function getSalesData(Request $request) {
        // get Shop Id
        $shopId = $request->get('shop_id');

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        if($start_date == null && $end_date == null) {
            $salesData = Order_List::select(DB::raw('sum(total) as total'))
                ->where('shop_id', $shopId)
                ->get()
                ->toArray();
        }
        else if ($start_date == null){
            $salesData = Order_List::select(DB::raw('sum(total) as total'))
                ->where('shop_id', $shopId)
                ->where('order_date', '<', $end_date)
                ->get()
                ->toArray();
        }
        else if ($end_date == null){
            $salesData = Order_List::select(DB::raw('sum(total) as total'))
                ->where('shop_id', $shopId)
                ->where('order_date', '>', $start_date)
                ->get()
                ->toArray();
        }

        else {
            $salesData = Order_List::select(DB::raw('sum(total) as total'))
                ->where('shop_id', $shopId)
                ->whereBetween('order_date', [$start_date, $end_date])
                ->get()
                ->toArray();

        }
        return response()->json([
            'customerData' => $salesData,
        ]);
    }

    public function getSalesMenuData(Request $request) {
        // get Shop Id
        $shopId      = $request->get('shop_id');

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $country = null;
        $ages = null;
        $gender = null;

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
        }

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

        if($start_date == null && $end_date == null) {
            if($country == null && $ages == null && $gender == null) {
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
            else if($ages == null && $gender == null) {
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
            else if($country == null && $gender == null) {
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
            else if($country == null && $ages == null) {
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
        else if ($start_date == null) {
            if($country == null && $ages == null && $gender == null) {
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
            else if($ages == null && $gender == null) {
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
            else if($country == null && $gender == null) {
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
            else if($country == null && $ages == null) {
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
        else if ($end_date == null) {
            if($country == null && $ages == null && $gender == null) {
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
            else if($ages == null && $gender == null) {
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
            else if($country == null && $gender == null) {
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
            else if($country == null && $ages == null) {
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
        else {
            if($country == null && $ages == null && $gender == null) {
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
            else if($ages == null && $gender == null) {
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
            else if($country == null && $gender == null) {
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
            else if($country == null && $ages == null) {
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

        }
        return response()->json([
            'menuData' => $salesData,
        ]);
    }

    // <-- 해당 가게 손님 수
    public function getCustomerNumber(Request $request) {

        // get Shop Id
        $shopId = $request->get('shop_id');

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
}
