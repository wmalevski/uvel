<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nomenclature extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $table = 'nomenclatures';

    public function stones()
    {
        $this->hasMany('App\Stone');
    }
}
