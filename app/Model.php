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

    public function reviews() 
    {
        return $this->hasMany('App\Review');
    }

    public function getModelAvgRating($model) {
        $modelTotalRating = 0;
        if(count($model->reviews)){
            foreach($model->reviews as $review) {
                $modelTotalRating = $modelTotalRating + $review->rating;
            }
            return $modelAvgRating = $modelTotalRating/count($model->reviews);
        }
    }

    public function listModelAvgRatingStars($model) {
        for($i = 1; $i <= 5; $i++){
            if($this->getModelAvgRating($model) >= $i){
                echo '<i class="spr-icon spr-icon-star" style=""></i>';
            }elseif($this->getModelAvgRating($model) < $i){
                echo'<i class="spr-icon spr-icon-star-empty" style=""></i>';
            }   																		
        }
    }
}
