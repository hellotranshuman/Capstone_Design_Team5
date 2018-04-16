<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use \App\Menu;


class MenuController extends Controller
{
    public function showMenuForm() {
        return view('restaurant.ownerMenu');
    }

    public function showCreateMenuForm() {
        return view('restaurant.createMenuForm');
    }

    public function showMenuList() {
        return view('restaurant.ownerMenuList');
    }

    public function showMenuLayout() {
        return view('restaurant.ownerMenuLayout');
    }

    public function showUserMenuForm() {
        return view('user.userMenu');
    }

    public function getCategory(Request $request) {
        $shop_id = $request->get('shop_id');

       $category =  Menu::select('category')
                    ->where('shop_id', $request->get('shop_id'))
                    ->get()
                    ->toArray();

        return response()->json([
           'category' =>  $category,
        ]);
    }

    public function getMenu(Request $request) {
        // $shopId = $request->get('shop_id');

        $category = $request->get('test');

        return response()->json([
           // 'shopId' => $shopId,
            'category' => $category,
        ]);

    }

    public function createMenu(Request $request) {

        $shopId = $request->get('shop_id');

        // <-- create Menu in Menu Table
        \App\Menu::create([
            'shop_id' => $shopId,
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'explanation' => $request->get('explanation'),
            'category' => $request->get('category'),
            'remark' => $request->get('remark')
        ]);

        // check menu Id
        $menuId = DB::table('menu')
                ->select('id')
                ->where('shop_id', $shopId)
                ->orderByRaw('id DESC')
                ->first();

        $currentMenuId = $menuId->id;

        \App\Option::create([
            'menu_id' => $currentMenuId,
            'name' => $request->get('option_name'),
        ]);

        $optionNum = DB::table('option')
            ->select('opnum')
            ->where('menu_id', $currentMenuId)
            ->orderByRaw('opnum DESC')
            ->first();

        $currentOpNum = $optionNum->opnum;

        $subOpNum = $request->get('op_num');

        $subOpNum--;

        for($num = 1 ; $num <= $subOpNum ; $num++)
        {
            $opName = 'option_value' . $num;

            \App\Suboption::create([
               'opnum' => $currentOpNum,
               'name'  => $request->get($opName),
            ]);
        }

        // Current Save Shop Image Route
        $path = storage_path() . '/app/public/img/menu/' . $shopId;
        $dbPath = '/images/menu/' . $shopId . '/';

        $dir = '/menu/'.$shopId;

        // Check Shop Path
        if(! is_dir($path))
        // Make Shop Image SavePath
            Storage::makeDirectory($dir);

        if($request->file('menu_img')) {
            // menu Img 가져오기
            $menuImg = $request->file('menu_img');

            // File Name Setting
            $fileName = $shopId . '_menuImg_' . $currentMenuId . '.' . $menuImg->getClientOriginalExtension();

            // Upload File Save
            $menuImg->storeAs($dir, $fileName);

            // Create Upload File Column in Upload Table
            \App\Menu_Image::create([
                'filename'   => $fileName,
                'menu_id'    => $currentMenuId,
                'shop_id'    => $shopId,
                'path'       => $dbPath,
            ]);

            return response()->json([
                'content' => '메뉴 등록 성공!!',
            ]);

        }
        else {
            return response()->json([
                'content' => '파일이 없습니다...',
            ]);
        }



    }

}
