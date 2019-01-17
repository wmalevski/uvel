<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStone extends Model
{
    protected $fillable = [
        'order_id',
        'stone_id',
        'amount',
        'weight',
        'flow'
    ];

    protected $table = 'order_stones';

    public function stone()
    {
        return $this->belongsTo('App\Stone');
    }
}
