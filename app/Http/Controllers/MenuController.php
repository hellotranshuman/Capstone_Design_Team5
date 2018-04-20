<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use \App\Menu;
use \App\Menu_Option;
use \App\Suboption;


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

    public function translate(Request $request) {

    }

    public function getMenu($shop_id, $category) {

        // <-- 메뉴정보를 저장할 Array
        $totalMenuArray = array();
        // <-- 메뉴 Data Select
        $menuData = Menu::join('menu_image', 'menu.id', '=', 'menu_image.menu_id')
                    ->select('menu.id as id', 'menu.name as name', 'menu.explanation as explanation',
                            'menu.price as price', 'menu.remark as remark',
                            'menu_image.filename as filename', 'menu_image.path as path')
                    ->where('menu.shop_id', $shop_id)
                    ->where('category', $category)
                    ->get();

        // <-- Menu Data Save in Array
        foreach ($menuData as $menu)
        {
           $menuArray = array();

           $menuArray['id'] = $menu->id;
           $menuArray['name'] = $menu->name;
           $menuArray['explanation'] = $menu->explanation;
           $menuArray['price'] = $menu->price;
           $menuArray['remark'] = $menu->remark;
           $menuArray['path'] = $menu->path;
           $menuArray['filename'] = $menu->filename;

           // <-- Option Data Select
           $optionData  = Menu_Option::where('menu_id', $menuArray['id'])
                                        ->get();

           foreach ($optionData as $option)
           {
               // <-- Option Data Save in Array
               $optionKey = 1;
               $opNum = $option->opnum;
               $keyName = 'optionName' . $optionKey;
               $menuArray[$keyName] = $option->name;

               // <-- SubOption Data Select
               $subOptionData = Suboption::where('opnum', $opNum)
                                            ->get();

               $subOpKey = 1;
               foreach ($subOptionData as $subOption)
               {
                   // <-- SubOption Data Save in Array
                   $subOpKeyName = 'optionValue' . $subOpKey;
                   $menuArray[$subOpKeyName]  = $subOption->name;
                   $subOpKey++;
               }
                   $menuArray['subOpNum'] = --$subOpKey;
           }

           array_push($totalMenuArray, $menuArray);

        }

        return response()->json([
            'shopId' => $shop_id,
            'category' => $category,
            'menu'  => $totalMenuArray,
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

        \App\Menu_Option::create([
            'menu_id' => $currentMenuId,
            'name' => $request->get('option_name'),
        ]);

        $optionNum = DB::table('menu_option')
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
