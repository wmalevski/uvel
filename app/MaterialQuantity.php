<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class MaterialQuantity extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'material_id',
        'quantity',
        'store_id'
    ];

    public function scopeCurrentStore()
    {
        return $this->where('store_id', Auth::user()->getStore()->id)->get();
    }
    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function material(){
        return $this->belongsTo('App\Material');
    }

    public function travelling(){
        return $this->belongsTo('App\MaterialTravelling');
    }

    protected $table = 'materials_quantities';
    protected $dates = ['deleted_at'];
}
