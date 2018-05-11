<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Restaurant;
use \App\Layout;

class LayoutController extends Controller
{
    // <-- 현재 선택된 템플릿 번호 불러오기
    public function getSelectedLayout($shop_id) {

        $layoutData =Restaurant::select('selectLayout')
                        ->where('id', $shop_id)
                        ->first();

        $layoutNum = $layoutData->selectLayout;

        return response()->json([
           'layoutNum' => $layoutNum,
        ]);

    }

    // <-- 유저가 만든 레이아웃 저장
    public function saveCustomLayout(Request $request) {
         $layout = $request->get('Menu');
         $shopId = $request->get('shop_id');

        Layout::create([
            'shop_id'        => $shopId,
            'layout_data'    => $layout,
         ]);

        Restaurant::where('id', $shopId)
            ->update(['selectLayout' => 0]);

        return response()->json([
            'msg' => true,
        ]);

    }

    // <-- 유저가 만든 레이아웃  불러오기
    public function loadCustomLayout(Request $request) {
        $shopId = $request->get('shop_id');

        /*
        Layout::where('shop_id', $shopId)
            ->get();*/

    }

    // <-- 선택한 레이아웃 템플릿 저장
    public function saveSelectedLayout(Request $request) {

        $shopId = $request->get('shop_id');

        Restaurant::where('id', $shopId)
                    ->update(['selectLayout' => $request->get('slt_tem')]);

        return response()->json([
            'msg' => true,
        ]);

    }

}
