<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'currency',
        'method',
        'reciept',
        'ticket',
        'price',
        'given'
    ];

    protected $table = 'payments';
}