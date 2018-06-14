<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    //
    protected $table = 'layout';

    protected $fillable = [
        'shop_id', 'layout_data', 'layout_name', 'thumbnail'
    ];
}
