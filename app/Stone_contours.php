<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stone_contours extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
    ];

    protected $table = 'stone_contours';
    protected $dates = ['deleted_at'];
}
