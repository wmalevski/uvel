<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $table = 'wish_lists';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'product_id',
        'model_id',
        'product_others_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function product() {
        return $this->belongsTo('App\Product');
    }

    public function model() {
        return $this->belongsTo('App\Model');
    }

    public function productOther() {
        return $this->belongsTo('App\ProductOther', 'product_others_id');
    }
}
