<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'color',
        'carat',
        'parent_id'
    ];

    protected $table = 'materials';
    protected $dates = ['deleted_at'];

    public function parent(){
        return $this->belongsTo('App\MaterialType')->withTrashed();
    }

    public function quantity(){
        return $this->hasMany('App\MaterialQuantity')->withTrashed();
    }

    public function prices(){
        return $this->hasMany('App\Price')->withTrashed();
    }

    public function pricesBuy(){
        return $this->hasMany('App\Price')->where('type', 'buy');
    }

    public function pricesSell(){
        return $this->hasMany('App\Price')->where('type', 'sell');
    }

    public function products(){
        return $this->hasManyThrough('App\Product', 'App\MaterialQuantity', 'material_id', 'material_id');
    }

    public function productsOnline(){
        return $this->hasManyThrough('App\Product', 'App\MaterialQuantity', 'material_id', 'material_id')->where('status', 'available');
    }
}
