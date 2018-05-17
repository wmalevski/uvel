<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repairs extends Model
{
    use SoftDeletes;

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
        'weight_after',
        'deposit',
        'price',
        'price_after',
        'material'
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'repairs';
}
