<?php

namespace App\Http\Controllers;

use Faker\Provider\Image;
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
        /*
        $files = DB::table('upload')
            ->select('shop_id', 'filename', 'path')
            ->get();

        $flag = true;
        $number = 0;
        foreach ($files as $file) {
            if($flag) {
                $array['titleImg'] = $file->path . $file->filename;
                $flag = false;
            }

            else  {
                $name = 'galleryImg'.$number;
                $array[$name] = $file->path . $file->filename;
            }

        }

        return view('test')->with($array);*/

        $ddd = DB::table('restaurants')
            ->select('*')
            ->where('user_num', auth()->user()->id)
            ->orderByRaw('id DESC')
            ->first();

       return view('test', ['ddd' => $ddd]);
    }

}
