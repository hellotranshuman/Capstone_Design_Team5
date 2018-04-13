<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function showReservationList() {
        return view('restaurant.reservationList');
    }

    public function showReservationAccept() {
        return view('restaurant.reservationAccept');
    }

    public function showReservationSetting() {
        return view('restaurant.reservationSetting');
    }

    public function showAddReservationForm() {
        return view('user.addReservationForm');
    }
}
