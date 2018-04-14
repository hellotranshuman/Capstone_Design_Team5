<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu_Image extends Model
{
    protected $table = 'menu_image';

    //
    protected $fillable = [
        'filename', 'shop_id', 'path', 'menu_id'
    ];
}
