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
    const client_id     = "1ml1HFOe7ffSU4tD0da7";
    const client_secret = "qubdYMY8uA";

    private $url     = "https://openapi.naver.com/v1/language/translate";
    private $is_post = true;
    private $headers = array();

    function __construct()
    {
        $this->headers[] = "X-Naver-Client-Id: ".OrderController::client_id ;
        $this->headers[] = "X-Naver-Client-Secret: ".OrderController::client_secret ;
    }

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

        $resCheck = Restaurant::where('id', $shop_id)
                    ->count();

        if($resCheck == 0)
            return response()->json([
                'restaurant' => null,
            ]);

        $target = '';

        if(!auth()->check()) {
            $target = 'ja';
        }
        else {
            switch (auth()->user()->country) {

                case 'Korea' :
                    {
                        $target = 'ko';
                        break;
                    }

                case 'China' :
                    {
                        $target = 'zh-CN';
                        break;
                    }

                case 'Usa' :
                    {
                        $target = 'en';
                        break;
                    }

            } // <-- switch end
        }

        $restaurant = Restaurant::where('id', $shop_id)
                                 ->get()
                                 ->toArray();

        // <-- 가게이름 & 설명 번역
        $encText = urlencode($restaurant[0]['name']);
        $postValues = 'source=ja&target=' . $target . '&text='.$encText;
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

        if($status_code == 200) {
            $responseData = json_decode($response);

            $restaurant[0]['trans_name']  = $responseData->message->result->translatedText;
        }
        else {
            $restaurant[0]['trans_name']  = null;
        }

        $encText = urlencode($restaurant[0]['explanation']);
        $postValues = 'source=ja&target=' . $target . '&text='.$encText;
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

        if($status_code == 200) {
            $responseData = json_decode($response);

            $restaurant[0]['trans_explanation']  = $responseData->message->result->translatedText;
        }
        else {
            $restaurant[0]['trans_explanation']  = null;
        }

        $totalRating = Review::select(DB::raw('ROUND(AVG(rating), 2) as totalRating'))
                        ->where('shop_id', $shop_id)
                        ->get()
                        ->toArray();

        $file = Upload::select('path', 'filename')
                        ->where('shop_id', $shop_id)
                        ->get()
                        ->toArray();

        if(!auth()->check()) {
            $shopLikeNumData = 0;
        }
        else {
            $shopLikeNumData = Shop_like::where('user_num', auth()->user()->id)
                ->where('shop_id', $shop_id)
                ->count();
        }

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
            'children' => $request->input('children') == 'true' ? true : false,
            'pet' => $request->input('pet') == 'true' ? true : false,
            'parking' => $request->input('parking') == 'true' ? true : false,
            'smoking' => $request->input('smoking') == 'true' ? true : false,
            'privateroom' => $request->input('privateroom') == 'true' ? true : false,
            'lunch_open' => $request->input('lunch_open'),
            'lunch_close' => $request->input('lunch_close'),
            'lunch_lo' => $request->input('lunch_lo'),
            'dinner_open' => $request->input('dinner_open'),
            'dinner_close' => $request->input('dinner_close'),
            'dinner_lo' => $request->input('dinner_lo'),
            'namer'     => $request->input('nameR'),
            'coordinate_lat' => $request->input('coordinateLat'),
            'coordinate_lang' => $request->input('coordinateLng'),
            'qrcode' => $request->input('qrcode'),
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
                    'children' => $request->input('children') == 'true' ? true : false,
                    'pet' => $request->input('pet') == 'true' ? true : false,
                    'parking' => $request->input('parking') == 'true' ? true : false,
                    'smoking' => $request->input('smoking') == 'true' ? true : false,
                    'privateroom' => $request->input('privateroom') == 'true' ? true : false,
                    'lunch_open' => $request->input('lunch_open'),
                    'lunch_close' => $request->input('lunch_close'),
                    'lunch_lo' => $request->input('lunch_lo'),
                    'dinner_open' => $request->input('dinner_open'),
                    'dinner_close' => $request->input('dinner_close'),
                    'dinner_lo' => $request->input('dinner_lo'),
                    'namer'     => $request->input('nameR'),
                    'coordinate_lat' => $request->input('coordinateLat'),
                    'coordinate_lang' => $request->input('coordinateLng'),
                    'qrcode' => $request->input('qrcode'),
                ]);

        /*
         * 바뀔 이미지가 있는 경우 현재 이미지 다 지우고
         * 새로운 이미지로 교체 하기
         * */


        // gallery 이미지 갯수
        $imageNum = $request->get('num');
        // db에 저장할 경로
        $dbPath = '/images/'. $shop_id . '/';
        $deleteFlag = false;

        if($request->file('titleImg')) {

            $selectFileName = '%' . $shop_id . '_titleImg%';

            $fileData = Upload::where('filename', 'like', $selectFileName)
                ->first();

            $fileName = $fileData->filename;

            if($fileName != '') {
                $deleteFileName = '/'. $shop_id . '/'. $fileName;

                Storage::delete($deleteFileName);
            }

            // title Img 가져오기
            $titleImg = $request->file('titleImg');

            // File Name Setting
            $fileName = $shop_id . '_titleImg' . '.' . $titleImg->getClientOriginalExtension();

            // Upload File Save
            $titleImg->storeAs($shop_id, $fileName);

            Upload::where('filename', 'like', $selectFileName)
                ->update([
                    'filename' => $fileName,
                    'shop_id' => $shop_id,
                    'path' => $dbPath
                ]);

        }
        else if(is_null($request->get('titleImg'))) {
            $selectFileName = '%' . $shop_id . '_titleImg%';

            $fileData = Upload::where('filename', 'like', $selectFileName)
                            ->first();

            $fileName = $fileData->filename;

            if($fileName != '') {
                $deleteFileName = '/'. $shop_id . '/'. $fileName;

                Storage::delete($deleteFileName);

                Upload::where('filename', 'like', $selectFileName)
                    ->delete();
            }

        } // <-- titleImg If End

        for($imageIndex = 0 ; $imageIndex < $imageNum ; $imageIndex++ ) {

            $galleryIndexName = 'galleryImg' . $imageIndex;
            $selectGalleryFileName = '%' . $shop_id . '_galleryImg_' . $imageIndex . '%';

            /*
             *
             *  파일일 경우..
             * 　해당 갤러리 이미지 번호에 이미 이미지가 있을경우
             * */

            if($request->file($galleryIndexName)) {

                $fileCount = Upload::where('filename', 'like', $selectGalleryFileName)
                                ->count();

                if($fileCount != 0) {
                    $fileData = Upload::where('filename', 'like', $selectGalleryFileName)
                        ->first();

                    $galleryName = $fileData->filename;

                    $deleteFileName = '/'. $shop_id . '/'. $galleryName;

                    Storage::delete($deleteFileName);

                    Upload::where('filename', 'like', $selectGalleryFileName)
                        ->delete();
                }

                // gallery Img 가져오기
                $galleryImg = $request->file($galleryIndexName);

                // File Name Setting
                $fileName = $shop_id . '_galleryImg_' . $imageIndex . '.' . $galleryImg->getClientOriginalExtension();

                // Upload File Save
                $galleryImg->storeAs($shop_id, $fileName);

                Upload::create([
                        'filename' => $fileName,
                        'shop_id'  => $shop_id,
                        'path'     => $dbPath,
                    ]);

            }
            else if ($request->get($galleryIndexName) == 'dd') {

                $fileCount = Upload::where('filename', 'like', $selectGalleryFileName)
                            ->count();

                if($fileCount != 0) {

                    $fileData = Upload::where('filename', 'like', $selectGalleryFileName)
                        ->first();

                    $galleryName = $fileData->filename;

                    $deleteFileName = '/'. $shop_id . '/'. $galleryName;

                    Storage::delete($deleteFileName);

                    Upload::where('filename', 'like', $selectGalleryFileName)
                        ->delete();

                    $deleteFlag = true;
                }

            }
            else {

                $fileData = Upload::where('filename', 'like' ,$selectGalleryFileName)
                             ->first();

                if($deleteFlag)
                    $fileNumber = $imageIndex - 1;
                else
                    $fileNumber = $imageIndex;

                $currentGalleryName = $shop_id . '_galleryImg_' . $fileNumber;
                $fileName = $fileData->filename;

                $fileNameArray = explode('.', $fileName);
                $galleryName = $fileNameArray[0];

                // 해당 갤러리 번호와 다른 번호일 경우 지우고 다시 업뎃  아닐경우 업데이트 x
                if($currentGalleryName != $galleryName) {
                    $beforeName = '/'. $shop_id . '/' . $fileName;
                    $moveFileName = '/'. $shop_id . '/'. $currentGalleryName . '.' . $fileNameArray[1];

                    Storage::move($beforeName, $moveFileName);

                   Upload::where('filename', 'like' ,$selectGalleryFileName)
                       ->delete();

                   $currentGalleryName .= '.' . $fileNameArray[1];

                   Upload::create([
                       'filename' => $currentGalleryName,
                       'shop_id' =>  $shop_id,
                       'path' => $fileData->path,
                   ]);
                }
            } // <-- if End

        } // <-- gallery For End

        $link = route('restaurant.showRestaurantInfoForm' , ['shop_id' => $shop_id]);

        return response()->json([
           'msg' => true,
            'link' => $link,
        ]);

    }

    // <-- 식당 좋아요
    public function restaurantsLike(Request $request) {
        // 로그인 안되어 있을 경우
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
