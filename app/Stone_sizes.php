<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stone_sizes extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $table = 'stone_sizes';
}
