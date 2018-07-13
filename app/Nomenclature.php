<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nomenclature extends Model
{
    protected $fillable = [
        'name',
        'code',
        'color'
    ];

    protected $table = 'nomenclatures';
}
