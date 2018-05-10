<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Option extends Model
{
    protected $table = 'order_option';

    protected $fillable = [
        'op_num', 'subop_num', 'order_menu_id'
    ];
}
