<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelOptions extends Model
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
