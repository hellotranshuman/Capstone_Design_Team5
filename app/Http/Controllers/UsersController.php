<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Validator;
use Input;
use \App\Restaurant;
use \App\User;

class UsersController extends Controller
{
    //
    public function showLogin() {
        if(auth()->check())
            return redirect('/');
        // show the form
        else
            return View('user.login');
    }

    // <-- 로그인
    public function doLogin(Request $request) {
        /*
        // <-- 유효성 검사 규칙 정의
        $rules = array(
            'id'    => 'required',
            'password' => 'required|min:3',
        );

        // <-- 유효성 검사 Message 설정
        $messsages = array(
            'id.required'=>'아이디를 입력하세여~~',
            'password.required'=>'비번을 입력하세여~~',
            'password.min'=>'비번 글자가 짧아여~~',
        );

        // <-- 유효성 검사 실행
        $validator = Validator::make($request->all(), $rules, $messsages);

        // <-- 유효성 검사 실패
        if ($validator->fails()) {
            return Redirect::to('user.login')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }      */


        // <-- User Login 정보 가져오기
        $userData = array(
            'user_id'     => $request->get('user_id'),
            'password'  => $request->get('password')
        );

        // <-- Login 정보 확인
        if (! auth()->attempt($userData, true)) {
            return response()->json([
                'login' => false,
                'msg' => '아이디와 비밀번호를 확인해주세요.',
            ]);
        }
        else {
            if(!auth()->user()->category)
            {
                $userId = auth()->user()->id;

                $restaurant = Restaurant::where('user_num', $userId)
                    ->get()
                    ->first();

                if($restaurant)
                    $restaurant_id = $restaurant->id;
                else
                    $restaurant_id = "noneRestaurant";
            }
            else
                $restaurant_id = '/';

            // auth()->user()->id
            // auth()->user()->name
            return response()->json([
                'login' => true,
                'restaurant_id' => $restaurant_id,
                'user_id' => auth()->user()->user_id,
                'user_name' => auth()->user()->name
            ]);
        }


    }

    // <-- 로그아웃
    public function doLogout(Request $request) {

        $request->session()->flush();

        auth()->logout();

        return redirect('/');
    }

    // <-- User 정보 받아오기
    public function getUserInfo(Request $request) {
        $user_id = $request->get('user_id');

        $userInfo = DB::table('users')
            ->where('user_id','=', $user_id)
            ->get();

        return $userInfo;
    }

    // <-- User 정보 수정
    public function editUserInfo(Request $request) {
        User::where('id', auth()->user()->id)
            ->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'gender'=> $request->get('gender') == 'Female' ? true : false,
                'country' => $request->get('country'),
                'birthday' => $request->get('birthday'),
                'favorite_1' => $request->get('favorite_1'),
                'favorite_2' => $request->get('favorite_2'),
                'favorite_3' => $request->get('favorite_3'),
                'favorite_region' => $request->get('favorite_region'),
            ]);
    }
}