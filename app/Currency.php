<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'currency',
        'currency_id'
    ];

    protected $table = 'currencies';
    protected $dates = ['deleted_at'];
}
