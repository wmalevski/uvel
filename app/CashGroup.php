<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashGroup extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'label',
        'cash_group'
    ];
}
