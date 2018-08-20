<?php

namespace App\Http\Controllers;

use App\Layout;
use App\Order_Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use \App\Menu;
use \App\Menu_Option;
use \App\Suboption;
use \App\Restaurant;

class MenuController extends Controller
{
    const client_id     = "yW2oDpUuRW0O7sbIKUJ2";
    const client_secret = "pevANwIHvX";

    private $url     = "https://openapi.naver.com/v1/language/translate";
    private $is_post = true;
    private $headers = array();

    function __construct()
    {
        $this->headers[] = "X-Naver-Client-Id: ".OrderController::client_id ;
        $this->headers[] = "X-Naver-Client-Secret: ".OrderController::client_secret ;
    }

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

    // <-- 해당 가게의 레이아웃, 메뉴 카테고리 불러오기
    public function getCategory(Request $request) {
        $shop_id = $request->get('shop_id');
        $layout = '';

        $layoutData = Restaurant::select('selectLayout')
            ->where('id', $shop_id)
            ->first();

        $layoutNum = $layoutData->selectLayout;

        if($layoutNum > 4) {
          $layout  = Layout::select(DB::raw('CAST(layout_data as CHAR) as layout_data, id, shop_id, layout_name, thumbnail'))
                        ->where('id', $layoutNum)
                        ->get()
                        ->toArray();
        }

        $category =  Menu::select('category')
                    ->where('shop_id', $shop_id)
                    ->get()
                    ->toArray();

        return response()->json([
           'category' =>  $category,
            'layout'  =>  $layout
        ]);
    }

