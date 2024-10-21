<?php

namespace App;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Mavinoo\Batch\Traits\HasBatch;

class Model extends BaseModel{
    use SoftDeletes, HasBatch;

    protected $fillable = array(
        'name',
        'jewel_id',
        'retail_price_id',
        'weight',
        'size',
        'workmanship',
        'price'
    );

    protected $table = 'models';
    protected $casts = array('deleted_at');

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function stones(){
        return $this->hasMany(ModelStone::class);
    }

    public function options(){
        return $this->hasMany(ModelOption::class);
    }

    public function jewel(){
        return $this->belongsTo(Jewel::class);
    }

    public function photos(){
        return $this->hasMany(Gallery::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function wishLists(){
        return $this->hasMany(WishList::class);
    }

    public function materials(){
        $used_materials = array();
        foreach($this->options as $k=>$v){
            if(isset($v->material_id)){
                array_push($used_materials, $v->material_id);
            }
        }

        return Material::whereIn('id', $used_materials)->get();
    }

    public function getModelAvgRating($model) {
        $modelTotalRating = 0;
        if(count($model->reviews)){
            foreach($model->reviews as $review) {
                $modelTotalRating = $modelTotalRating + $review->rating;
            }
            return $modelAvgRating = round($modelTotalRating/count($model->reviews));
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

    public function filterModels(Request $request, $returnModel = false){
        $models = self::where(function ($query) use ($request) {
            if ($request->priceFrom && $request->priceTo) {
                $query = $query->whereBetween('price', [$request->priceFrom, $request->priceTo]);
            } else if($request->priceFrom){
                $query = $query->where('price', '>=', $request->priceFrom);
            } else if($request->priceTo){
                $query = $query->where('price', '<=', $request->priceTo);
            }

            $term = $request->search ?? $request->byName;
            if ($term) {
                $query->where('name','LIKE','%'.$term.'%');
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
        });

        if ( $returnModel ) {
            return $models;
        }

        $paginatedResult = $models->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);
        $results = $paginatedResult->map(function ($model) {
            return [
                'id' => $model->id,
                'text' => $model->name,
            ];
        });


        return response()->json([
            'results' => $results,
            'pagination' => ['more' => $paginatedResult->hasMorePages()],
        ]);
    }

    public function filterMaterials(Request $request ,$query){
        $query = MaterialQuantity::where(function($query) use ($request){
            if ($request->byName) {
                $query->with('Material')->whereHas('Material', function($q) use ($request){
                    $q->where('name', 'LIKE', "%$request->byName%")->orWhere('color', 'LIKE', "%$request->byName%")->orWhere('code', 'LIKE', "%$request->byName%");
                });
            }

            if ($request->byName == '') {
                $query = MaterialQuantity::all();
            }
        });

        return $query;
    }
}
