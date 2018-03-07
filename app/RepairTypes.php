<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepairTypes extends Model
{
    protected $fillable = [
        'name',
        'price'
    ];

    protected $table = 'repair_types';
}
