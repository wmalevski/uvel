<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stone extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'type',
        'weight',
        'carat',
        'size',
        'style',
        'contour',
        'amount',
        'price'
    ];

    protected $table = 'stones';
    protected $dates = ['deleted_at'];
}
