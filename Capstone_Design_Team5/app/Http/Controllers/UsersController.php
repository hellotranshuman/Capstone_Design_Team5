<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Input;
use \App\Restaurant;

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
                    'login' => 'false',
                    'msg' => '아이디나 비밀번호가 일치하지 않습니다!',
                ]);
            }
            else {
                if(!auth()->user()->category)
                {
                    $userId = auth()->user()->id;

                    $restaurant = Restaurant::where('user_num', $userId)
                                    ->get()
                                    ->first();

                    $restaurantId = $restaurant->id;

                    $request->session()->put('restaurantId', $restaurantId);

                    $link = '/owner/' . $restaurantId . '/menu';
                }
                else
                    $link = '/';

                // auth()->user()->id
                // auth()->user()->name
                return response()->json([
                    'login' => 'true',
                    'msg' => '로그인 되었습니다.',
                    'link' => $link,
                ]);
            }


    }

    public function doLogout(Request $request) {

        $request->session()->flush();

        auth()->logout();

        return '또봐요~~';
    }
}
