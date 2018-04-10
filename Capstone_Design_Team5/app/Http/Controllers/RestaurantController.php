<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Restaurant;
use App\Upload;

class RestaurantController extends Controller
{
    public function showRestaurantForm() {
        if(auth()->user()->category == true)
            return 'failed!!!!!@@@';
        else
            return view('restaurant.createRestaurant');
    }

    public function showRestaurantInfo($shop_id) {

        $restaurant = Restaurant::join('lunchDinnerTime', 'lunchDinnerTime.shop_id',
                        '=', 'restaurants.id')
                        ->select('restaurants.*', 'lunchDinnerTime.*')
                        ->where('lunchDinnerTime.shop_id', $shop_id)
                        ->get()
                        ->toArray();

        $file = Upload::select('filename', 'path')
                        ->where('shop_id', $shop_id)
                        ->get()
                        ->toArray();

        $restaurantInfo = array_merge($restaurant, $file);

        return $restaurantInfo;

        /*
        $res =  DB::table('restaurants')
            ->join('lunchDinnerTime', 'lunchDinnerTime.shop_id',
                    '=', 'restaurants.id')
            ->select('restaurants.*', 'lunchDinnerTime.*')
            ->where('lunchDinnerTime.shop_id', $shop_id)
            ->get();






       return var_dump($res); */

    }

    public function createRestaurant(Request $request) {

        // <-- *** insert restaurant data ***

        $restaurant = \App\Restaurant::create([
            'name' => $request->input('name'),
            'user_num' => auth()->user()->id,
            'type'=> $request->input('type'),
            'explanation'=> $request->input('explanation'),
            'phone' => $request->input('phone'),
            'dodobuken' => $request->input('dodobuken'),
            'cities' => $request->input('address1'),
            'address' => $request->input('address2'),
            'payment' => $request->input('payment'),
            'seat_num' => $request->input('seat_num'),
            'children' => $request->input('children') == 'yes' ? true : false,
            'pet' => $request->input('pet') == 'yes' ? true : false,
            'parking' => $request->input('parking') == 'yes' ? true : false,
            'smoking' => $request->input('smoking') == 'yes' ? true : false,
            'privateroom' => $request->input('privateroom') == 'yes' ? true : false
        ]);

        // check Shop Id
        $shopId = DB::table('restaurants')
                    ->select('id')
                    ->where('user_num', auth()->user()->id)
                    ->orderByRaw('id DESC')
                    ->first();

        $currentShopId = $shopId->id;

        echo $currentShopId;


        \App\LunchDinnerTime::create([
            'shop_id' => $currentShopId,
            'lunch_open' => $request->input('lunch_open'),
            'lunch_close' => $request->input('lunch_close'),
            'lunch_lo' => $request->input('lunch_lo'),
            'dinner_open' => $request->input('dinner_open'),
            'dinner_close' => $request->input('dinner_close'),
            'dinner_lo' => $request->input('dinner_lo'),
        ]);


        // <-- *** Image File Upload ***

        // Current Save Shop Image Route
        $path = storage_path() . '/app/public/img/' . $currentShopId;
        $dbPath = '/images/'. $currentShopId . '/';

        // Check Shop Path
        if(is_dir($path))
            echo 'ok';

        // Make Shop Image SavePath
        else
            Storage::makeDirectory($currentShopId);

        $number = $request->get('num');

        if($request->file('titleImg')) {
            // title Img 가져오기
            $titleImg = $request->file('titleImg');

            // File Name Setting
            $fileName = $currentShopId . '_titleImg' . '.' . $titleImg->getClientOriginalExtension();

            // Upload File Save
            $titleImg->storeAs($currentShopId, $fileName);

            \App\Upload::create([
                'filename'   => $fileName,
                'shop_id'    => $currentShopId,
                'path'       => $dbPath
            ]);
        }
        else {
            echo '파일이 없습니다';
        }

        echo $number;

        if($number != 0) {
            for( $num = 0 ; $num < $number ; $num++ ) {
                // 업로드한 파일 인덱스 찾기
                $uploadName = 'galleryImg' . $num;

                // 이미지 파일 가져오기
                $image = $request->file($uploadName);

                // File Name Setting
                $fileName = $currentShopId . '_' . 'galleryImg' . '_' . $num .
                            '.' . $image->getClientOriginalExtension();

                // Upload File Save
                $image->storeAs($currentShopId, $fileName);

                // DB에 저장
                \App\Upload::create([
                    'filename'  => $fileName,
                    'shop_id'   => $currentShopId,
                    'path'      => $dbPath
                ]);
            }
        }
        else
            echo '파일이 없습니다';

        // return redirect()->intended('main');

       // return var_dump($request->all());

    }
}
