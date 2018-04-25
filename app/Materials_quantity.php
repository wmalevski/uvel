<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materials_quantity extends Model
{
    protected $fillable = [
        'material',
        'quantity',
        'store'
    ];

    protected $table = 'materials_quantities';
}
