<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jewel extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name'
    ];

    protected $table = 'jewels';
    protected $dates = ['deleted_at'];
}
