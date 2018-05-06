<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'order';

    protected $fillable = [
        'shop_id', 'user_num', 'order_date'
    ];
}
