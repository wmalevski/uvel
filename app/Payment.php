<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DiscountCode;
use App\Product;
use App\ProductOther;

class Payment extends Model
{
    protected $fillable = [
        'currency',
        'method',
        'reciept',
        'ticket',
        'price',
        'given'
    ];

    protected $table = 'payments';

    public function discounts(){
        return $this->hasMany('App\PaymentDiscount');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function sellings(){
        return $this->hasMany('App\Selling');
    }

    public function productSellings(){
        return $this->hasManyThrough('App\Selling', 'App\Product', 'id', 'product_id');
    }

}