<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suboption extends Model
{
    protected $table = 'suboption';

    protected $fillable = [
        'opnum', 'name'
    ];
}
