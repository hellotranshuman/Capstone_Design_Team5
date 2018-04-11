<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupon';

    protected $fillable = [
        'category', 'shop_id', 'name', 'price_condition',
         'discount', 'start_date', 'expiry_date', 'add_product'
    ];
}
