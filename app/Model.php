<?php

namespace App;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

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
        'price',
        'code'
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

    public function wishLists() 
    {
        return $this->hasMany('App\WishList');
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

    public function filterModels(Request $request ,$query){
        $query = Model::where(function($query) use ($request){
            if ($request->priceFrom && $request->priceTo) {
                $query = $query->whereBetween('price', [$request->priceFrom, $request->priceTo]);
            } else if($request->priceFrom){
                $query = $query->where('price', '>=', $request->priceFrom);
            } else if($request->priceTo){
                $query = $query->where('price', '<=', $request->priceTo);
            }

            if ($request->bySize) {
                $query = $query->whereIn('size', $request->bySize);
            }

            if ($request->byStore) {
                $query = $query->whereIn('store_id', $request->byStore);
            }

            if ($request->byJewel) {
                $query = $query->whereIn('jewel_id', $request->byJewel);
            }

            if ($request->byMaterial) {
                $query = $query->whereIn('material_id', $request->byMaterial);
            }
        })->where('website_visible', 'yes')->paginate(env('RESULTS_PER_PAGE'));

        return $query;
    }
    
    public function search(Request $request)
    {
        if($request->search != ''){
            $results = Model::where('name', 'LIKE', "%$request->search%")->get();
        }else{
            $results = Model::take(10)->get();
        }

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
