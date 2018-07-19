<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_stones extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product',
        'model',
        'stone',
        'amount',
        'weight',
        'flow'
    ];

    protected $table = 'product_stones';

    protected $dates = ['deleted_at'];
}
