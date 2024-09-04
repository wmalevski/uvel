<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

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
        'user_received_id',
        'status'
    ];

    public function scopeCurrent($query)
    {
        return $query->where('store_from_id', Auth::user()->getStore()->id)->orWhere('store_to_id', Auth::user()->getStore()->id)->get();
    }

    public function store_from(){
        return $this->belongsTo('App\Store')->withTrashed();
    }

    public function store_to(){
        return $this->belongsTo('App\Store')->withTrashed();
    }

    public function material(){
        return $this->belongsTo('App\Material')->withTrashed();
    }

    public function user_sent(){
        return $this->belongsTo('App\User')->withTrashed();
    }

    protected $table = 'materials_travellings';
}