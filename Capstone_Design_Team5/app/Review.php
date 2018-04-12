<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';

    protected $fillable = [
        'shop_id', 'content', 'reg_date', 'writer',
        'rating', 'taste', 'service', 'mood', 'price', 'img_num'
    ];
}
