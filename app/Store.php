<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'location',
        'phone',
    ];

    protected $table = 'stores';
    protected $dates = ['deleted_at'];

    public function users()
    {
    	return $this->hasMany('App\User');
    }

    public function materials()
    {
        return $this->hasMany('App\MaterialQuantity');
    }

    public function productsOther()
    {
        return $this->hasMany('App\ProductOther');
    }
}
