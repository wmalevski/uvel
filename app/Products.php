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

    public function chainedSelects($model, $type){
        if($ype == 'model'){
            $model = Models::find($model);
            $model_material = Jewels::find($model);
            $jewels = Jewels::all();
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
                if($jewel->id == $model){
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
                'retail_prices' => $prices_retail, 
                'wholesale_prices' => $prices_wholesale, 
                'jewels_types' => $pass_jewels,
                //'stones' => $pass_stones,
                'weight' => $model->weight,
                'size'   => $model->size,
                'workmanship' => $model->workmanship,
                'price' => $model->price
            );
        } else if($type == 'jewel'){

        }
    }
}