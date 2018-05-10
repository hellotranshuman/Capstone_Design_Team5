<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommuBookmark extends Model
{
    protected $table = 'commu_bookmark';

    protected $fillable = [
        'user_num', 'emoticon_num'
    ];
}
