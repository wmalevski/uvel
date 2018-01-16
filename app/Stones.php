<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stones extends Model
{
    protected $fillable = [
        'name',
        'type',
        'weight',
        'carat',
        'size',
        'style',
        'contour',
        'amount',
        'price'
    ];

    protected $table = 'stones';
}
