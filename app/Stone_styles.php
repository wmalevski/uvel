<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stone_styles extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $table = 'stone_styles';
}
