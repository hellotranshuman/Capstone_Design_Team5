<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop_like extends Model
{
    protected $table = 'shop_like';

    protected $fillable = [
        'user_num', 'shop_id'
    ];
}