    // <-- 해당 카테고리의 메뉴 정보 가져오기
    public function getMenu($shop_id, $category) {
        $target = '';

        if(!auth()->check()) {
            $target = 'ja';
        }
        else {
            switch (auth()->user()->country) {

                case 'Korea' :
                    {
                        $target = 'ko';
                        break;
                    }

                case 'China' :
                    {
                        $target = 'zh-CN';
                        break;
                    }

                case 'Usa' :
                    {
                        $target = 'en';
                        break;
                    }

                case 'Japan' :
                    {
                        $target = 'ja';
                        break;
                    }

            } // <-- switch end
        }

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

           // <-- 메뉴 이름 번역
            $encText = urlencode($menu->name);
            $postValues = 'source=ja&target=' . $target . '&text='.$encText;
            $ch  = curl_init();

            curl_setopt($ch,CURLOPT_URL, $this->url);
            curl_setopt($ch,CURLOPT_POST, $this->is_post);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $postValues);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch,CURLOPT_HTTPHEADER, $this->headers);

            $response    = curl_exec ($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close ($ch);

            if($status_code == 200) {
                $responseData = json_decode($response);

                $menuArray['name']  = $responseData->message->result->translatedText;
            }
            else
                $menuArray['name'] = $menu->name;

            // <-- 메뉴 설명 번역
            $encText = urlencode($menu->explanation);
            $postValues = 'source=ja&target=' . $target . '&text='.$encText;
            $ch  = curl_init();

            curl_setopt($ch,CURLOPT_URL, $this->url);
            curl_setopt($ch,CURLOPT_POST, $this->is_post);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $postValues);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch,CURLOPT_HTTPHEADER, $this->headers);

            $response    = curl_exec ($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close ($ch);

            if($status_code == 200) {
                $responseData = json_decode($response);

                $menuArray['explanation']  = $responseData->message->result->translatedText;
            }
            else
                $menuArray['explanation'] = $menu->explanation;

           $menuArray['price']      = $menu->price;
           $menuArray['remark']     = $menu->remark;
           $menuArray['path']       = $menu->path;
           $menuArray['filename']   = $menu->filename;

           // <-- Option Data Select
            $optionData  = Menu_Option::where('menu_id', $menuArray['id'])
                                        ->get();
            $optionCount = Menu_Option::where('menu_id', $menuArray['id'])
                            ->count();
            $menuArray['opNum'] = $optionCount;
            $optionKey = 1;

           foreach ($optionData as $option)
           {

               // <-- Option Data Save in Array

               $opNum = $option->opnum;
               $opIdName = 'optionId' . $optionKey;
               $menuArray[$opIdName] = $opNum;
               $keyName = 'optionName' . $optionKey;

                // <-- 옵션 이름 번역
               $encText = urlencode($option->name);
               $postValues = 'source=ja&target=' . $target . '&text='.$encText;
               $ch  = curl_init();

               curl_setopt($ch,CURLOPT_URL, $this->url);
               curl_setopt($ch,CURLOPT_POST, $this->is_post);
               curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
               curl_setopt($ch,CURLOPT_POSTFIELDS, $postValues);
               curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
               curl_setopt($ch,CURLOPT_HTTPHEADER, $this->headers);

               $response    = curl_exec ($ch);
               $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

               curl_close ($ch);

               if($status_code == 200 && auth()->user()->country != 'Japan') {
                   $responseData = json_decode($response);

                   $menuArray[$keyName]  = $responseData->message->result->translatedText;
               }
               else
                   $menuArray[$keyName] = $option->name;

               // <-- SubOption Data Select
               $subOptionData = Suboption::where('opnum', $opNum)
                                            ->get();

               $subOpKey = 1;

               foreach ($subOptionData as $subOption)
               {
                   // <-- SubOption Data Save in Array
                   $subOpKeyName = $optionKey .'optionValue' . $subOpKey;
                   $subOpIDName = $optionKey .'subOptionId' . $subOpKey;

                   // <-- subOption 이름 번역
                   $encText = urlencode($subOption->name);
                   $postValues = 'source=ja&target=' . $target . '&text='.$encText;
                   $ch  = curl_init();

                   curl_setopt($ch,CURLOPT_URL, $this->url);
                   curl_setopt($ch,CURLOPT_POST, $this->is_post);
                   curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
                   curl_setopt($ch,CURLOPT_POSTFIELDS, $postValues);
                   curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
                   curl_setopt($ch,CURLOPT_HTTPHEADER, $this->headers);

                   $response    = curl_exec ($ch);
                   $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                   curl_close ($ch);

                   if($status_code == 200) {
                       $responseData = json_decode($response);

                       $menuArray[$subOpKeyName]  = $responseData->message->result->translatedText;
                   }
                   else
                       $menuArray[$subOpKeyName] = $subOption->name;

                   // $menuArray[$subOpKeyName]  = $subOption->name;
                   $menuArray[$subOpIDName]   = $subOption->sub_opnum;

                   $subOpKey++;

               }
               $subOpNumName = 'subOpNum' . $optionKey;
               $menuArray[$subOpNumName] = --$subOpKey;

               $optionKey++;

           }
            array_push($totalMenuArray, $menuArray);

        }

        return response()->json([
            'shopId' => $shop_id,
            'category' => $category,
            'menu'  => $totalMenuArray,
        ]);

    }

    // <-- 메뉴 등록
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

        // add Option Value in Option table
        if($request->has('option')) {
            $opArr = $request->get('option');

            for( $opNum = 0 ; $opNum <  count($opArr) ; $opNum++) {
                $opName = $opArr[$opNum]['name'];

                \App\Menu_Option::create([
                    'menu_id' => $currentMenuId,
                    'name' => $opName,
                ]);

                $optionNum = DB::table('menu_option')
                    ->select('opnum')
                    ->where('menu_id', $currentMenuId)
                    ->orderByRaw('opnum DESC')
                    ->first();

                $currentOpNum = $optionNum->opnum;

                // add SubOption Value in SubOption Table
                $subOpNum = $opArr[$opNum]['num'];

                for($num = 0 ; $num < $subOpNum ; $num++)
                {
                    $opName = 'value' . $num;

                    \App\Suboption::create([
                        'opnum' => $currentOpNum,
                        'name'  => $opArr[$opNum][$opName],
                    ]);
                }

            } // <-- option for End
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
                'content' => 'メニューの登録を完了しました。',
            ]);

        }
        else {
            return response()->json([
                'content' => 'ファイルがないです。',
            ]);
        }

    }

    // <--  현재 선택된 레이아웃 번호 불러오기
    public function getLayoutNumber(Request $request) {
        $layoutData = Restaurant::select('selectlayout')
                        ->where('id', $request->get('shop_id'))
                        ->first();

        $layoutNum = $layoutData->selectlayout;

        if($layoutNum > 4) {
            $layoutNum = 0;
        }

        return response()->json([
            'layoutNum' => $layoutNum,
        ]);
    }

    // <-- Menu 삭제
    public function deleteMenu(Request $request) {
        $shop_id = $request->get('menu_id');

        Menu::where('id', $shop_id)
            ->delete();

        return response()->json([
            'msg'   => true,
        ]);
    }

    // <-- Menu  수정
    public function updateMenu(Request $request)
    {
        // 메뉴, 가게 id 가져오기
        $menu_id = $request->get('menu_id');
        $shopId = $request->get('shop_id');

        // 메뉴 정보 업데이트
        Menu::where('id', $menu_id)
            ->update([
                'name'          => $request->get('name'),
                'price'         => $request->get('price'),
                'category'      => $request->get('category'),
                'explanation'   => $request->get('explanation'),
                'remark'        => $request->get('remark'),
            ]);

        // add Option Value in Option table
        if ($request->has('option')) {

            $opDataList = \App\Menu_Option::where('menu_id', $menu_id)
                        ->get();

            // 옵션 데이터가 있을 경우 먼저 삭제 한 후 다시 Insert
            foreach ($opDataList as $opData) {
                $opNum = $opData->opnum;

               Menu_Option::where('opnum', $opNum)
                    ->delete();
            }

            $opArr = $request->get('option');

            // 옵션 추가
            for ($opNum = 0; $opNum < count($opArr); $opNum++) {
                $opName = $opArr[$opNum]['name'];

                \App\Menu_Option::create([
                    'menu_id'   => $menu_id,
                    'name'      => $opName,
                ]);

                $optionNum = DB::table('menu_option')
                    ->select('opnum')
                    ->where('menu_id', $menu_id)
                    ->orderByRaw('opnum DESC')
                    ->first();

                $currentOpNum = $optionNum->opnum;

                // add SubOption Value in SubOption Table
                $subOpNum = $opArr[$opNum]['num'];

                for ($num = 0; $num < $subOpNum; $num++) {
                    $opName = 'value' . $num;

                    \App\Suboption::create([
                        'opnum'     => $currentOpNum,
                        'name'      => $opArr[$opNum][$opName],
                    ]);
                }

            } // <-- option for End

        } // <-- if End

        // Current Save Shop Image Route
        $dbPath = '/images/menu/' . $shopId . '/';

        $dir = '/menu/'. $shopId;

        if($request->file('menu_img')) {
          $menuImageData = \App\Menu_Image::where('menu_id', $menu_id)
                            ->first();

          $menuImageFileName = $menuImageData->filename;

          $deleteFileName = $dir . '/' . $menuImageFileName;

          Storage::delete($deleteFileName);

            // menu Img 가져오기
            $menuImg = $request->file('menu_img');

            // File Name Setting
            $fileName = $shopId . '_menuImg_' . $menu_id . '.' . $menuImg->getClientOriginalExtension();

            // Upload File Save
            $menuImg->storeAs($dir, $fileName);

            // Create Upload File Column in Upload Table
            \App\Menu_Image::where('menu_id', $menu_id)
                ->update([
                'filename'   => $fileName,
                'shop_id'    => $shopId,
                'path'       => $dbPath,
            ]);

            return response()->json([
                'content' => 'メニューの登録を完了しました。',
            ]);

        }
        else {
            return response()->json([
                'content' => 'メニューの登録を完了しました。',
            ]);
        }

    }

}
