<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materials_quantity extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'material',
        'quantity',
        'store'
    ];

    protected $table = 'materials_quantities';
    protected $dates = ['deleted_at'];
}
