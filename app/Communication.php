<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    protected $table = 'communication';

    protected $fillable = [
        'category', 'name', 'path', 'img_name'
    ];
}
