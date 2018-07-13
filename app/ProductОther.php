<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOther extends Model
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
