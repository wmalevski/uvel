<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStone extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product',
        'model',
        'stone',
        'nomenclature_id',
        'amount',
        'weight',
        'flow'
    ];

    protected $table = 'product_stones';

    protected $dates = ['deleted_at'];

    public function stone()
    {
        return $this->belongsTo('App\Stone');
    }
}
