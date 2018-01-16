<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $fillable = [
        'name',
        'location',
        'phone',
    ];

    protected $table = 'stores';
}
