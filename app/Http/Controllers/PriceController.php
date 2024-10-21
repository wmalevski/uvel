<?php

namespace App\Http\Controllers;

use App\Jewel;
use App\Material;
use App\MaterialQuantity;
use App\Model;
use App\ModelOption;
use App\Price;
use App\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Mavinoo\Batch\Batch;
use Response;

class PriceController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $materials = Material::take(env('SELECT_PRELOADED'))->get();

        if($request->isMethod('post')){
            return redirect()->route('view_price', ['material' => $request->material_id]);
        }

        return \View::make('admin/prices/index', array('materials' => $materials));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(),array(
            'slug' => 'required',
            'price' => 'required|regex:/^\d*(\.\d{1,3})?$/',
            'type' => 'required'
        ));

        if($validator->fails()){
            return Response::json(array('errors'=>$validator->getMessageBag()->toArray()), 401);
        }

        $price = Price::create($request->all());

        $indicatePrice = false;
        $getIndicatePrice = Price::where(array(
            'type'=>$price->type,
            'material_id'=>$price->material_id
        ))->orderBy('id', 'ASC')->first();

        if($getIndicatePrice && $getIndicatePrice->id == $price->id){
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
    public function show(Price $price, $material){
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
    public function edit(Price $price){
        return \View::make('admin/prices/edit', array('price' => $price));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Price  $prices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Price $price){
        $validator = Validator::make( $request->all(),array(
            'slug' => 'required',
            'price' => 'required|regex:/^\d*(\.\d{1,3})?$/',
            'type' => 'required'
        ));

        if($validator->fails()){
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $price->slug = $request->slug;
        $price->price = $request->price;
        $price->type = $request->type;
        $price->save();

        $sell = Price::where(array(
            'material_id'=>$price->material_id,
            'type'=>($request->type == 'sell' ? 'buy' : 'sell')
        ))->first()->price;
        $buy = $request->price;

        try {
            $products = Product::where(array(
                'material_id'=>$price->material_id,
                'retail_price_id'=>$price->id
            ))->with(['model']);

            if ( ( strtolower($price->type) == 'buy' ) ) {
                $getFirstBuyPrice = Price::where('type', 'buy')
                    ->where('material_id', $price->material_id)
                    ->orderBy('id')
                    ->first();

                if ( $getFirstBuyPrice->id == $price->id ) {
                    $products = Product::where(array(
                        'material_id'=>$price->material_id,
                        // 'retail_price_id'=>$price->id
                    ))->with(['model']);
                }
            }

            $products = $products->get();
            $totalProductsUpdated = 0;
            $totalModelsUpdated   = 0;
            $productsBatch        = [];
            $modelsBatch          = [];

            foreach ($products->chunk(5000) as $chunk) {
                foreach ($chunk as $product) {
                    if( $product->status != 'sold' ) {
                      $productsBatch[] = [
                        'id' => $product->id,
                        'price' => round($request->price * $product->weight),
                        'workmanship' => round(($buy - $sell) * $product->weight),
                      ];
                    }

                    $model = $product->model;
                    if ($model) {
                        $modelsBatch[] = [
                            'id' => $model->id,
                            'price' => round(($request->type == 'sell' ? $buy : $sell) * $model->weight),
                            'workmanship' => round(($buy - $sell) * $model->weight),
                        ];
                    }
                }
            }

           if (!empty($productsBatch)) {
                $indexColumn          = 'id';
                $batchSize            = 1000;
                $productInstance      = new Product;
                $productChunks        = array_chunk($productsBatch, $batchSize);

                foreach ($productChunks as $chunk) {
                    $productInstance->batchUpdate($chunk, $indexColumn);
                    $totalProductsUpdated += count($chunk);
                }

                if (!empty($modelsBatch)) {
                    $modelInstance = new Model;
                    $modelChunks = array_chunk($modelsBatch, $batchSize);
                    foreach ($modelChunks as $chunk) {
                        $modelInstance->batchUpdate($chunk, $indexColumn);
                        $totalModelsUpdated += count($chunk);
                    }
                }
           }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $indicatePrice = false;
        $getIndicatePrice = Price::where([
            ['type', '=', $price->type],
            ['material_id', '=', $price->material_id]
        ])->orderBy('id', 'ASC')->first();

        if($getIndicatePrice && $getIndicatePrice->id == $price->id){
            $indicatePrice = true;
        }

        if($request->type == 'buy') {
            $targetTable = 'table-price-buy';
        }elseif($request->type == 'sell') {
            $targetTable = 'table-price-sell';
        }

        return Response::json(array('ID' => $price->id, 'table' => View::make('admin/prices/table', array(
            'price' => $price,
            'indicatePrice' => $indicatePrice,
        ))->render(),
            'type'=>$request->type,
            'targetTable' => $targetTable,
            'totalProductsUpdated' => "Total products updated: $totalProductsUpdated\n",
            'totalModelsUpdated' => "Total models updated: $totalModelsUpdated\n",
        ));
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
        $materials = $materials->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $pass_materials = array();

        foreach($materials as $material){
            $priceBuy=$material->pricesBuy->first();
            $priceSell=$material->pricesSell->first();

            $priceBuy=(isset($priceBuy['price'])?$priceBuy['price']:'--');
            $priceSell=(isset($priceSell['price'])?$priceSell['price']:'--');

            $pass_materials['results'][] = [
                    'id' => $material->id,
                    'text' => $material->parent->name.' - '.$material->color.' - '.$material->code,
                    'attributes' => [
                        'data-carat' => $material->carat,
                        'data-transform' => $material->carat_transform,
                        'data-pricebuy' => $priceBuy,
                        'data-price' => $priceSell,
                        'data-material' => $material->id,
                    ],
            ];
        }

        $pass_materials['pagination'] = ['more' => $materials->hasMorePages()];

        return response()->json($pass_materials);
    }
}
