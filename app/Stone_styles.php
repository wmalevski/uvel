<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stone_styles extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $table = 'stone_styles';
    protected $dates = ['deleted_at'];
}
