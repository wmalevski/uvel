<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repairs extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'type',
        'repair_description',
        'date_recieved',
        'date_returned',
        'code',
        'barcode',
        'weight',
        'deposit',
        'price'
    ];

    protected $table = 'repairs';
}
