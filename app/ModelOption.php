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
        'retail_price_id',

        'default'
    ];

    protected $table = 'model_options';
    protected $casts = ['deleted_at'];

    public function model()
    {
        return $this->belongsTo('App\Model');
    }

    public function material()
    {
        return $this->belongsTo('App\Material')->withTrashed();
    }

    public function retailPrice()
    {
        return $this->belongsTo('App\Price');
    }
}
