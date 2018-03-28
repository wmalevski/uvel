<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'action',
        'user',
        'table',
        'result_id'
    ];

    protected $table = 'histories';
}
