<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resset extends Model
{
    protected $table = 'resset';

    protected $fillable = [
        'shop_id', 'setting_date', 'start_time', 'end_time', 'remark'
    ];
}
