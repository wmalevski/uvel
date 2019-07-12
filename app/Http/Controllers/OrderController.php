<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Model;
use App\Jewel;
use App\Price;
use App\Stone;
use App\ModelStone;
use App\ProductStone;
use App\ModelOption;
use Illuminate\Http\Request;
use App\Gallery;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\JsonResponse;
use Response;
use File;
use App\Material;
use App\Store;
use App\MaterialQuantity;
use Storage;
use App\OrderStone;
use App\ProductTravelling;
use App\ExchangeMaterial;
use Auth;
use App\OrderItem;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MaterialQuantity $materials)
    {
        $orders = Order::all();
        $products = Product::all();
        $models = Model::take(env('SELECT_PRELOADED'))->get();
        $jewels = Jewel::take(env('SELECT_PRELOADED'))->get();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::take(env('SELECT_PRELOADED'))->get();
        $stores = Store::take(env('SELECT_PRELOADED'))->get();
        $mats = MaterialQuantity::currentStore()->take(env('SELECT_PRELOADED'));

        $pass_stones = array();
        
        foreach($stones as $stone){
            $pass_stones[] = [
                'value' => $stone->id,
                'label' => $stone->name.' ('. $stone->contour->name .', '. $stone->size->name .' )',
                'type'  => $stone->type,
                'price' => $stone->price
            ];
        }

        $pass_materials = array();
        
        foreach($mats as $material){
            if($material->material->pricesSell->first()){
                $pass_materials[] = [
                    'value' => $material->id,
                    'label' => $material->material->parent->name.' - '. $material->material->color.  ' - '  .$material->material->carat,
                    'pricebuy' => $material->material->pricesBuy->first()->price,
                    'material' => $material->material->id
                ];
            }
        }

        return \View::make('admin/orders/index', array('mats' => $mats, 'materials' => $materials, 'orders' => $orders, 'stores' => $stores ,'products' => $products, 'jewels' => $jewels, 'models' => $models, 'prices' => $prices, 'stones' => $stones, 'materials' => $materials->scopeCurrentStore(), 'jsStones' =>  json_encode($pass_stones, JSON_UNESCAPED_SLASHES )));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function chainedSelects(Request $request, Model $model){
        $product = new Product;
        return $product->chainedSelects($model);
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
            'jewel_id' => 'required',
            'material_id' => 'required',
            'retail_price_id' => 'required|numeric|min:1',
            'weight' => 'required|numeric|between:0.1,10000',
            'gross_weight' => 'required|numeric|between:0.1,10000',
            'size' => 'required|numeric|between:0.1,10000',
            'workmanship' => 'required|numeric|between:0.1,500000',
            'price' => 'required|numeric|between:0.1,500000',
            'store_id' => 'required|numeric',
            'earnest' => 'numeric|nullable',
            'safe_group' => 'numeric|nullable',
            'quantity' => 'required',
            'mat_quantity.*' => 'numeric|min:1'
        ]); 

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $model = Model::find($request->model_id);
        
        $order = new Order();
        $order->model_id = $request->model_id;
        $order->jewel_id = $request->jewel_id;
        $order->product_id = $request->product_id;
        $order->material_id = $request->material_id;
        $order->weight = $request->weight;
        $order->gross_weight = $request->gross_weight;
        $order->retail_price_id = $request->retail_price_id;
        $order->size = $request->size;
        $order->workmanship = $request->workmanship;
        $order->price = $request->price;
        $order->store_id = $request->store_id;
        $order->earnest = $request->earnest;
        $order->quantity = $request->quantity;
        $order->content = $request->content;

        if($request->with_stones == 'false'){
            $order->weight_without_stones = 'no';
        } else{
            $order->weight_without_stones = 'yes';
        }

        $findModel = ModelOption::where([
            ['material_id', '=', $request->material],
            ['model_id', '=', $request->model]
        ])->get();

        if(!$findModel){
            $option = new ModelOption();
            $option->material_id = $request->material_id;
            $option->model_id = $request->model_id;
            $option->retail_price_id = $request->retail_price_id;

            $option->save;
        }

        $stoneQuantity = 1;
        if($request->stones){
            foreach($request->stones as $key => $stone){
                if($stone) {
                    $checkStone = Stone::find($stone);
                    if($checkStone->amount < $request->stone_amount[$key]){
                        $stoneQuantity = 0;
                        return Response::json(['errors' => ['stone_weight' => [trans('admin/orders.stone_quantity_not_matching')]]], 401);
                    }
            
                    $checkStone->amount = $checkStone->amount - $request->stone_amount[$key];
                    $checkStone->save();
                }
            }
        }
        
        $order->save();

        if($request->stones){
            if($stoneQuantity == 1){
                
                foreach($request->stones as $key => $stone){
                    if($stone) {
                        $order_stones = new OrderStone();
                        $order_stones->order_id = $order->id;
                        $order_stones->stone_id = $stone;
                        $order_stones->amount = $request->stone_amount[$key];
                        $order_stones->weight = $request->stone_weight[$key];
                        if($request->stone_flow[$key] == 'true'){
                            $order_stones->flow = 'yes';
                        }else{
                            $order_stones->flow = 'no';
                        }
                        $order_stones->save();
                    }
                }
            }
        }

        if($request->given_material_id){
            foreach($request->given_material_id as $key => $material){
                if($material){
                    $price = Material::find($material)->pricesSell()->first()->price;

                    $exchange_material = new ExchangeMaterial();
                    $exchange_material->material_id = $material;
                    $exchange_material->order_id = $order->id;
                    $exchange_material->weight = $request->mat_quantity[$key];
                    $exchange_material->sum_price = $request->mat_quantity[$key] * $price;
                    $exchange_material->additional_price = 0;

                    $exchange_material->save();
                }
            }
        }

        return Response::json(array('success' => View::make('admin/orders/table',array('order' => $order))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $products  
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $order_stones = $order->stones;
        $order_materials = $order->materials;
        $models = Model::take(env('SELECT_PRELOADED'))->get();
        $jewels = Jewel::take(env('SELECT_PRELOADED'))->get();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::take(env('SELECT_PRELOADED'))->get();
        $materials = Material::take(env('SELECT_PRELOADED'))->get();
        $stores = Store::take(env('SELECT_PRELOADED'))->get();

        return \View::make('admin/orders/edit', array('stores' => $stores , 'order_stones' => $order_stones, 'order' => $order, 'jewels' => $jewels, 'models' => $models, 'prices' => $prices, 'stones' => $stones, 'materials' => $materials));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        if($order){
            $order_stones = OrderStone::where('order_id', $order)->get();
            $models = Model::all();
            $jewels = Jewel::all();
            $prices = Price::where('type', 'sell')->get();
            $stones = Stone::all();

            $validator = Validator::make( $request->all(), [
                'jewel_id' => 'required',
                'material_id' => 'required',
                'retail_price_id' => 'required|numeric|min:1',
                'weight' => 'required|numeric|between:0.1,10000',
                'gross_weight' => 'required|numeric|between:0.1,10000',
                'size' => 'required|numeric|between:0.1,10000',
                'workmanship' => 'required|numeric|between:0.1,500000',
                'price' => 'required|numeric|between:0.1,500000',
                'store_id' => 'required|numeric',
                'earnest' => 'numeric|nullable',
                'safe_group' => 'numeric|nullable',
                'quantity' => 'required'
            ]); 
    
            if ($validator->fails()) {
                return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
            }
    
            $material = MaterialQuantity::withTrashed()->where([
                ['material_id', '=', $request->material_id],
                ['store_id', '=', Auth::user()->getStore()->id]
            ])->first();
            
            if($material->quantity < $request->weight){
                return Response::json(['errors' => ['using' => [trans('admin/orders.material_quantity_not_matching')]]], 401);
            }
    
            $model = Model::find($request->model_id);
            
            $order->model_id = $request->model_id;
            $order->jewel_id = $request->jewel_id;
            $order->product_id = $request->product_id;
            $order->material_id = $request->material_id;
            $order->weight = $request->weight;
            $order->gross_weight = $request->gross_weight;
            $order->retail_price_id = $request->retail_price_id;
            $order->size = $request->size;
            $order->workmanship = $request->workmanship;
            $order->price = $request->price;
            $order->store_id = $request->store_id;
            $order->earnest = $request->earnest;
            $order->quantity = $request->quantity;
            $order->content = $request->content;
    
            if($request->with_stones == 'false'){
                $order->weight_without_stones = 'no';
            } else{
                $order->weight_without_stones = 'yes';
            }
    
            $findModel = ModelOption::where([
                ['material_id', '=', $request->material],
                ['model_id', '=', $request->model]
            ])->get();
    
            if(!$findModel){
                $option = new ModelOption();
                $option->material_id = $request->material_id;
                $option->model_id = $request->model_id;
                $option->retail_price_id = $request->retail_price_id;
    
                $option->save;
            }


            foreach($order->stones as $orderStone){
                $orderStone->stone->amount = $orderStone->stone->amount + $orderStone->amount;
                $orderStone->stone->save();
            }

            $deleteStones = $order->stones()->delete();
    
            $stoneQuantity = 1;
            if($request->stones){
                foreach($request->stones as $key => $stone){
                    if($stone) {
                        $checkStone = Stone::find($stone);
                        if($checkStone->amount < $request->stone_amount[$key]){
                            $stoneQuantity = 0;
                            return Response::json(['errors' => ['stone_weight' => [trans('admin/orders.stone_quantity_not_found')]]], 401);
                        }
                
                        $checkStone->amount = $checkStone->amount - $request->stone_amount[$key];
                        $checkStone->save();
                    }
                }
            }
            
            $order->save();

            $deleteStones = OrderStone::where('order_id', $order->id)->delete();
    
            if($request->stones){
                if($stoneQuantity == 1){
                    
                    foreach($request->stones as $key => $stone){
                        if($stone) {
                            $order_stones = new OrderStone();
                            $order_stones->order_id = $order->id;
                            $order_stones->stone_id = $stone;
                            $order_stones->amount = $request->stone_amount[$key];
                            $order_stones->weight = $request->stone_weight[$key];
                            if($request->stone_flow[$key] == 'true'){
                                $order_stones->flow = 'yes';
                            }else{
                                $order_stones->flow = 'no';
                            }
                            $order_stones->save();
                        }
                    }
                }
            }
    
            if($request->given_material_id){
                $materials = ExchangeMaterial::where('order_id', $order->id)->delete();

                foreach($request->given_material_id as $key => $material){
                    if($material){
                        $price = Material::find($material)->pricesSell()->first()->price;
                        
                        $exchange_material = new ExchangeMaterial();
                        $exchange_material->material_id = $material;
                        $exchange_material->order_id = $order->id;
                        $exchange_material->weight = $request->mat_quantity[$key];
                        $exchange_material->sum_price = $request->mat_quantity[$key] * $price;
                        $exchange_material->additional_price = 0;
    
                        $exchange_material->save();

                        $material_quantity = MaterialQuantity::where('material_id', $material)->first();

                        if($material_quantity){
                            $material_quantity->quantity = $material_quantity->quantity+$request->weight[$key];
                            $material_quantity->save();
                        }
                    }
                }
            }

            if($request->status == 'true'){
                $product_id = 0;
                for($i=1;$i<=$request->quantity;$i++){

                    $material = MaterialQuantity::where([
                        ['material_id', $request->material_id],
                        ['store_id', Auth::user()->getStore()->id]
                    ])->first();
        
                    if(!$material || $material->quantity < $request->weight){
                        return Response::json(['errors' => ['using' => ['Няма достатъчна наличност от този материал.']]], 401);
                    }

                    $product = new Product();

                    $request->merge([
                        'weight' => $order->weight/$order->quantity,
                        'status' => 'travelling'
                    ]);

                    $productResponse = $product->store($request, 'array');

                    if($productResponse['errors']){
                        return Response::json(['errors' => $productResponse['errors']], 401);
                    }

                    $request->request->add(['store_to_id' => $request->store_id]);
                    $request->request->add(['product_id' => $productResponse->id]);
                    $request->request->add(['store_from_id' => 1]);

                    $productTravelling = new ProductTravelling();
                    $productTravellingResponse = $productTravelling->store($request, 'array'); 

                    $order_item = new OrderItem();
                    $order_item->product_id = $productResponse->id;
                    $order_item->order_id = $order->id;
                    $order_item->save();
                    
                    if($productTravellingResponse['errors']){
                        return Response::json(['errors' => $productTravellingResponse['errors']], 401);
                    }
                    $product_id = $productResponse->id;
                }

                $order = Order::find($order->id);
                $order->product_id = $product_id;
                $order->status = 'ready';
                $order->save();
            }

            $deleteStones = OrderStone::where('order_id', $order->id)->delete();
    
            if($request->stones){
                foreach($request->stones as $key => $stone){
                    if($stone) {
                        $order_stones = new OrderStone();
                        $order_stones->order_id = $order->id;
                        $order_stones->stone_id = $stone;
                        $order_stones->amount = $request->stone_amount[$key];
                        $order_stones->weight = $request->stone_weight[$key];
                        if($request->stone_flow[$key] == 'true'){
                            $order_stones->flow = 'yes';
                        }else{
                            $order_stones->flow = 'no';
                        }
                        $order_stones->save();
                    }
                }
            }

         
            return Response::json(array('table' => View::make('admin/orders/table',array('order' => $order))->render(), 'ID' => $order->id));
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if($order){
            $order->delete();
            return Response::json(array('success' => trans('admin/orders.order_deleted')));
        }
    }

    public function getProductInfo($product){
        if($product){
            $product = Product::where('barcode', $product)->first();
            if($product){
                return $product->chainedSelects($product->model);
            }
        }
    }

    public function getModelInfo(Request $request, Model $model){
        if($model){
            $product = new Product;
            return $product->chainedSelects($model);
        }
    }
}
