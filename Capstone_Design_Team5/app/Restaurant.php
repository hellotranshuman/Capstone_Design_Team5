<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table = 'restaurants';

    protected $fillable = [
        'name', 'user_num', 'type', 'explanation', 'phone', 'dodobuken',
        'cities', 'address', 'payment', 'seat_num', 'children', 'pet',
        'parking', 'smoking', 'privateroom'
    ];
}
