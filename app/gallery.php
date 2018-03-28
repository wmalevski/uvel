<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'photo',
        'table',
        'row_id'
    ];

    protected $table = 'galleries';
}
