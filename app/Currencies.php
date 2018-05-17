<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currencies extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'currency',
    ];

    protected $table = 'currencies';
    protected $dates = ['deleted_at'];
}
