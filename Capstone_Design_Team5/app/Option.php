<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //
    protected $table = 'option';

    protected $fillable = [
       'menu_id', 'name'
    ];
}
