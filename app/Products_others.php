<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products_others extends Model
{
    protected $fillable = [
        'model',
        'type',
        'price',
        'quantity',
        'barcode'
    ];

    protected $table = 'products_others';
}
