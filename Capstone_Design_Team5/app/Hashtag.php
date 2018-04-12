<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected $table = 'hashtag';

    //
    protected $fillable = [
        'tag', 'review_id'
    ];
}
