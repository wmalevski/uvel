<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jewel extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name'
    ];

    protected $table = 'jewels';
    protected $dates = ['deleted_at'];

    public function products() {
    	return $this->hasMany('App\Product');
    }

    public function productsOnline() {
    	return $this->hasMany('App\Product')->where('status', 'available');
    }

    public function models() {
    	return $this->hasMany('App\Model');
    }
}
