<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Input;
use \App\Restaurant;
use \App\User;

class UsersController extends Controller
{
    // <-- Show Login Page
    public function showLogin() {
        if(auth()->check())
            return redirect('/');
        // show the form
        else
            return View('user.login');
    }

    // <-- Login Method
    public function doLogin(Request $request) {

        // <-- Load Input User Login Info
        $userData = array(
            'user_id'     => $request->get('user_id'),
            'password'  => $request->get('password')
        );

        // <-- Login Info Check
        // Login Case -> False
        if (! auth()->attempt($userData, true)) {
            return response()->json([
                'login' => false,
            ]);
        }
        // Login Case -> True
        else {

            // User Category -> Restaurant
            if(!auth()->user()->category)
            {
                $userId = auth()->user()->id;

                $restaurant = Restaurant::where('user_num', $userId)
                    ->get()
                    ->first();

                // Restaurant Register Check
                if($restaurant)
                    $restaurant_id = $restaurant->id;
                else
                    $restaurant_id = "noneRestaurant";

                return response()->json([
                    'login' => true,
                    'restaurant_id' => $restaurant_id,
                    'user_id' => auth()->user()->user_id,
                    'user_name' => auth()->user()->name,
                ]);
            }

            // User Category -> User
            else {
                $restaurant_id = '/';
                $userInfo = User::where('id', auth()->user()->id)
                    ->get()
                    ->first();

                return response()->json([
                    'login' => true,
                    'restaurant_id' => $restaurant_id,
                    'user_id' => auth()->user()->user_id,
                    'user_name' => auth()->user()->name,
                    'favorite_region' => $userInfo->favorite_region,
                    'favorite_1' => $userInfo->favorite_1,
                    'favorite_2' => $userInfo->favorite_2,
                    'favorite_3' => $userInfo->favorite_3,
                    'country' => $userInfo->country,
                ]);
            }

        }


    }

    // <-- Logout Method
    public function doLogout(Request $request) {

        // Session Delete
        $request->session()->flush();

        // Logout -> Redirect HomePage Path
        auth()->logout();

        return redirect('/');
    }

    // <-- Load User Info Method
    public function getUserInfo(Request $request) {
        $user_id = $request->get('user_id');

        $userInfo = DB::table('users')
            ->where('user_id','=', $user_id)
            ->get();

        return $userInfo;
    }

    // <-- Update User Info Method
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