<?php

namespace App;

use App\Jewels;
use App\Prices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Response;


class Products extends Model
{
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

    protected $table = 'products';

    public $incrementing = false;

    public function chainedSelects($model){
        $model = Models::find($model);
    
        if($model){
            $model_material = Jewels::find($model->jewel);
            $jewels = Jewels::where('material', $model_material->material)->get();
            $prices = Prices::where('material', $model_material->material)->get();

            $retail_prices = Prices::where([
                'material' => $model_material->material,
                'type' => 'buy'
            ])->get();

            $wholesale_prices = Prices::where([
                'material' => $model_material->material,
                'type' => 'sell'
            ])->get();

            $model_stones = Model_stones::where('model', $model)->get();
    
            $pass_jewels = array();
            
            foreach($jewels as $jewel){
                $pass_jewels[] = (object)[
                    'value' => $jewel->id,
                    'label' => $jewel->name
                ];
            }
    
            $prices_retail = array();
            
            foreach($retail_prices as $price){
                $prices_retail[] = (object)[
                    'value' => $price->id,
                    'label' => $price->slug
                ];
            }

            $prices_wholesale = array();
            
            foreach($wholesale_prices as $price){
                $prices_wholesale[] = (object)[
                    'value' => $price->id,
                    'label' => $price->slug
                ];
            }

            $pass_stones = array();
            
            foreach($model_stones as $stone){
                $pass_stones[] = [
                    'value' => $stone->id,
                    'label' => $stone->name.' ('.\App\Stone_contours::find($stone->contour)->name.', '.\App\Stone_sizes::find($stone->size)->name.' )'
                ];
            }
    
            return array(
                'retail_prices' => json_encode($prices_retail, JSON_UNESCAPED_SLASHES), 
                'wholesale_prices' => json_encode($prices_wholesale, JSON_UNESCAPED_SLASHES), 
                'jewels_types' => json_encode($pass_jewels, JSON_UNESCAPED_SLASHES),
                'stones' => json_encode($pass_stones, JSON_UNESCAPED_SLASHES),
                'weight' => $model->weight,
                'size'   => $model->size,
                'workmanship' => $model->workmanship,
                'price' => $model->price
            );
        }
    }
}
