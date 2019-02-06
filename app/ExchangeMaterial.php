<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExchangeMaterial extends Model
{
    protected $fillable = [
        'material_id',
        'weight',
        'retail_price_id',
        'payment_id',
        'order_id',
    ];

    protected $table = 'exchange_materials';

    public function material() {
    	return $this->belongsTo('App\MaterialQuantity');
    }

    public function order() {
        return $this->belongsTo('App\Order');
    }
}
