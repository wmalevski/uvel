<?php

namespace App;

use App\Jewel;
use App\Price;
use App\Model;
use App\Stone;
use App\StoneStyle;
use App\StoneContour;
use App\StoneSize;
use App\Gallery;
use App\ModelOption;
use Illuminate\Http\File;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\MaterialQuantity;
use Response;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'model',
        'type',
        'weight',
        'retail_price',
        'size',
        'workmanship',
        'price',
        'code'
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'products';

    public function model()
    {
        return $this->belongsTo('App\Model');
    }

    public function jewel()
    {
        return $this->belongsTo('App\Jewel');
    }

    public function images()
    {
        return $this->hasMany('App\Gallery');
    }

    public function stones()
    {
        return $this->hasMany('App\ProductStone');
    }

    public function retailPrice()
    {
        return $this->belongsTo('App\Price')->withTrashed();
    }

    public function reviews() 
    {
        return $this->hasMany('App\Review');
    }

    public function chainedSelects(Model $model){
        $materials = MaterialQuantity::curStore();
        $default = $model->options->where('default', 'yes')->first();
        
        if($model){
            $jewels = Jewel::all();
            $model_stones = $model->stones;
            $model_photos = $model->photos;
            
            if($default){
                $retail_prices = $default->material->material->pricesBuy; 
        
                $pass_jewels = array();
                
                foreach($jewels as $jewel){
                    if($jewel->id == $model->jewel_id){
                        $selected = true;
                    }else{
                        $selected = false;
                    }
    
                    $pass_jewels[] = (object)[
                        'value' => $jewel->id,
                        'label' => $jewel->name,
                        'selected' => $selected
                    ];
                }
        
                $prices_retail = array();
                
                foreach($retail_prices as $price){
                    if($price->id == $default->retail_price_id){
                        $selected = true;
                    }else{
                        $selected = false;
                    }
    
                    $prices_retail[] = (object)[
                        'value' => $price->id,
                        'label' => $price->slug.' - '.$price->price.'лв',
                        'selected' => $selected,
                        'price' => $price->price
                    ];
                }
            }

            $pass_stones = array();
            
            foreach($model_stones as $stone){
                $pass_stones[] = [
                    'value' => $stone->id,
                    'label' => $stone.' ('.$stone->contour. ', ' .$stone->size. ' )',
                    'amount' => $stone->amount,
                    'weight' => $stone->weight,
                    'flow' => $stone->flow,
                    'type' => $stone->type,
                    'price' => $stone->price
                ];
            }


            $pass_materials = array();
            
            foreach($materials as $material){
                if($material->material->pricesBuy){
                    if($default){
                        if($material->material->id == $default->material->id){
                            $selected = true;
                        }else{
                            $selected = false;
                        }
                    }else{
                        $selected = false;
                    }
                    
    
                    //BE: Use materials quantity, not MATERIAL TYPE! Do it after merging.
                    $pass_materials[] = (object)[
                        'value' => $material->id,
                        'label' => $material->material->name.' - '.$material->material->color.'- '.$material->material->code,
                        'selected' => $selected,
                        'dataMaterial' => $material->id,
                        'priceBuy' => $material->material->pricesBuy->first()['price'],
                    ];
                }
            }

            $pass_photos = array();

            $pass_stones = array();
            
            foreach($model_stones as $stone){
                $pass_stones[] = [
                    'value' => $stone->stone->id,
                    'label' => $stone->stone->name.' ('.$stone->stone->contour->name. ', ' .$stone->stone->size->name. ' )',
                    'amount' => $stone->amount,
                    'weight' => $stone->weight,
                    'flow' => $stone->flow,
                    'type'  => $stone->stone->type,
                    'price' => $stone->stone->price
                ];
            }

            $pass_photos = array();

            foreach($model_photos as $photo){
                $url =  Storage::get('public/models/'.$photo->photo);
                $ext_url = Storage::url('public/models/'.$photo->photo);
                
                $info = pathinfo($ext_url);
                
                $image_name =  basename($ext_url,'.'.$info['extension']);
                
                $base64 = base64_encode($url);

                $pass_photos[] = [
                    'id' => $photo->id,
                    'base64' => 'data:image/'.$info['extension'].';base64,'.$base64
                ];
            }
    
            return array(
                'retail_prices' => $prices_retail, 
                'jewels_types' => $pass_jewels,
                'stones' => $pass_stones,
                'weight' => $model->weight,
                'size'   => $model->size,
                'workmanship' => $model->workmanship,
                'price' => $model->price,
                'materials' => $pass_materials,
                'photos' => $pass_photos,
                'pricebuy' => $default->material->material->pricesBuy->first()->price,
            );
            }
        }
        public function scopeOfSimilarPrice($query, $price)
        {
            return $query->orderBy(DB::raw('ABS(`price` - '.$price.')'));
        }

        public function getSimilarProductAvgRating($product) {
            $productTotalRating = 0;
            if(count($product->reviews)){
                foreach($product->reviews as $review) {
                    $productTotalRating = $productTotalRating + $review->rating;
                }
                return $productAvgRating = $productTotalRating/count($product->reviews);
            }
        }

        public function listSimilarProductAvgRatingStars($product) {
            for($i = 1; $i <= 5; $i++){
                if($this->getSimilarProductAvgRating($product) >= $i){
                    echo '<i class="spr-icon spr-icon-star" style=""></i>';
                }elseif($product->getSimilarProductAvgRating($product) < $i){
                    echo'<i class="spr-icon spr-icon-star-empty" style=""></i>';
                }   																		
            }
        }

        public function filterProducts(Request $request ,$query){
            //dd($request, $query);
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

            return $query;
        }
    }