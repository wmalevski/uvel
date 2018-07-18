<?php

namespace App;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'jewel',
        'retail_price',
        'wholesale_price',
        'weight',
        'size',
        'workmanship',
        'price'
    ];

    protected $table = 'models';
    protected $dates = ['deleted_at'];    

    public function stones()
    {
        return $this->hasMany('App\ModelStone');
    }

    public function options()
    {
        return $this->hasMany('App\ModelOption');
    }
}
