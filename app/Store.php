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
    	return $this->hasMany('App\User')->get();
    }

    public function materials()
    {
        return $this->hasMany('App\MaterialQuantity');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function productsOther()
    {
        return $this->hasMany('App\ProductOther');
    }

    public function stones()
    {
    	return $this->hasMany('App\Stone');
    }
}
