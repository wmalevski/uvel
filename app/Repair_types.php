<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repair_types extends Model
{
    protected $fillable = [
        'name',
        'price',
    ];

    protected $table = 'repair_types';
}
