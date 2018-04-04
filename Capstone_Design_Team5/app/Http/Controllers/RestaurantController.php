<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function showRestaurantForm() {
        if(auth()->user()->category == true)
            return 'failed!!!!!@@@';
        else
            return view('restaurant.createRestaurant');
    }

    public function createRestaurant(Request $request) {

        $restaurant = \App\Restaurant::create([
            'name' => $request->input('name'),
            'user_num' => auth()->user()->id,
            'type'=> $request->input('type'),
            'explanation'=>$request->input('explanation'),
            'phone' =>$request->input('phone'),
            'dodobuken' => 'test',
            'cities' => 'test',
            'address' => $request->input('address'),
            'lunch_open' => $request->input('lunch_open'),
            'lunch_close' => $request->input('lunch_close'),
            'lunch_lo' => $request->input('lunch_lo'),
            'dinner_open' => $request->input('dinner_open'),
            'dinner_close' => $request->input('dinner_close'),
            'dinner_lo' => $request->input('dinner_lo'),
            'payment' => $request->input('payment'),
            'seat_num' => $request->input('seat_num'),
            'children' => $request->input('children') == 'yes' ? true : false,
            'pet' => $request->input('pet') == 'yes' ? true : false,
            'parking' => $request->input('parking') == 'yes' ? true : false,
            'smoking' => $request->input('smoking') == 'yes' ? true : false,
            'privateroom' => $request->input('privateroom') == 'yes' ? true : false
        ]);

        return redirect()->intended('main');


    }
}
