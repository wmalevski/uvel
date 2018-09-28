<?php

namespace App;

use App\StoneSize;
use App\StoneStyle;
use App\StoneContour;
use Auth;
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
        'price',
        'store_id'
    ];

    protected $table = 'stones';
    protected $dates = ['deleted_at'];

    public function scopeActive()
    {
        return $this->where('amount', '>', 0)->get();
    }

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

    public function store()
    {
        return $this->belongsTo('App\Store');
    }

    public function scopeCurrentStore()
    {
        return $this->where('store_id', Auth::user()->getStore()->id)->get();
    }

    public function photos()
    {
        return $this->hasMany('App\Gallery');
    }
}