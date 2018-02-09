<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materials_quantity extends Model
{
    protected $fillable = [
        'material',
        'quantity',
        'store',
        'carat'
    ];

    protected $table = 'materials_quantities';
}
