<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{

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

        // echo var_dump($ratingData);

    }
}
