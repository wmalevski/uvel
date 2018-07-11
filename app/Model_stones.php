<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Model_stones extends Model
{
    protected $fillable = [
        'model',
        'stone',
        'amount',
        'weight',
        'flow'
    ];

    protected $table = 'model_stones';
}