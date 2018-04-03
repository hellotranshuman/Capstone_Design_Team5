<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table = 'restaurants';

    protected $fillable = [
        'name', 'user_num', 'type', 'explanation', 'phone', 'dodobuken',
        'cities', 'address', 'lunch_open', 'lunch_close', 'lunch_lo',
        'dinner_open', 'dinner_close', 'dinner_lo', 'payment', 'seat_num',
        'children', 'pet', 'parking', 'smoking', 'privateroom'
    ];
}
