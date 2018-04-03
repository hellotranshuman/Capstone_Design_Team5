<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Input;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // <-- create Member in Users Table
    public function createMember(Request $request) {
        // <-- 유효성 검사 규칙 정의
        $rules = array(
            'id' =>  'required|unique:users,user_id|max:255',
            'password' => 'required|confirmed|min:3',
            'name' => 'required',
            'email' => 'required|email',
            'gender' => 'required|in:male,female',
            'country' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        // <-- 유효성 검사 실패
        if ($validator->fails()) {
            if($request->input('category') == 'user')
                return Redirect::to('register/user')
                ->withErrors($validator)
                ->withInput($request->except('password'));
            else
                return Redirect::to('register/owner')
                    ->withErrors($validator)
                    ->withInput($request->except('password'));
        }
        else {
            // <-- user Category 처리
            $category = $request->input('category') == 'user' ? true : false;

            // <-- Date Format 처리
            if($request->input('month') < 10 )
                $month = '0' . $request->input('month');
            else
                $month = $request->input('month');

            if($request->input('day') < 10 )
                $day = '0' . $request->input('day');
            else
                $day = $request->input('day');

            $date = $request->input('year') . "-" .  $month . "-" .
                $day;

            // <-- db에 Create Column
            $user = \App\User::create([
                'password' => Hash::make($request->input('password')),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'gender'=> $request->input('gender') == 'male' ? true : false,
                'country' => $request->input('country'),
                'birthday' => $date,
                'category' => $category,
                'user_id' => $request->input('id'),
                'favorite_1' => $request->input('favorite_1'),
                'favorite_2' => $request->input('favorite_2'),
                'favorite_3' => $request->input('favorite_3')
            ]);


            auth()->login($user);

            return redirect()->intended('main');
        }
    }
}
