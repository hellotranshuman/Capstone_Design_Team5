<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function showStatisticsForm() {
        return view('restaurants.ownerStatistics');
    }
}
