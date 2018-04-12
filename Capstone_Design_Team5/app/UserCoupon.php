<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    protected $table = 'user_coupon';

    protected $fillable = [
        'user_num', 'coupon_id', 'use_check', 'start_date',
        'expiry_date'
    ];
}
