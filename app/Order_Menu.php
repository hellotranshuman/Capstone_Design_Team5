<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Menu extends Model
{
    protected $table = 'order_menu';

    protected $fillable = [
        'menu_id', 'order_num'
    ];
}
