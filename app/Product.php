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

    public $incrementing = false;

    public function chainedSelects($model){
        $model = Models::find($model);
        $materials = Materials::all();
        $default = ModelOptions::where([
            ['model', '=', $model->id],
            ['default', '=', 'yes']
        ])->first();

        if($model){
            $model_material = Jewel::find($model->material);
            $jewels = Jewel::where('id', $model->jewel)->get()
             ;
            $prices = Price::where('material', $model->jewel)->get();

            $retail_prices = Price::where([
                'type' => 'sell',
                'material' => $default->material
            ])->get();

            $wholesale_prices = Price::where([
                'type' => 'sell',
                'material' => $default->material
            ])->get();

            $model_stones = ModelStone::where('model', $model->id)->get();
    
            $pass_jewels = array();
            
            foreach($jewels as $jewel){
                if($jewel->id == $model->jewel){
                    $selected = true;
                }else{
                    $selected = false;
                }

                $pass_jewels[] = (object)[
                    'value' => $jewel->id,
                    'label' => $jewel->name,
                    'material' => $jewel->material,
                    'pricebuy' => Price::withTrashed()->where('material', $jewel->material)->where('type', 'buy')->first()->price,
                    'selected' => $selected
                ];
            }
    
            $prices_retail = array();
            
            foreach($retail_prices as $price){
                if($price->id == $default->retail_price){
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
                if($price->id == $default->wholesale_price){
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
                    'value' => Stone::withTrashed()->find($stone->stone)->id,
                    'label' => Stone::withTrashed()->find($stone->stone)->name.' ('.StoneContour::withTrashed()->find(Stone::withTrashed()->find($stone->stone)->contour)->name. ', ' .StoneSize::withTrashed()->find(Stone::withTrashed()->find($stone->stone)->size)->name. ' )'
                ];
            }

            $pass_materials = array();
            
            foreach($materials as $material){
                if($material->id == $default->material){
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
    
            return array(
                'retail_prices' => $prices_retail, 
                'wholesale_prices' => $prices_wholesale, 
                'jewels_types' => $pass_jewels,
                'stones' => $pass_stones,
                'weight' => $model->weight,
                'size'   => $model->size,
                'workmanship' => $model->workmanship,
                'price' => $model->price,
                'materials' => $pass_materials
            );
        }
    }
}
