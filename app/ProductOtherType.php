<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOtherType extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $table = 'products_others_types';

    public function productOther() {
        return $this->hasMany('App\ProductOther', 'type_id');
    }
}
