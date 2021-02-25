<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExchangeMaterial extends Model{
    protected $fillable = array(
        'material_id',
        'weight',
        'retail_price_id',
        'material_price_id',
        'payment_id',
        'order_id'
    );

    protected $table = 'exchange_materials';

    public function material(){
    	return $this->belongsTo('App\Material');
    }

    public function order(){
        return $this->belongsTo('App\Order');
    }

    // public function price(){
    //     return $this->belongsTo('App\Price', '', 'id');
    // }
}
