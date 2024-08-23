<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $table = 'reviews';

    protected $fillable = [
        'content',
        'rating',
        'user_id',
        'product_id',
        'model_id',
        'product_others_id'
    ];

    protected $casts = ['deleted_at'];

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
