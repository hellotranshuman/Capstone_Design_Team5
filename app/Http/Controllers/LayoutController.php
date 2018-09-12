<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Restaurant;
use \App\Layout;
use Illuminate\Support\Facades\DB;

class LayoutController extends Controller
{
    // <-- Load Current Selected Layout Data
    public function getSelectedLayout($shop_id) {

        // Get Layout Number
        $layoutData = Restaurant::select('selectlayout')
                        ->where('id', $shop_id)
                        ->first();

        $layoutNum = $layoutData->selectlayout;

        // Case : Custom User Layout
        if($layoutNum > 4) {

            $layoutNameData = Layout::select('layout_name')
                            ->where('id', $layoutNum)
                            ->get()
                            ->toArray();

            $layoutName = $layoutNameData[0]["layout_name"];

        }
        // Case : Default Layout
        else
            $layoutName = 'デフォルトテンプレート';


        return response()->json([
            'layoutNum' => $layoutNum,
            'layoutName' => $layoutName,
        ]);

    }

    // <-- Save Custom User Layout
    public function saveCustomLayout(Request $request) {
         // get layout, shop id, layout name data
         $layout = $request->get('menu');
         $shopId = $request->get('shop_id');
         $name   = $request->get('name');

         // image routing route setting
         $dbPath = '/images/'. $shopId . '/';

         // save thumbnail data
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

        // get layout number
        $layoutIdData = Layout::select('id')
            ->where('shop_id', $shopId)
            ->first();

        $layoutId = $layoutIdData->id;

        // update layout number in restaurant table
        Restaurant::where('id', $shopId)
            ->update(['selectLayout' => $layoutId]);

        return response()->json([
            'msg' => true,
        ]);

    }

    // <-- Load Custom User Layout Data
    public function loadCustomLayout(Request $request) {
        // get shop id data
        $shopId     = $request->get('shop_id');

        // count layout data
        $layoutCount = Layout::select('layout_data')
                        ->where('shop_id', $shopId)
                        ->count();

        // case : layout data -> X
        if($layoutCount == 0)
            return response()->json([
                'layoutData' => null,
            ]);
        // case : layout data -> O
        else
            // get layout data
            $layoutData = Layout::select(DB::raw('CAST(layout_data as CHAR) as layout_data, id, shop_id, layout_name, thumbnail'))
                            ->where('shop_id', $shopId)
                            ->get()
                            ->toArray();

        return response()->json([
            'layoutData' => $layoutData,
        ]);

    }

    // <-- Update Custom User Layout
    public function updateCustomLayout(Request $request) {
        // get layout id, shop id, layout name data
        $layoutId = $request->get('id');
        $shopId = $request->get('shop_id');
        $name   = $request->get('name');

        // image routing route setting
        $dbPath = '/images/'. $shopId . '/';

        // save thumbnail data
        if($request->file('thumbnail')) {
            // get thumbnail data
            $thumbnail = $request->file('thumbnail');
            // thumbnail name setting
            $fileName = $name . '_thumbnail' . '.png';
            $dbFileName = $dbPath . $fileName;
            // thumbnail file save
            $thumbnail->storeAs($shopId, $fileName);
        }
        else {
            return response()->json([
                'msg' => false,
            ]);
        }

        // update layout data
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

    // <-- save selected layout setting
    public function saveSelectedLayout(Request $request) {

        // get shop id, select layout number
        $shopId         = $request->get('shop_id');
        $selectLayout   = $request->get('slt_tem');

        // update select layout number in restaurant table
        Restaurant::where('id', $shopId)
                    ->update(['selectLayout' => $selectLayout]);

        return response()->json([
            'msg' => true,
        ]);

    }

    // <-- delete selected layout data
    public function deleteSelectedLayout(Request $request) {

        // get layout number data
        $selectLayout   = $request->get('costom');

        // delete layout data by layout id
        Layout::where('id', $selectLayout)
            ->delete();

        return response()->json([
            'msg' => true,
        ]);

    }

}
