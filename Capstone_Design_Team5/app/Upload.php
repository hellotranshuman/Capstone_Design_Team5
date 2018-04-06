<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'upload';

    //
    protected $fillable = [
        'filename', 'shop_id'
    ];
}
