<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jewels extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'material',
    ];

    protected $table = 'jewels';
    protected $dates = ['deleted_at'];
}
