<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review_Image extends Model
{
    //
    protected $table = 'review_image';

    protected $fillable = [
        'review_id', 'filename'
    ];
}
