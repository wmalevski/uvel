<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repair_type extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'repair_types';
}
