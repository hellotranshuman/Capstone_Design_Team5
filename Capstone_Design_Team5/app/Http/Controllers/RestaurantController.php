<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    public function showRestaurantForm() {
        if(auth()->user()->category == true)
            return 'failed!!!!!@@@';
        else
            return view('restaurant.createRestaurant');
    }

    public function createRestaurant(Request $request) {
        /*
        $restaurant = \App\Restaurant::create([
            'name' => $request->input('name'),
            'user_num' => auth()->user()->id,
            'type'=> $request->input('type'),
            'explanation'=>$request->input('explanation'),
            'phone' =>$request->input('phone'),
            'dodobuken' => 'test',
            'cities' => 'test',
            'address' => $request->input('address'),
            'lunch_open' => $request->input('lunch_open'),
            'lunch_close' => $request->input('lunch_close'),
            'lunch_lo' => $request->input('lunch_lo'),
            'dinner_open' => $request->input('dinner_open'),
            'dinner_close' => $request->input('dinner_close'),
            'dinner_lo' => $request->input('dinner_lo'),
            'payment' => $request->input('payment'),
            'seat_num' => $request->input('seat_num'),
            'children' => $request->input('children') == 'yes' ? true : false,
            'pet' => $request->input('pet') == 'yes' ? true : false,
            'parking' => $request->input('parking') == 'yes' ? true : false,
            'smoking' => $request->input('smoking') == 'yes' ? true : false,
            'privateroom' => $request->input('privateroom') == 'yes' ? true : false
        ]); */

        // <-- *** Image File Upload ***

        // check Shop Id
        $shopId = DB::table('restaurants')
                    ->select('id')
                    ->where('user_num', auth()->user()->id)
                    ->orderByRaw('created_at DESC')
                    ->first();

        $currentShopId = $shopId->id;

        // Current Save Shop Image Route
        $path = storage_path() . '/app/public/img/' . $currentShopId;

        // Check Shop Path
        if(is_dir($path))
            echo 'ok';
        // Make Shop Image SavePath
        else
            Storage::makeDirectory($currentShopId);

        $number = 1;

        if($request->file('titleImg')) {
            $titleImg = $request->file('titleImg');
            $fileName = $currentShopId . '_titleImg' . '.' . $titleImg->getClientOriginalExtension();
            $titleImg->storeAs($currentShopId, $fileName);
        }
        else {
            return '파일이 없습니다';
        }

        if($request->file('img')) {
            $images = $request->file('img');

            foreach ($images as $image) {
                $fileName = $currentShopId . '_img' . $number . '.' . $image->getClientOriginalExtension();
                $image->storeAs($currentShopId, $fileName);
                $number++;
                \App\Upload::create([
                   'filename' => $fileName,
                    'shop_id' => $currentShopId
                ]);
            }

        }
        else
            echo '파일이 없습니다';

        // return redirect()->intended('main');


    }
}
