<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'product_id',
        'order_id'
    ];

    protected $table = 'order_items';

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
