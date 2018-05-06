<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = [
        'shop_id', 'name', 'explanation', 'price',
        'category', 'remark'
    ];
}
