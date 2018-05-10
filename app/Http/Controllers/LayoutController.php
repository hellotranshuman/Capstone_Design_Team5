<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Restaurant;
use \App\Layout;

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

    public function saveCustomLayout(Request $request) {
         $layout = $request->get('Menu');
         $shopId = $request->get('shop_id');



        Layout::create([
            'shop_id' => 1,
            'layout'  => '{"createdMenu":{"width":"32%","height":"45%","top":"13%","left":"22%","border":"
","borderRadius":"","color":""},"MenuNum":"3","MenuMargin":"10px"}',
         ]);

        return response()->json([
            'msg' => $layout,
        ]);

    }


}
