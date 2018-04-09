<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class axiosTestController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            return Post::all();
        }

        $posts = Post::all();
      
        return view('posts.index');
    }

    public function create()
    {
        return view('posts.create');
    }
    
    public function createReview(Request $request) {
        return var_dump($request->all());
    }
}
