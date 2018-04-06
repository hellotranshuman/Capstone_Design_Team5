<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function showMainPage() {
        if( !auth()->check())
            return redirect('login');

        return view('main');
    }

    public function test() {
        $ddd = DB::table('upload')
            ->select('id', 'filename', 'shop_id')
            ->get()->toArray();

        $ddd = json_encode($ddd);

        echo var_dump($ddd);
    }

}
