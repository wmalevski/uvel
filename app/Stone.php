<?php

namespace App;

use App\StoneSize;
use App\StoneStyle;
use App\StoneContour;
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
        return $this->belongsTo('App\StoneSize');        
    }

    public function style()
    {
        return $this->belongsTo('App\StoneStyle');
    }

    public function contour()
    {
        return $this->belongsTo('App\StoneContour');
    }

    public function modelStones()
    {
        return $this->hasMany('App\ModelStone');
    }

    public function productStones()
    {
        return $this->hasMany('App\ProductStone');
    }
}