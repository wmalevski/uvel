<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Models extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'jewel',
        'retail_price',
        'wholesale_price',
        'weight',
        'size',
        'workmanship',
        'price'
    ];

    protected $table = 'models';
    protected $dates = ['deleted_at'];    
}
