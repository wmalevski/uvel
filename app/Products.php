<?php

namespace App;

use App\Jewel;
use App\Price;
use App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Response;
use App\Stones;
use App\StoneStyles;
use App\StoneContour;
use App\StoneSizes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
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
        if($model){
            $model_material = Jewel::find($model->material);
            $jewels = Jewel::where('id', $model->jewel)->get()
             ;
            $prices = Price::where('material', $model->jewel)->get();

            $retail_prices = Price::where([
                'type' => 'sell',
                'material' => Jewel::withTrashed()->find($model->jewel)->material
            ])->get();

            $wholesale_prices = Price::where([
                'type' => 'sell',
                'material' => Jewel::withTrashed()->find($model->jewel)->material
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
                if($price->material == Jewel::withTrashed()->find($model->jewel)->material){
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
                if($price->material == Jewel::withTrashed()->find($model->jewel)->material){
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
                    'value' => Stones::withTrashed()->find($stone->stone)->id,
                    'label' => Stones::withTrashed()->find($stone->stone)->name.' ('.StoneContour::withTrashed()->find(Stones::withTrashed()->find($stone->stone)->contour)->name. ', ' .StoneSizes::withTrashed()->find(Stones::withTrashed()->find($stone->stone)->size)->name. ' )'
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
                'price' => $model->price
            );
        }
    }
}
