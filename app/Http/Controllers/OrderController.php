<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function makeOrder(Request $request) {
        echo var_dump($request->all());
    }

    public function cancelOrder(Request $request) {

    }
}
