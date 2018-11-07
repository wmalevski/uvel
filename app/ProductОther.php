<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOther extends Model
{
    protected $fillable = [
        'name',
        'type_id',
        'price',
        'quantity',
        'barcode',
        'store_id'
    ];

    protected $table = 'products_others';

    public function type()
    {
        return $this->belongsTo('App\ProductOtherType')->withTrashed();
    }

    public function store()
    {
        return $this->belongsTo('App\Store')->withTrashed();
    }

    public function reviews() 
    {
        return $this->hasMany('App\Review');
    }
}
