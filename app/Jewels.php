<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jewels extends Model
{
    protected $fillable = [
        'name',
        'material',
    ];

    protected $table = 'jewels';
}
