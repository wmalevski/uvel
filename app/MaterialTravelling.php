<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialTravelling extends Model
{
    protected $fillable = [
        'material_id',
        'quantity',
        'price',
        'store_from_id',
        'store_to_id',
        'dateSent',
        'dateReceived',
        'user_sent_id',
        'status'
    ];

    public function store_from(){
        return $this->belongsTo('App\Store');
    }

    public function store_to(){
        return $this->belongsTo('App\Store');
    }

    public function material(){
        return $this->belongsTo('App\MaterialQuantity');
    }

    public function user_sent(){
        return $this->belongsTo('App\User');
    }

    protected $table = 'materials_travellings';
}