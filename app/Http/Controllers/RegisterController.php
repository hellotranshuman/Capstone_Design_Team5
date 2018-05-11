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
    public function showRegisterForm() {
        return view('user.userRegisterForm');
    }

    // <-- create Member in Users Table
    public function createMember(Request $request) {

        /*
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
        else { */
        // <-- user Category 처리
        //  $category = $request->get('category') == 'user' ? true : false;


        /*
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
            $day; */

        /*

    ]); */

        $category = $request->get('category') == 'true' ? true : false;


        // <-- db에 Create Column
        $user = \App\User::create([
            'password' => Hash::make($request->get('password')),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'gender'=> $request->get('gender') == 'true' ? true : false,
            'country' => $request->get('country'),
            'birthday' => $request->get('birthday'),
            'category' => $category,
            'user_id' => $request->get('user_id'),
            'favorite_1' => $request->get('favorite1'),
            'favorite_2' => $request->get('favorite2'),
            'favorite_3' => $request->get('favorite3'),
            'favorite_region' => $request->get('favorite_region'),
        ]);

        auth()->login($user);

        if(! $category)
            return response()->json([
                'url' => '/owner/createRestaurant'
            ]);
        else
            return response()->json([
                'url' => '/'
            ]);
    }
    // }
}