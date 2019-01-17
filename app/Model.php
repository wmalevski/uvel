<?php

namespace App;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'jewel_id',
        'retail_price_id',
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

    public function jewel()
    {
        return $this->belongsTo('App\Jewel');
    }

    public function photos()
    {
        return $this->hasMany('App\Gallery');
    }

    public function search($term)
    {
        $results = Model::where('name', 'LIKE', "%$term%")->get();

        $pass_models = array();

        foreach($results as $model){
            $pass_models[] = [
                'value' => $model->id,
                'label' => $model->name
            ];
        }

        return $pass_models;
    }
}
