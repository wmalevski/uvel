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
        'model',
        'type',
        'weight',
        'price_list',
        'size',
        'workmanship',
        'price',
        'code'
    ];

    protected $table = 'products';

    public function chainedSelects($model){
        $model = Models::find($model);
    
        if($model){
            $model_material = Jewels::find($model->jewel);
            $jewels = Jewels::where('material', $model_material->material)->get();
            $prices = Prices::where('material', $model_material->material)->get();
            $model_stones = Model_stones::where('model', $model)->get();
    
            $pass_jewels = array();
            
            foreach($jewels as $jewel){
                $pass_jewels[] = (object)[
                    'value' => $jewel->id,
                    'label' => $jewel->name
                ];
            }
    
            $pass_prices = array();
            
            foreach($prices as $price){
                $pass_prices[] = (object)[
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
                'prices' => json_encode($pass_jewels, JSON_UNESCAPED_SLASHES), 
                'jewels' => json_encode($pass_prices, JSON_UNESCAPED_SLASHES),
                'stones' => json_encode($pass_stones, JSON_UNESCAPED_SLASHES),
                'weight' => $model->weight,
                'size'   => $model->size,
                'workmanship' => $model->workmanship,
                'price' => $model->price
            );
        }
    }
}
