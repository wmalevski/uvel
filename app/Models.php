<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    protected $fillable = [
        'name',
        'jewel',
        'retail_price',
        'wholesale_price',
        'weight',
        'size'
    ];

    protected $table = 'models';    
}
