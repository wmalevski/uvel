<?php

namespace App;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Model extends BaseModel{
	use SoftDeletes;

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
	protected $dates = array('deleted_at');

	public function comments(){
		return $this->hasMany('App\Comment');
	}

	public function stones(){
		return $this->hasMany('App\ModelStone');
	}

	public function options(){
		return $this->hasMany('App\ModelOption');
	}

	public function jewel(){
		return $this->belongsTo('App\Jewel');
	}

	public function photos(){
		return $this->hasMany('App\Gallery');
	}

	public function reviews(){
		return $this->hasMany('App\Review');
	}

	public function wishLists(){
		return $this->hasMany('App\WishList');
	}

	public function materials(){
		$used_materials = array();
		foreach($this->options as $k=>$v){
			if(isset($v->material_id)){
				array_push($used_materials, $v->material_id);
			}
		}

		return Material::whereIn('id', $used_materials)->get();

/*
@foreach($materials as $material)
@if($material->pricesSell->first())
<option value="{{ $material->id }}" data-material="{{ $material->id }}" data-pricebuy="{{ $material->pricesBuy->first()->price }}"
@if($material->id == $option->material_id) selected @endif>
{{ $material->parent->name }} - {{ $material->color }} - {{ $material->code }}
</option>
@endif
@endforeach
 */
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

	public function filterModels(Request $request ,$query){
		$query = Model::where(function($query) use ($request){
			if ($request->priceFrom && $request->priceTo) {
				$query = $query->whereBetween('price', [$request->priceFrom, $request->priceTo]);
			} else if($request->priceFrom){
				$query = $query->where('price', '>=', $request->priceFrom);
			} else if($request->priceTo){
				$query = $query->where('price', '<=', $request->priceTo);
			}

			if ($request->byName) {
				$query->where('name','LIKE','%'.$request->byName.'%');
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

			if( $request->byName == '' && $request->bySize == '' && $request->byStore == '' && $request->byJewel == '' && $request->byMaterial == ''){
				$query = Model::all();
			}
		});

		return $query;
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
