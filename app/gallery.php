<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'photo',
        'table',
        'product_id',
        'model_id',
        'stone_id'
    ];

    protected $table = 'galleries';
}
