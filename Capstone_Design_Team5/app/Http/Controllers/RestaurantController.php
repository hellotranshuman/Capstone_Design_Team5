<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Restaurant;
use App\Upload;
use App\Review;

class RestaurantController extends Controller
{
    public function showRestaurantForm() {
        if(auth()->user()->category == true)
            return 'failed!!!!!@@@';
        else
            return view('restaurant.createRestaurant');
    }

    public function showRestaurantInfoForm() {

        return view('user.userRestaurant');
    }

    public function showRestaurantInfo($shop_id) {

        $restaurant = Restaurant::where('id', $shop_id)
                                 ->get()
                                 ->toArray();

        $totalRating = Review::select(DB::raw('ROUND(AVG(rating), 2) as totalRating'))
                        ->where('shop_id', $shop_id)
                        ->get()
                        ->toArray();

        $file = Upload::select('path', 'filename')
                        ->where('shop_id', $shop_id)
                        ->get()
                        ->toArray();

        $restaurantInfo = array_merge($restaurant, $totalRating, $file); //, $totalRating);

         return response()->json([
            // 'test' => RestaurantController::$shopId,
            'restaurant' => $restaurantInfo,
        ]);


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
            'cities' => $request->input('cities'),
            'address' => $request->input('address'),
            'payment' => $request->input('payment'),
            'seat_num' => $request->input('seat_num'),
            'children' => $request->input('children') == 'yes' ? true : false,
            'pet' => $request->input('pet') == 'yes' ? true : false,
            'parking' => $request->input('parking') == 'yes' ? true : false,
            'smoking' => $request->input('smoking') == 'yes' ? true : false,
            'privateroom' => $request->input('privateroom') == 'yes' ? true : false,
            'lunch_open' => $request->input('lunch_open'),
            'lunch_close' => $request->input('lunch_close'),
            'lunch_lo' => $request->input('lunch_lo'),
            'dinner_open' => $request->input('dinner_open'),
            'dinner_close' => $request->input('dinner_close'),
            'dinner_lo' => $request->input('dinner_lo'),
        ]);

        // check Shop Id
        $shopId = DB::table('restaurants')
                    ->select('id')
                    ->where('user_num', auth()->user()->id)
                    ->orderByRaw('id DESC')
                    ->first();

        $currentShopId = $shopId->id;

        // <-- *** Image File Upload ***

        // Current Save Shop Image Route
        $path = storage_path() . '/app/public/img/' . $currentShopId;
        $dbPath = '/images/'. $currentShopId . '/';

        // Check Shop Path
        if(!is_dir($path))
            // Make Shop Image SavePath
            Storage::makeDirectory($currentShopId);

        $number = $request->get('num');

        if($request->file('titleImg')) {
            // title Img 가져오기
            $titleImg = $request->file('titleImg');

            // File Name Setting
            $fileName = $currentShopId . '_titleImg' . '.' . $titleImg->getClientOriginalExtension();

            // Upload File Save
            $titleImg->storeAs($currentShopId, $fileName);

            // Create Upload File Column in Upload Table
            \App\Upload::create([
                'filename'   => $fileName,
                'shop_id'    => $currentShopId,
                'path'       => $dbPath
            ]);
        }

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

        $link = route('restaurant.showRestaurantInfoForm' , ['shop_id' => $currentShopId]);

         return response()->json([
             'msg'  => '등록이 완료되었습니다.',
             'link' => $link,
         ]);

    }

}
