<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review_like extends Model
{
    //
    protected $table = 'review_like';

    protected $fillable = [
        'user_num', 'review_id'
    ];
}
