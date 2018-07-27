<?php

namespace App;

use App\Jewel;
use App\Price;
use App\Model;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Response;
use App\Stone;
use App\StoneStyle;
use App\StoneContour;
use App\StoneSize;
use App\Gallery;
use App\ModelOption;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'model',
        'type',
        'weight',
        'retail_price',
        'wholesale_price',
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
        return $this->belongsTo('App\Model');
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
        return $this->belongsTo('App\Price');
    }

    public function chainedSelects(Model $model){
        $materials = Material::all();
        $default = $model->options->where('default', 'yes')->first();

        if($model){
            $jewels = Jewel::all();

            $retail_prices = $default->material->pricesBuy;

            $wholesale_prices = $default->material->pricesSell;

            $model_stones = $model->stones;
            $model_photos = $model->photos;
    
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

            $prices_wholesale = array();
            
            foreach($wholesale_prices as $price){
                if($price->id == $default->wholesale_price_id){
                    $selected = true;
                }else{
                    $selected = false;
                }

                $prices_wholesale[] = (object)[
                    'value' => $price->id,
                    'label' => $price->slug.' - '.$price->price.'лв',
                    'selected' => $selected,
                    'price' => $price->price
                ];
            }

            $pass_stones = array();
            
            foreach($model_stones as $stone){
                $pass_stones[] = [
                    'value' => $stone->stone->id,
                    'label' => $stone->stone->name.' ('.$stone->stone->contour->name. ', ' .$stone->stone->size->name. ' )',
                    'amount' => $stone->amount,
                    'weight' => $stone->weight,
                    'flow' => $stone->flow
                ];
            }

            $pass_materials = array();
            
            foreach($materials as $material){
                if($material->id == $default->material_id){
                    $selected = true;
                }else{
                    $selected = false;
                }

                $pass_materials[] = (object)[
                    'value' => $material->id,
                    'label' => $material->name.' - '.$material->code.' - '.$material->carat,
                    'selected' => $selected,
                ];
            }

            $pass_photos = array();

            foreach($model_photos as $photo){
               
                $pass_photos[] = (object)[
                    'id' => $photo->id,
                    'photo' => $photo->photo
                ];
            }
    
            return array(
                'retail_prices' => $prices_retail, 
                'wholesale_prices' => $prices_wholesale, 
                'jewels_types' => $pass_jewels,
                'stones' => $pass_stones,
                'weight' => $model->weight,
                'size'   => $model->size,
                'workmanship' => $model->workmanship,
                'price' => $model->price,
                'materials' => $pass_materials,
                'photos' => $pass_photos,
                'pricebuy' => $default->material->pricesBuy->first()->price,
            );
        }
    }
}

