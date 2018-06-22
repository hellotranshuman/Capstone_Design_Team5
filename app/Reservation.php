<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //
    protected $table = 'reservation';

    protected $fillable = [
        'shop_id', 'user_num', 'reservation_date', 'person',
        'child', 'message', 'menu_select', 'accept', 'order_num',
        'refused_message', 'reservation_name',
    ];
}
