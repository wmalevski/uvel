<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount_codes extends Model
{
    protected $fillable = [
        'discount',
        'expires',
        'user',
        'code',
        'barcode',
        'lifetime',
        'active'
    ];

    protected $table = 'discount_codes';
}
