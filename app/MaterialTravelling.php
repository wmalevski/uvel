<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialTravelling extends Model
{
    protected $fillable = [
        'type',
        'quantity',
        'price',
        'storeFrom',
        'storeTo',
        'dateSent',
        'dateReceived',
        'userSent',
        'status'
    ];

    protected $table = 'materials_travellings';
}