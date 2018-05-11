<?php

namespace App\Http\Controllers;

use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use \App\Review;

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

    public function getReviewData() {
        $review = Review::join('restaurants', 'review.shop_id', '=', 'restaurants.id')
            ->select('restaurants.*', DB::raw('MAX(review.reg_date)'))
            ->groupBy('review.shop_id')
            ->get()
            ->toArray();

        return var_dump($review);
    }

    public function getRecommendShopData($shop_id) {

    }

    public function test() {
        /*
        $files = DB::table('upload')
            ->select('shop_id', 'filename', 'path')
            ->get();

        $flag = true;
        $number = 0;
        foreach ($files as $file) {
            if($flag) {
                $array['titleImg'] = $file->path . $file->filename;
                $flag = false;
            }

            else  {
                $name = 'galleryImg'.$number;
                $array[$name] = $file->path . $file->filename;
            }

        }

        return view('test')->with($array);*/

        $ddd = DB::table('restaurants')
            ->select('*')
            ->where('user_num', auth()->user()->id)
            ->orderByRaw('id DESC')
            ->first();

       return view('test', ['ddd' => $ddd]);
    }



}
