<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Restaurant;

class LayoutController extends Controller
{
    public function getSelectedLayout($shop_id) {

        $layoutData =Restaurant::select('selectLayout')
                        ->where('id', $shop_id)
                        ->first();

        $layoutNum = $layoutData->selectLayout;

        return response()->json([
           'layoutNum' => $layoutNum,
        ]);


    }
}
