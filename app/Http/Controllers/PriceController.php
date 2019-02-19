<?php

namespace App\Http\Controllers;

use App\Price;
use App\Material;
use App\Model;
use App\ModelOption;
use App\Product;
use App\Jewel;
use App\MaterialQuantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Response;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $materials = Material::take(env('SELECT_PRELOADED'))->get();
        
        if ($request->isMethod('post')){
            return redirect()->route('view_price', ['material' => $request->material_id]);
        }

        return \View::make('admin/prices/index', array('materials' => $materials));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'slug' => 'required',
            'price' => 'required|regex:/^\d*(\.\d{1,3})?$/',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $price = Price::create($request->all());

        $indicatePrice = false;
        $getIndicatePrice = Price::where([
            ['type', '=', $price->type],
            ['material_id', '=', $price->material_id]
        ])->orderBy('id', 'ASC')->first();

        if(count($getIndicatePrice) && $getIndicatePrice->id == $price->id){
            $indicatePrice = true;
        }

        return Response::json(array('success' => View::make('admin/prices/table',array('price'=>$price, 'type' => $request->type, 'indicatePrice' => $indicatePrice))->render(), 'type'=>$request->type));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Price  $prices
     * @return \Illuminate\Http\Response
     */
    public function show(Price $price, $material)
    {
        if($material){
            $prices = $price->materialPrices($material);
            $material = Material::find($material);
          
            return view('admin/prices/show', compact('prices', 'material'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prices  $prices
     * @return \Illuminate\Http\Response
     */
    public function edit(Price $price)
    {
        return \View::make('admin/prices/edit', array('price' => $price));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Price  $prices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Price $price)
    {       
        $validator = Validator::make( $request->all(), [
            'slug' => 'required',
            'price' => 'required|regex:/^\d*(\.\d{1,3})?$/',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $price->slug = $request->slug;
        $price->price = $request->price;
        $price->type = $request->type;
        
        $price->save();

        $indicatePrice = false;
        $getIndicatePrice = Price::where([
            ['type', '=', $price->type],
            ['material_id', '=', $price->material_id]
        ])->orderBy('id', 'ASC')->first();
        
        if(count($getIndicatePrice) && $getIndicatePrice->id == $price->id){
            $indicatePrice = true;
        }
        
        return Response::json(array('ID' => $price->id, 'table' => View::make('admin/prices/table', array('price' => $price, 'indicatePrice' => $indicatePrice))->render(), 'type'=>$request->type));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Price  $prices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Price $price, ModelOption $modelOption)
    { 
        if($price){
            $usingRModel = ModelOption::where('retail_price_id', $price->id)->get();
            if(count($usingRModel)){
                return Response::json(['errors' => ['using' => [trans('admin/prices.delete_using')]]], 401);
            }else{
                if($price->id == $price->material->pricesSell->first()->id || $price->id == $price->material->pricesBuy->first()->id){
                    return Response::json(['errors' => ['default_price' => [trans('admin/prices.delete_default')]]], 401);
                }

                $price->delete();
                return Response::json(array('success' => trans('admin/prices.delete_success')));
            }
        }
    }

    public function getByMaterial($material, $model){
        $checkExisting = ModelOption::where([
            ['model_id', '=', $model],
            ['material_id', '=', $material]
        ])->first();


        $retail_prices = Price::where(
            [
                ['material_id', '=', $material],
                ['type', '=', 'sell']
            ]
        )->get();

        $prices_retail = array();

        $priceBuy = Price::where(
            [
                ['material_id', '=', $material],
                ['type', '=', 'buy']
            ]
        )->first();

        $models = Model::where(
            [
                ['jewel_id', '=', $material],
            ]
        )->get();

        $pass_models = array();
        
        foreach($models as $model){
            $pass_models[] = (object)[
                'value' => $model->id,
                'label' => $model->name,
            ];
        }
        
        foreach($retail_prices as $price){

            if($checkExisting){
                if($price->id == $checkExisting->retail_price_id){
                    $selected = true;
                }else{
                    $selected = false;
                }
            }else{
                $selected = false;
            }

            $prices_retail[] = (object)[
                'id' => $price->id,
                'material' => $price->material_id,
                'slug' => $price->slug.' - '.$price->price.'лв',
                'price' => $price->price,
                'selected' => $selected
            ];
        }

        return Response::json(array(
            'retail_prices' => $prices_retail, 
            'pass_models' => $models, 
            'pricebuy' => $priceBuy->price));
    }

    public function getByMaterialExchange($material, $model){
        $checkExisting = ModelOption::where([
            ['model_id', '=', $model],
            ['material_id', '=', $material]
            //['default', '=', 'yes']
        ])->first();

        $mat = Material::find($material);

        $retail_prices = Price::where(
            [
                ['material_id', '=', $material],
                ['type', '=', 'buy']
            ]
        )->get();

        $secondary_price = Price::where(
            [
                ['material_id', '=', $material],
                ['type', '=', 'buy'],
                ['price', '<', $retail_prices->first()->price]
            ]
        )->first();

        $prices_retail = array();

        $priceBuy = Price::where(
            [
                ['material_id', '=', $material],
                ['type', '=', 'buy']
            ]
        )->first();

        $models = Model::where(
            [
                ['material_id', '=', $material],
            ]
        )->get();

        $pass_models = array();
        
        foreach($models as $model){
            $pass_models[] = (object)[
                'value' => $model->id,
                'label' => $model->name,
            ];
        }
        
        foreach($retail_prices as $price){

            if($checkExisting){
                if($price->id == $checkExisting->retail_price_id){
                    $selected = true;
                }else{
                    $selected = false;
                }
            }else{
                $selected = false;
            }

            if($secondary_price){
                 if($price->id == $secondary_price->id){
                    $secondary = true;
                    $secondary_price = $secondary_price->price;
                }else{
                    $secondary = false;
                    $secondary_price = $priceBuy->price;
                }
            }else{
                $secondary = false;
                $secondary_price = $priceBuy->price;
            }

            $prices_retail[] = (object)[
                'id' => $price->id,
                'material' => $price->material_id,
                'slug' => $price->slug.' - '.$price->price.'лв',
                'price' => $price->price,
                'selected' => $selected,
                'secondary' => $secondary
            ];
        }

        return Response::json(array(
            'retail_prices' => $prices_retail, 
            'pass_models' => $models, 
            'secondary_price' => $secondary_price,
            'pricebuy' => $priceBuy->price));
    }

    public function select_search(Request $request){
        $query = Material::select('*');

        $materials_new = new Price();
        
        $materials = $materials_new->filterMaterials($request, $query);

        $materials = $materials->paginate(env('RESULTS_PER_PAGE'));
        
        $pass_materials = array();

        foreach($materials as $material){
            $pass_materials[] = [
                'attributes' => [
                    'value' => $material->id,
                    'label' => $material->parent->name.' - '.$material->color.' - '.$material->code,
                    'data-carat' => $material->carat,
                    'data-transform' => $material->carat_transform,
                    'data-pricebuy' => $material->pricesBuy->first()['price'],
                    'data-price' => $material->pricesSell->first()['price'],
                    'data-material' => $material->id,
                ]
            ];
        }

        return json_encode($pass_materials, JSON_UNESCAPED_SLASHES );
    }
}