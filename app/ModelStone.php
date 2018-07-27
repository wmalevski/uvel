<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelStone extends Model
{
    protected $fillable = [
        'model',
        'stone',
        'amount',
        'weight',
        'flow'
    ];

    protected $table = 'model_stones';

    public function stone()
    {
        return $this->belongsTo('App\Stone');
    }
}