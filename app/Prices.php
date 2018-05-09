<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prices extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'material',
        'price',
        'type'
    ];

    protected $table = 'prices';
    protected $dates = ['deleted_at'];
}
