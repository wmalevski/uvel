<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products_others extends Model
{
    protected $fillable = [
        'name',
        'type',
        'price',
        'quantity',
        'barcode',
        'store'
    ];

    protected $table = 'products_others';
}
