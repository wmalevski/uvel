<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nomenclatures extends Model
{
    protected $fillable = [
        'name',
        'code',
        'color'
    ];

    protected $table = 'nomenclatures';
}
