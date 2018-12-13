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
use Auth;

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
        $models = Model::all();
        $jewels = Jewel::all();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::all();
        $stores = Store::all();
        $mats = MaterialQuantity::currentStore();

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
            if($material->material->pricesBuy->first()){
                $pass_materials[] = [
                    'value' => $material->id,
                    'label' => $material->material->parent->name.' - '. $material->material->color.  ' - '  .$material->material->carat,
                    'pricebuy' => $material->material->pricesBuy->first()->price,
                    'material' => $material->material->id
                ];
            }
        }

        return \View::make('admin/orders/index', array('materials' => $materials, 'orders' => $orders, 'stores' => $stores ,'products' => $products, 'jewels' => $jewels, 'models' => $models, 'prices' => $prices, 'stones' => $stones, 'materials' => $materials->scopeCurrentStore(), 'jsStones' =>  json_encode($pass_stones, JSON_UNESCAPED_SLASHES )));
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
        ]); 

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }


        //ADDDDDDDDDDD SCRIPT FOR EXCHANGE WITH MATERIALS

        $material = MaterialQuantity::withTrashed()->find($request->material_id);
        
        if($material->quantity < $request->weight){
            return Response::json(['errors' => ['using' => ['Няма достатъчна наличност от този материал.']]], 401);
        }

        $model = Model::find($request->model_id);
        
        $order = new Order();
        //$order->name = $model->name;
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
        //$order->code = 'P'.unique_random('products', 'code', 7);
        $order->store_id = $request->store_id;
        //$bar = '380'.unique_number('products', 'barcode', 7).'1'; 
        $order->earnest = $request->earnest;

        // $material->quantity = $material->quantity - $request->weight;
        // $material->save();

        if($request->with_stones == 'false'){
            $order->weight_without_stones = 'no';
        } else{
            $order->weight_without_stones = 'yes';
        }

        // $digits =(string)$bar;
        // // 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
        // $even_sum = $digits{1} + $digits{3} + $digits{5} + $digits{7} + $digits{9} + $digits{11};
        // // 2. Multiply this result by 3.
        // $even_sum_three = $even_sum * 3;
        // // 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
        // $odd_sum = $digits{0} + $digits{2} + $digits{4} + $digits{6} + $digits{8} + $digits{10};
        // // 4. Sum the results of steps 2 and 3.
        // $total_sum = $even_sum_three + $odd_sum;
        // // 5. The check character is the smallest number which, when added to the result in step 4,  produces a multiple of 10.
        // $next_ten = (ceil($total_sum/10))*10;
        // $check_digit = $next_ten - $total_sum;
        // $product->barcode = $digits . $check_digit;

        //$path = public_path('uploads/products/');
        
        // File::makeDirectory($path, 0775, true, true);
        // Storage::disk('public')->makeDirectory('products', 0775, true);


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
                        return Response::json(['errors' => ['stone_weight' => ['Няма достатъчна наличност от този камък.']]], 401);
                    }
            
                    $checkStone->amount = $checkStone->amount - $request->stone_amount[$key];
                    $checkStone->save();
                }
            }
        }

        if($request->stones){
            if($stoneQuantity == 1){
                $order->save();
                foreach($request->stones as $key => $stone){
                    if($stone) {
                        $order_stones = new OrderStone();
                        $order_stones->order_id = $order->id;
                        $order_stones->model_id = $request->model_id;
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
        }else{
            $order->save();
        }

        // $file_data = $request->input('images'); 
        // if($file_data){
        //     foreach($file_data as $img){
        //         $memi = substr($img, 5, strpos($img, ';')-5);
                
        //         $extension = explode('/',$memi);
        //         if($extension[1] == "svg+xml"){
        //             $ext = 'png';
        //         }else{
        //             $ext = $extension[1];
        //         }
                

        //         $file_name = 'productimage_'.uniqid().time().'.'.$ext;

        //         $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
        //         file_put_contents(public_path('uploads/products/').$file_name, $data);

        //         Storage::disk('public')->put('products/'.$file_name, file_get_contents(public_path('uploads/products/').$file_name));

        //         $photo = new Gallery();
        //         $photo->photo = $file_name;
        //         $photo->product_id = $product->id;
        //         $photo->table = 'products';
        //         $photo->save();
        //     }
        // }
        
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
        $models = Model::all();
        $jewels = Jewel::all();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::all();
        $materials = MaterialQuantity::all();
        $stores = Store::all();

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
    
            $photos = Gallery::where(
                [
                    ['table', '=', 'orders'],
                    ['order_id', '=', $order->id]
                ]
            )->get();

            $validator = Validator::make( $request->all(), [
                'jewel_id' => 'required',
                'retail_price_id' => 'required|numeric|min:1',
                'weight' => 'required|numeric|between:0.1,10000',
                'gross_weight' => 'required|numeric|between:0.1,10000',
                'size' => 'required|numeric|between:0.1,10000',
                'workmanship' => 'required|numeric|between:0.1,500000',
                'price' => 'required|numeric|between:0.1,500000',
                'store_id' => 'required|numeric'
            ]); 
    
            if ($validator->fails()) {
                return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
            }

            $currentMaterial = MaterialQuantity::withTrashed()->find($order->material);

            if($request->material != $order->material){
                $newMaterial = MaterialQuantity::withTrashed()->find($request->material);

                if($newMaterial->quantity < $request->weight){
                    return Response::json(['errors' => ['using' => ['Няма достатъчна наличност от този материал.']]], 401);
                }

                $currentMaterial->quantity = $currentMaterial->quantity + $order->weight;
                $currentMaterial->save();

                $newMaterial->quantity = $newMaterial->quantity - $request->weight;
                $newMaterial->save();

            }else if($request->weight != $order->weight){
                if($currentMaterial->quantity < $request->weight){
                    return Response::json(['errors' => ['using' => ['Няма достатъчна наличност от този материал.']]], 401);
                }

                $newQuantity = $order->weight - $request->weight;
                $currentMaterial->quantity = $currentMaterial->quantity + $newQuantity;
                $currentMaterial->save();

            }
    
            $order->model_id = $request->model_id;
            $order->jewel_id = $request->jewel_id;
            $order->weight = $request->weight;
            $order->gross_weight = $request->gross_weight;
            $order->retail_price_id = $request->retail_price_id;
            $order->size = $request->size;
            $order->workmanship = $request->workmanship;
            $order->price = $request->price;
            $order->store_id = $request->store_id;

            if($request->with_stones == 'false'){
                $order->weight_without_stones = 'no';
            } else{
                $order->weight_without_stones = 'yes';
            }
    
            $order->save();

            // $path = public_path('uploads/products/');
            
            // File::makeDirectory($path, 0775, true, true);
    
            // $file_data = $request->input('images'); 
            // if($file_data){
            //     foreach($file_data as $img){
            //         $memi = substr($img, 5, strpos($img, ';')-5);
                    
            //         $extension = explode('/',$memi);
        
            //         if($extension[1] == "svg+xml"){
            //             $ext = 'png';
            //         }else{
            //             $ext = $extension[1];
            //         }
                    
        
            //         $file_name = 'productimage_'.uniqid().time().'.'.$ext;
                    
            //         $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
            //         file_put_contents(public_path('uploads/products/').$file_name, $data);

            //         Storage::disk('public')->put('products/'.$file_name, file_get_contents(public_path('uploads/products/').$file_name));
        
            //         $photo = new Gallery();
            //         $photo->photo = $file_name;
            //         $photo->product_id = $product->id;
            //         $photo->table = 'products';
        
            //         $photo->save();
            //     }
            // }

            $deleteStones = OrderStone::where('order_id', $order->id)->delete();
    
            if($request->stones){
                foreach($request->stones as $key => $stone){
                    if($stone) {
                        $order_stones = new OrderStone();
                        $order_stones->product_id = $product->id;
                        $order_stones->model_id = $request->model_id;
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

         
            return Response::json(array('table' => View::make('admin/orders/table',array('order' => $order))->render(), 'ID' => $product->id));
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
        if($product){
            if($product->status != 'selling'){
                $product->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }else{
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }
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
