<?php

namespace App\Http\Controllers;

use App\Restaurant;
use Illuminate\Http\Request;
use App\Suboption;
use App\Order_List;
use App\Order_Menu;
use App\Order_Option;

class OrderController extends Controller
{
    const client_id     = "1ml1HFOe7ffSU4tD0da7";
    const client_secret = "qubdYMY8uA";

    private $url     = "https://openapi.naver.com/v1/language/translate";
    private $is_post = true;
    private $headers = array();

    function __construct()
    {
        $this->headers[] = "X-Naver-Client-Id: ".OrderController::client_id ;
        $this->headers[] = "X-Naver-Client-Secret: ".OrderController::client_secret ;
    }

    // <-- 주문하기
    public function makeOrder(Request $request) {

        // 먼저 OrderList Table에 OrderList 추가 후 Reservation Table에 등록
        Order_List::create([
            'shop_id' => $request->get('shop_id'),
            'user_num' => auth()->user()->id,
            'order_date' => date("Y-m-d H:i:s"),
            'total'     => $request->get('sum_price')
        ]);

        $orderData = Order_List::where('shop_id', $request->get('shop_id'))
            ->where('user_num', auth()->user()->id)
            ->orderByRaw('order_num DESC')
            ->first();

        $orderNum = $orderData->order_num;

        // 필요한것 : 주문 Menu 갯수 , Option, SubOption 갯수
        $menuNum         = $request->get('menulength');
        $menuArray       = $request->get('menu_id');
        $optionArray     = $request->get('option');
        $subOptionArray  = $request->get('suboption');

        for( $menuIndex = 0 ; $menuIndex < $menuNum ; $menuIndex++) {
            $menuId = $menuArray[$menuIndex];

            Order_Menu::create([
                'menu_id'    => $menuId,
                'order_num'  => $orderNum,
            ]);

            $orderMenuData  = Order_Menu::where('order_num', $orderNum)
                ->orderByRaw('id DESC')
                ->first();

            $orderMenuId = $orderMenuData->id;

            $thisMenuOption = $optionArray[$menuIndex];
            $thisSubOption = $subOptionArray[$menuIndex];

            for($optionIndex = 0 ; $optionIndex < count($thisMenuOption) ; $optionIndex++) {

                $currentOption       = $thisMenuOption[$optionIndex];
                if(isset($thisSubOption[$optionIndex])) {
                    $currentSubOption    = $thisSubOption[$optionIndex];

                    $subOption = Suboption::where('opnum', $currentOption)
                        ->where('name', $currentSubOption)
                        ->first();

                    $subOpNum = $subOption->sub_opnum;
                }

                else
                    $subOpNum    = null;

                Order_Option::create([
                    'op_num'          =>  $currentOption,
                    'subop_num'       =>  $subOpNum,
                    'order_menu_id'   =>  $orderMenuId,
                ]);

            } // <-- option For End

        }

        return response()->json([
            'msg' => count($thisMenuOption),
        ]);



    }

    public function cancelOrder(Request $request) {

    }


    public function translateOrder(Request $request)
    {
        $source = '';

        switch (auth()->user()->country) {

            case 'Korea' :
                {
                    $source = 'ko';
                    break;
                }

            case 'China' :
                {
                    $source = 'zh-CN';
                    break;
                }

            case 'Usa' :
                {
                    $source = 'en';
                    break;
                }

        } // <-- switch end

        $menuArray = $request->get('Menu');
        $menuCount = $request->get('MenuCount');
        $opArray = $request->get('Option');
        $opCount = $request->get('OpCount');
        $subOpArray = $request->get('subOption');
        $subOpCount = $request->get('subOpCount');
        $translateArray = array();

        for ($orderIndex = 0; $orderIndex < $menuCount; $orderIndex++) {

            $currentOpCount = $opCount[$orderIndex];
            $currentSubOpCount = $subOpCount[$orderIndex];

            $encText = urlencode($menuArray[$orderIndex]);
            $postValues = 'source=' . $source . '&target=ja&text='.$encText;
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

            $indexName = 'menu' . $orderIndex;

            if($status_code == 200) {
                $responseData = json_decode($response);

                $translateArray[$indexName]  = $responseData->message->result->translatedText;
            }
            else
                $translateArray[$indexName] = $menuArray[$orderIndex];


            for ($optionIndex = 0; $optionIndex < $currentOpCount; $optionIndex++) {

                if ($currentSubOpCount != 0) {

                    $encText = urlencode($opArray[$orderIndex][$optionIndex]);
                    $postValues = 'source=' . $source . '&target=ja&text='.$encText;
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

                    $indexName = 'option' . $orderIndex;

                    if($status_code == 200) {
                        $responseData = json_decode($response);

                        $translateArray[$indexName]  = $responseData->message->result->translatedText;
                    }
                    else
                        $translateArray[$indexName] = $opArray[$orderIndex][$optionIndex];

                    $currentSubOpCount--;

                    $encText = urlencode($subOpArray[$orderIndex][$optionIndex]);
                    $postValues = 'source=' . $source . '&target=ja&text='.$encText;
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

                    $indexName = 'suboption' . $orderIndex;

                    if($status_code == 200) {
                        $responseData = json_decode($response);

                        $translateArray[$indexName]  = $responseData->message->result->translatedText;
                    }
                    else {
                        $translateArray[$indexName] = $subOpArray[$orderIndex][$optionIndex];
                    }

                }
                else {
                    $encText = urlencode($opArray[$orderIndex][$optionIndex]);
                    $postValues = 'source=' . $source . '&target=ja&text='.$encText;
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

                    $indexName = 'option' . $orderIndex;

                    if($status_code == 200) {
                        $responseData = json_decode($response);

                        $translateArray[$indexName]  = $responseData->message->result->translatedText;
                    }
                    else
                        $translateArray[$indexName] = $opArray[$orderIndex][$optionIndex];
                }

            } // <-- option For End

            $translateArray["menuNum"] = $menuCount;

        } // <-- menu For end

        if($status_code == 200)
            return response()->json([
                'flag'    => true,
                'content' => $translateArray,
            ]);
        else
            return response()->json([
                'flag'    => false,
                'content' => $response,
            ]);
    }
}
