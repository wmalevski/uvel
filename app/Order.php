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
        'status'
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
}
