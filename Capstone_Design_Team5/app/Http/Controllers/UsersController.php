<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Input;

class UsersController extends Controller
{
    //
    public function showLogin()
    {
        // show the form
        return View('user.login');
    }

    public function doLogin(Request $request)
    {
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
        }

        else {

            // <-- User Login 정보 가져오기
            $userData = array(
                'user_id'     => $request->get('id'),
                'password'  => $request->get('password')
            );

            // <-- Login 정보 확인
            if (! auth()->attempt($userData, true)) {
                return Redirect::to('user.login');
            }
            else {
                return redirect()->intended('main');
            }

        }
    }

    public function doLogout()
    {
        auth()->logout();

        return '또봐요~~';
    }
}
