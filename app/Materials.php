<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    protected $fillable = [
        'name',
        'code',
        'color'
    ];

    protected $table = 'materials';
}
