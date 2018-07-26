<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'material_id',
        'price',
        'type'
    ];

    protected $table = 'prices';
    protected $dates = ['deleted_at'];
}
