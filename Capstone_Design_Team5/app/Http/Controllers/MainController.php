<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function showMainPage()
    {
        if( !auth()->check())
            return redirect('login');

        return view('main');
    }
}
