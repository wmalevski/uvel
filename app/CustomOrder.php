<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomOrder extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'city',
        'phone',
        'email',
        'content',
    ];

    protected $table = 'custom_orders';
    protected $dates = ['deleted_at'];
}
