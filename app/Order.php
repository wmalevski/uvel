<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id',
        'model_id',
        'jewel_id',
        'material_id',
        'price_id',
        'weight',
        'size',
        'workmanship',
        'price',
        'quantity',
        'comment',
        'cash_group',
        'earnest',
        'status',
        'content'
    ];

    protected $table = 'orders';

    public function model()
    {
        return $this->belongsTo('App\Model');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function jewel()
    {
        return $this->belongsTo('App\Jewel');
    }

    public function retailPrice()
    {
        return $this->belongsTo('App\Price')->withTrashed();
    }

    public function stones()
    {
        return $this->hasMany('App\OrderStone');
    }

    public function materials()
    {
        return $this->hasMany('App\ExchangeMaterial', 'order_id');
    }

    public function items()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function material()
    {
        return $this->belongsTo('App\Material');
    }
}
