<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prices extends Model
{
    protected $fillable = [
        'slug',
        'material',
        'price',
        'type'
    ];

    protected $table = 'prices';
}
