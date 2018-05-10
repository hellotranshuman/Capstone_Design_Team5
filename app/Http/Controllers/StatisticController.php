<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Illuminate\Support\Facades\DB;
use App\Order_List;

class StatisticController extends Controller
{
    public function showStatisticsForm() {
        return view('restaurants.ownerStatistics');
    }

    // <-- 해당 가게 별점 5종류
    public function getRatingScore(Request $request) {

        // get Shop Id
        $shopId = $request->get('shop_id');

        // <-- select Rating Data
        $ratingData = Review::select(DB::raw('ROUND(AVG(rating),2) as totalRating, 
                                ROUND(AVG(taste),2) as taste, ROUND(AVG(service),2) as service, 
                                ROUND(AVG(mood),2) as mood, ROUND(AVG(price),2) as price'))
            ->where('shop_id', $shopId)
            ->get()
            ->toArray();

        return response()->json([
           'ratingData' => $ratingData,
        ]);

    }

    // <-- 해당 가게 손님 수
    public function getCustomerScore(Request $request) {
        // get Shop Id
        $shopId = $request->get('shop_id');

        $customerData = Order_List::select(DB::raw('count(shop_id) as customer'))
                        ->where('shop_id', $shopId)
                        ->get()
                        ->toArray();

        return response()->json([
            'customerData' => $customerData,
        ]);

    }

    // <-- 해당 가게 손님 성비
    public function getGenderScore(Request $request)
    {
        // get Shop Id
        $shopId     = $request->get('shop_id');

        $genderData =    Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                            ->select(DB::raw('count(if(users.gender=true, 1, null)) as male,
                            
                                      count(if(users.gender=false, 1, null)) as female'))
                            ->where('shop_id', $shopId)
                            ->get()
                            ->toArray();

        return response()->json([
            'genderData' => $genderData,
        ]);

    }

    // <-- 해당 가게 손님 연령대
    public function getAgeScore(Request $request) {

        // get Shop Id
        $shopId = $request->get('shop_id');

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

        return response()->json([
            'ageData' => $ageData,
        ]);

    }

    // <-- 해당 손님 국적
    public function getCountryScore(Request $request) {
        // get Shop Id
        $shopId      = $request->get('shop_id');

        $countryData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                        ->select(DB::raw('count(if(users.country=\'korea\', 1, null)) as korea,
                                
                                count(if(users.country=\'japan\', 1, null)) as japan,
                                
                                count(if(users.country=\'china\', 1, null)) as china,
                                
                                count(if(users.country=\'usa\', 1, null)) as usa'))
                        ->where('shop_id', $shopId)
                        ->get()
                        ->toArray();

        return response()->json([
            'ageData' => $countryData,
        ]);


    }

    public function getMenuData(Request $request) {
        // get Shop Id
        $shopId      = $request->get('shop_id');

        $menuData = Order_List::join('users', 'users.id', '=', 'order_list.user_num')
                    ->join('order_menu', 'order_menu.order_num', '=', 'order_list.order_num')
                    ->join('menu', 'order_menu.menu_id', '=', 'menu.id')
                    ->select(DB::raw('
                        menu.name as name,
                        menu.price as price,
                        users.country as country,
                        users.gender as gender,
                        case
                        when  date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 0 and 9 then \'0s\'
                        
                        when  date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 10 and 19 then \'10s\'
                        
                        when  date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 20 and 29 then \'20s\'
                        
                        when  date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 30 and 39 then \'30s\'
                        
                        when  date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 40 and 49 then \'40s\'
                        
                        when  date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 50 and 59 then \'50s\'
                        
                        when  date_format(now(),\'%Y\')-substring(users.birthday,1,4) between 60 and 69 then \'60s\'
                        
                        else \'70s\'
                        end as age'))
                    ->where('order_list.shop_id', $shopId)
                    ->get()
                    ->toArray();

        return response()->json([
            'menuData' => $menuData,
        ]);

    }
}
