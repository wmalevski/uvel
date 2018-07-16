<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelOption extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'model',
        'material',
        'retail_price',
        'wholesale_price',
        'default'
    ];

    protected $table = 'model_options';
    protected $dates = ['deleted_at'];    
}
