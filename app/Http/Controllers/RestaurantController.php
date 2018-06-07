<?php

namespace App\Http\Controllers;

use App\Shop_like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Restaurant;
use App\Upload;
use App\Review;

class RestaurantController extends Controller
{
    public function showRestaurantForm() {
        if(!auth()->check() || auth()->user()->category == true)
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

        $shopLikeNumData = Shop_like::where('user_num', auth()->user()->id)
                            ->where('shop_id', $shop_id)
                            ->count();

        if($shopLikeNumData == 0)
            $shopLike = false;
        else
            $shopLike = true;

        $restaurantInfo = array_merge($restaurant, $totalRating, $file); //, $totalRating);

         return response()->json([
            // 'translatedText' => RestaurantController::$shopId,
            'restaurant' => $restaurantInfo,
             'shopLike'  => $shopLike,
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

    // <-- 레스토랑 정보 수정시 가져올 레스토랑 정보
    public function getEditRestaurantInfo(Request $request) {
        $shop_id = $request->get('shop_id');

        $restaurantInfo = Restaurant::where('id', $shop_id)
                            ->get()
                            ->toArray();

        $file = Upload::select('path', 'filename')
                    ->where('shop_id', $shop_id)
                    ->get()
                    ->toArray();

        return response()->json([
           'restaurant'     => $restaurantInfo,
            'file'          => $file,
        ]);
    }

    public function updateRestaurantInfo(Request $request) {
        $shop_id = $request->get('shop_id');

        Restaurant::where('id', $shop_id)
                ->update([
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

        /*
         * 바뀔 이미지가 있는 경우 현재 이미지 다 지우고
         * 새로운 이미지로 교체 하기
         *
         * 1. 기존 이미지 갯수 DB로 가져오기
         * 2. 기존 이미지 전부 삭제
         * 3. 새로운 이미지 갯수에 따라서 새로운 이미지로 교체
         * 4. DB 삭제후 다시 등록... (갯수변동때메)
         * */

        if($request->file('')) {

          $uploadData = Upload::where('shop_id', $shop_id)
                            ->get();

          foreach ($uploadData as $upload) {
              $fileName = $upload->filename;

              $deleteFileName = '/'. $shop_id . '/'. $fileName;

              Storage::delete($deleteFileName);
          }

          Upload::where('shop_id', $shop_id)
              ->delete();

          $imageNum = $request->get('');
          $path = storage_path() . '/app/public/img/' . $shop_id;
          $dbPath = '/images/'. $shop_id . '/';

            if($request->file('titleImg')) {
                // title Img 가져오기
                $titleImg = $request->file('titleImg');

                // File Name Setting
                $fileName = $shop_id . '_titleImg' . '.' . $titleImg->getClientOriginalExtension();

                // Upload File Save
                $titleImg->storeAs($shop_id, $fileName);

                // Create Upload File Column in Upload Table
                \App\Upload::create([
                    'filename'   => $fileName,
                    'shop_id'    => $shop_id,
                    'path'       => $dbPath
                ]);
            }

            if($imageNum != 0) {
                for ($num = 0; $num < $imageNum; $num++) {
                    // 업로드한 파일 인덱스 찾기
                    $uploadName = 'galleryImg' . $num;

                    // 이미지 파일 가져오기
                    $image = $request->file($uploadName);

                    // File Name Setting
                    $fileName = $shop_id . '_' . 'galleryImg' . '_' . $num .
                        '.' . $image->getClientOriginalExtension();

                    // Upload File Save
                    $image->storeAs($shop_id, $fileName);

                    // DB에 저장
                    \App\Upload::create([
                        'filename' => $fileName,
                        'shop_id' => $shop_id,
                        'path' => $dbPath
                    ]);
                }
            }
        }

    }

    // <-- 식당 좋아요
    public function restaurantsLike(Request $request) {
        if(!auth()->check())
            return response()->json([
                'shopLike' => 'failed',
            ]);

        if($request->get('shopLike')) {

            Shop_like::create([
               'user_num' => auth()->user()->id,
               'shop_id'  => $request->get('shop_id'),
            ]);

            return response()->json([
                'shopLike' => true,
            ]);
        }
        else {
            Shop_like::where('user_num', auth()->user()->id)
                ->where('shop_id', $request->get('shop_id'))
                ->delete();

            return response()->json([
                'shopLike' => false,
            ]);
        }
    }

}
