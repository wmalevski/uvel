<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialQuantity extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'material_id',
        'quantity',
        'store_id'
    ];

    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function material(){
        return $this->belongsTo('App\Material');
    }

    protected $table = 'materials_quantities';
    protected $dates = ['deleted_at'];
}
