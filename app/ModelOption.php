<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelOption extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'model',
        'material',
        'retail_price',
        'wholesale_price',
        'default'
    ];

    protected $table = 'model_options';
    protected $dates = ['deleted_at'];    

    public function model()
    {
        return $this->belongsTo('App\Model');
    }

    public function material()
    {
        return $this->belongsTo('App\MaterialQuantity')->withTrashed();
    }

    public function retailPrice()
    {
        return $this->belongsTo('App\Price');
    }

    public function wholesalePrice()
    {
        return $this->belongsTo('App\Price');
    }
}
