<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    protected $fillable = [
        'name',
        'currency',
    ];

    protected $table = 'currencies';
}
