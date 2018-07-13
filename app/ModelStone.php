<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelStone extends Model
{
    protected $fillable = [
        'model',
        'stone',
        'amount',
    ];

    protected $table = 'model_stones';
}