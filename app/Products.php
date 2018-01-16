<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'model',
        'type',
        'weight',
        'price_list',
        'size',
        'workmanship',
        'price',
        'code'
    ];

    protected $table = 'products';
}
