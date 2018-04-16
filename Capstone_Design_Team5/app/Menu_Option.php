<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu_Option extends Model
{
    protected $table = 'menu_option';

    protected $fillable = [
       'menu_id', 'name'
    ];
}
