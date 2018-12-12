<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id',
        'model_id',
        'jewel_id',
        'material_id',
        'price_id',
        'weight',
        'size',
        'workmanship',
        'price',
        'quantity',
        'comment',
        'cash_group',
        'earnest',
        'status'
    ];

    protected $table = 'orders';
}
