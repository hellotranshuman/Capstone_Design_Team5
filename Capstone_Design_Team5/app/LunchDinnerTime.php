<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LunchDinnerTime extends Model
{
    protected $table = 'lunchDinnerTime';

    //
    protected $fillable = [
        'shop_id', 'lunch_open', 'lunch_close', 'lunch_lo',
        'dinner_open', 'dinner_close', 'dinner_lo'
    ];
}
