<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_List extends Model
{
    //
    protected $table = 'order_list';

    protected $fillable = [
        'shop_id', 'user_num', 'order_date'
    ];
}
