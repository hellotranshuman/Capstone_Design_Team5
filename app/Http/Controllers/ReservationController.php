<?php

namespace App\Http\Controllers;

use App\Reservation;
use App\Suboption;
use App\Order_List;
use App\Order_Menu;
use App\Order_Option;
use App\Resset;
use App\Restaurant;
use Illuminate\Http\Request;


class ReservationController extends Controller
{
    public function showReservationList() {
        return view('restaurant.reservationList');
    }

    public function showReservationAccept() {
        return view('restaurant.reservationAccept');
    }

    public function showReservationSetting() {
        return view('restaurant.reservationSetting');
    }

    public function showAddReservationForm() {
        return view('user.addReservationForm');
    }

    public function requestReservation(Request $request) {
        $resDateTime = $request->get('date') . ' ' .
                        $request->get('time');

       if($request->get('menulength') != null) {

           // 먼저 OrderList Table에 OrderList 추가 후 Reservation Table에 등록
           Order_List::create([
               'shop_id' => $request->get('shop_id'),
               'user_num' => auth()->user()->id,
               'order_date' => $resDateTime,
               'total'     => $request->get('sum_price')
           ]);

           $orderData = Order_List::where('shop_id', $request->get('shop_id'))
               ->where('user_num', auth()->user()->id)
               ->orderByRaw('order_num DESC')
               ->first();

           $orderNum = $orderData->order_num;

           // 필요한것 : 주문 Menu 갯수 , Option
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

           Reservation::create([
               'shop_id' => $request->get('shop_id'),
               'user_num' => auth()->user()->id,
               'reservation_date' => $resDateTime,
               'person' => $request->get('adult_person'),
               'child' => $request->get('child_person'),
               'menu_select' => true,
               'order_num'  => $orderNum,
           ]);
       } // if End
        else {

            Reservation::create([
                'shop_id'           => $request->get('shop_id'),
                'user_num'          => auth()->user()->id,
                'reservation_date'  => $resDateTime,
                'message'           => $request->get('message'),
                'person'            => $request->get('adult_person'),
                'child'             => $request->get('child_person'),
                'menu_select'       => false
            ]);

        }

        return response()->json([
            'msg' => '예약 신청이 완료되었습니다.',
        ]);

    } // <-- function requestReservation End

    // <-- get Reservation Request List
    public function getReservationRequestList(Request $request) {

       $resData = Reservation::join('users', 'users.id', '=', 'reservation.user_num')
                    ->select('users.name', 'reservation.*')
                    ->where('shop_id', $request->get('shop_id'))
                    ->whereNull('accept')
                    ->get()
                    ->toArray();

       return response()->json([
          'resData' => $resData,
       ]);
    }

    // <-- accept Data Update in Reservation Table
    public function acceptReservation(Request $request) {

        $accept = $request->get('accept');
        $resId  = $request->get('id');

        // 예약 요청에 따른 예약 상태 Update
        if($accept == 'true') {
           Reservation::where('id', $resId)
           ->update(['accept' => true]);
        }
        else {
            Reservation::where('id', $resId)
                ->update(['accept' => false]);
        }

    }

    // <-- get Reservation List
    public function getReservationList(Request $request) {
        $resData = Reservation::join('users', 'users.id', '=', 'reservation.user_num')
            ->select('users.name', 'reservation.*')
            ->where('shop_id', $request->get('shop_id'))
            ->where('accept', true)
            ->get()
            ->toArray();

        return response()->json([
            'resData' => $resData,
        ]);
    }

    // <-- set Reservation Setting
    public function setReservationSetting(Request $request) {

        // 예약 가능 or 불가능 여부 확인
        if($request->get('impossible') == '예약 가능') {
            $remark = true;

            // 받아온 시간 데이터 Process
            for($index = 0 ; $index < $request->get('set_time_length') ; $index++)
            {
                $timeData = $request->get('set_time')[$index];

                // 시작시간의 분 -> 30분일경우 00으로 변경 반대의 경우 30으로 변경
                if(strpos($timeData, '3',3) === false)
                    $endTime = substr_replace($timeData, '30', 3);
                else
                {
                    // 분이 00일 경우 설정 시간 + 1시간 설정
                    // 23시일 경우 다음날이므로 00시로 설정
                    $hourData = substr($timeData, 0, 2);

                    if($hourData == '23')
                        $hour = '00';
                    else
                        $hour = $hourData + 1;

                    $settingHour = $hour . ':';
                    $endTime = substr_replace($timeData, $settingHour,  0);
                    $endTime = substr_replace($endTime, '00', 3);
                }

                // Create Reservation Setting Data in Resset Table
                Resset::create([
                    'shop_id'           => $request->get('shop_id'),
                    'setting_date'      => $request->get('setting_date'),
                    'start_time'        => $timeData,
                    'end_time'          => $endTime,
                    'remark'            => $remark,
                ]);

            }
        }

        else {
            $remark = false;

            // Create Reservation Setting Data in Resset Table
            Resset::create([
                'shop_id'           => $request->get('shop_id'),
                'setting_date'      => $request->get('setting_date'),
                'remark'            => $remark,
            ]);

            return response()->json([
                'flag' => 'true'
            ]);
        }

    }

    public function getReservationSettingList(Request $request) {

        $settingData = Resset::where('shop_id', $request->get('shop_id'))
                        ->get()
                        ->toArray();

        $restaurantData = Restaurant::select('lunch_open', 'lunch_close', 'dinner_open', 'dinner_close')
                            ->where('id', $request->get('shop_id'))
                            ->get()
                            ->toArray();

        $menuSelectData = Restaurant::select('reservation_selectMenu')
                            ->where('id', $request->get('shop_id'))
                            ->get()
                            ->toArray();

        return response()->json([
            'settingData'       => $settingData,
            'restaurantData'    => $restaurantData,
            'menuSelectData'    => $menuSelectData,
        ]);

    }

    // <-- 달력 클릭시 해당 달력의 날짜로 검색
    public function getReservationSettingByDate(Request $request) {

        $settingData = Resset::where('shop_id', $request->get('shop_id'))
            ->where('setting_date', $request->get('click_date'))
            ->get()
            ->toArray();

        return response()->json([
            'settingData'       => $settingData,
        ]);
    }

    // <-- 예약 설정 삭제
    public function deleteReservationSetting(Request $request) {

        Resset::where('resset_num', '=', $request->get('id'))
                ->delete();

        return response()->json([
           'flag'   =>  'true',
        ]);
    }

    // <-- 예약시 메뉴 선택 허용 & 비허용 여부
    public function updateReservationSelectMenu(Request $request) {
       $shop_id     = $request->get('shop_id');
       $selectFlag  = $request->get('reservation_selectMenu');

       if($selectFlag == 'true')
           $flag = true;
       else
           $flag = false;

        Restaurant::where('id', $shop_id)
            ->update(['reservation_selectMenu' => $flag]);

        return response()->json([
            'msg' => true,
        ]);
    }
}
