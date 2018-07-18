<?php

namespace App;

use App\StoneSize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stone extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'type',
        'weight',
        'carat',
        'size_id',
        'style_id',
        'contour_id',
        'amount',
        'price'
    ];

    protected $table = 'stones';
    protected $dates = ['deleted_at'];

    public function size()
    {
        return $this->hasOne('App\StoneSize');        
    }
}