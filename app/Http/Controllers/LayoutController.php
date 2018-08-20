<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Restaurant;
use \App\Layout;
use Illuminate\Support\Facades\DB;

class LayoutController extends Controller
{
    // <-- 현재 선택된 템플릿 번호 불러오기
    public function getSelectedLayout($shop_id) {

        $layoutData = Restaurant::select('selectlayout')
                        ->where('id', $shop_id)
                        ->first();

        $layoutNum = $layoutData->selectlayout;

        if($layoutNum > 4) {

            $layoutNameData = Layout::select('layout_name')
                            ->where('id', $layoutNum)
                            ->get()
                            ->toArray();

            $layoutName = $layoutNameData[0]["layout_name"];

        }

        else
            $layoutName = 'デフォルトテンプレート';


        return response()->json([
            'layoutNum' => $layoutNum,
            'layoutName' => $layoutName,
        ]);

    }

    // <-- 유저가 만든 레이아웃 저장
    public function saveCustomLayout(Request $request) {
         $layout = $request->get('menu');
         $shopId = $request->get('shop_id');
         $name   = $request->get('name');

         $dbPath = '/images/'. $shopId . '/';

        if($request->file('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $fileName = $name . '_thumbnail' . '.png';

            $dbFileName = $dbPath . $fileName;

            $thumbnail->storeAs($shopId, $fileName);
        }
        else {
            return response()->json([
                'msg' => false,
            ]);
        }

        Layout::create([
            'shop_id'        => $shopId,
            'layout_data'    => $layout,
            'layout_name'    => $name,
            'thumbnail'      => $dbFileName,
         ]);

       $layoutIdData = Layout::select('id')
            ->where('shop_id', $shopId)
            ->first();

        $layoutId = $layoutIdData->id;

        Restaurant::where('id', $shopId)
            ->update(['selectLayout' => $layoutId]);

        return response()->json([
            'msg' => true,
        ]);

    }

    // <-- 유저가 만든 레이아웃 불러오기
    public function loadCustomLayout(Request $request) {
        $shopId     = $request->get('shop_id');

        $layoutCount = Layout::select('layout_data')
                        ->where('shop_id', $shopId)
                        ->count();

        if($layoutCount == 0)
            return response()->json([
                'layoutData' => null,
            ]);
        else
            $layoutData = Layout::select(DB::raw('CAST(layout_data as CHAR) as layout_data, id, shop_id, layout_name, thumbnail'))
                            ->where('shop_id', $shopId)
                            ->get()
                            ->toArray();

        return response()->json([
            'layoutData' => $layoutData,
        ]);

    }

    public function updateCustomLayout(Request $request) {
        $layoutId = $request->get('id');
        $shopId = $request->get('shop_id');
        $name   = $request->get('name');
        $dbPath = '/images/'. $shopId . '/';

        if($request->file('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $fileName = $name . '_thumbnail' . '.png';
            $dbFileName = $dbPath . $fileName;


            $thumbnail->storeAs($shopId, $fileName);
        }
        else {
            return response()->json([
                'msg' => false,
            ]);
        }


        Layout::where('id', $layoutId)
            ->update([
                'layout_data'       => $request->get('menu'),
                'layout_name'       => $name,
                'thumbnail'         => $dbFileName,
            ]);

        return response()->json([
            'msg' => true,
        ]);

    }

    // <-- 선택한 레이아웃 템플릿 저장
    public function saveSelectedLayout(Request $request) {

        $shopId         = $request->get('shop_id');
        $selectLayout   = $request->get('slt_tem');



        Restaurant::where('id', $shopId)
                    ->update(['selectLayout' => $selectLayout]);

        return response()->json([
            'msg' => true,
        ]);

    }

    // <-- 선택한 레이아웃 템플릿 삭제
    public function deleteSelectedLayout(Request $request) {

        $selectLayout   = $request->get('costom');

        Layout::where('id', $selectLayout)
            ->delete();

        return response()->json([
            'msg' => true,
        ]);

    }

}
