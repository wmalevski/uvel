<?php

namespace App\Http\Controllers;

use App\Product;
use App\Models;
use App\Jewels;
use App\Prices;
use App\Stones;
use App\Model_stones;
use App\Product_stones;
use App\ModelOptions;
use Illuminate\Http\Request;
use Uuid;
use App\Gallery;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\JsonResponse;
use Response;
use File;
use App\Materials;
use App\Materials_quantity;
use Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $models = Models::all();
        $jewels = Jewels::all();
        $prices = Prices::where('type', 'sell')->get();
        $stones = Stones::all();
        //$materials = Materials_quantity::where('store', Auth::user()->getStore())->get();
        $materials = Materials_quantity::all();

        $pass_stones = array();
        
        foreach($stones as $stone){
            $pass_stones[] = [
                'value' => $stone->id,
                'label' => $stone->name.' ('.\App\Stone_contours::withTrashed()->find($stone->contour)->name.', '.\App\Stone_sizes::withTrashed()->find($stone->size)->name.' )'
            ];
        }

        return \View::make('admin/products/index', array('products' => $products, 'jewels' => $jewels, 'models' => $models, 'prices' => $prices, 'stones' => $stones, 'materials' => $materials, 'jsStones' =>  json_encode($pass_stones, JSON_UNESCAPED_SLASHES )));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function chainedSelects(Request $request, $model){
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
            'jewelsTypes' => 'required',
            'retail_price' => 'required',
            'material' => 'required',
            'wholesale_prices' => 'required',
            'weight' => 'required|numeric|between:0.1,10000',
            'size' => 'required|numeric|between:0.1,10000',
            'workmanship' => 'required|numeric|between:0.1,500000',
            'price' => 'required|numeric|between:0.1,500000'
        ]); 

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $material = Materials_quantity::withTrashed()->find($request->material);

        if($material->quantity < $request->weight){
            return Response::json(['errors' => ['using' => ['Няма достатъчна наличност от този материал.']]], 401);
        }

        // $material->quantity - $request->weight;
        // $material->save();

        $model = Models::find($request->model);

        $product = new Product();
        $product->name = $model->name;
        $product->model = $request->model;
        $product->jewel_type = $request->jewelsTypes;
        $product->material = $request->material;
        $product->weight = $request->weight;
        $product->retail_price = $request->retail_price;
        $product->wholesale_price  = $request->wholesale_prices;
        $product->size = $request->size;
        $product->workmanship = $request->workmanship;
        $product->price = $request->price;
        $product->code = 'P'.unique_random('products', 'code', 7);
        $bar = '380'.unique_number('products', 'barcode', 7).'1'; 

        $material->quantity = $material->quantity - $request->weight;
        $material->save();

        if($request->for_wholesale == false){
            $product->for_wholesale = 'no';
        } else{
            $product->for_wholesale = 'yes';
        }

        $digits =(string)$bar;
        // 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
        $even_sum = $digits{1} + $digits{3} + $digits{5} + $digits{7} + $digits{9} + $digits{11};
        // 2. Multiply this result by 3.
        $even_sum_three = $even_sum * 3;
        // 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
        $odd_sum = $digits{0} + $digits{2} + $digits{4} + $digits{6} + $digits{8} + $digits{10};
        // 4. Sum the results of steps 2 and 3.
        $total_sum = $even_sum_three + $odd_sum;
        // 5. The check character is the smallest number which, when added to the result in step 4,  produces a multiple of 10.
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;
        $product->barcode = $digits . $check_digit;

        $product->save();

        $path = public_path('uploads/products/');
        
        File::makeDirectory($path, 0775, true, true);
        Storage::disk('public')->makeDirectory('products', 0775, true);

        $findModel = ModelOptions::where([
            ['material', '=', $request->material],
            ['model', '=', $request->model]
        ])->get();

        if(!$findModel){
            $option = new ModelOptions();
            $option->material = $request->material;
            $option->model = $request->model;
            $option->retail_price = $request->retail_price;
            $option->wholesale_price = $request->wholesale_price;

            $option->save;
        }

        if($request->stones){
            foreach($request->stones as $key => $stone){
                if($stone) {
                    $checkStone = Stones::find($stone);
                    if($checkStone->amount < $request->stone_amount[$key]){
                        return Response::json(['errors' => ['stone_weight' => ['Няма достатъчна наличност от този камък.']]], 401);
                    }
            
                    $checkStone->amount = $checkStone->amount - $request->stone_amount[$key];
                    $checkStone->save();
    
                    $product_stones = new Product_stones();
                    $product_stones->product = $product->id;
                    $product_stones->model = $request->model;
                    $product_stones->stone = $stone;
                    $product_stones->amount = $request->stone_amount[$key];
                    $product_stones->weight = $request->stone_weight[$key];
                    if($request->stone_flow[$key] == true){
                        $product_stones->flow = 'yes';
                    }else{
                        $product_stones->flow = 'no';
                    }
                    $product_stones->save();
                }
            }
        }

        $file_data = $request->input('images'); 
        if($file_data){
            foreach($file_data as $img){
                $memi = substr($img, 5, strpos($img, ';')-5);
                
                $extension = explode('/',$memi);

                if($extension[1] == "svg+xml"){
                    $ext = 'png';
                }else{
                    $ext = $extension[1];
                }
                

                $file_name = 'productimage_'.uniqid().time().'.'.$ext;

                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                file_put_contents(public_path('uploads/products/').$file_name, $data);

                Storage::disk('public')->put('products/'.$file_name, file_get_contents(public_path('uploads/products/').$file_name));

                $photo = new Gallery();
                $photo->photo = $file_name;
                $photo->product_id = $product->id;
                $photo->table = 'products';

                $photo->save();
            }
        }
        
        return Response::json(array('success' => View::make('admin/products/table',array('product'=>$product))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Product $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $products, $product)
    {
        $product = Product::find($product);
        $product_stones = Product_stones::where('product', $product->id)->get();
        $models = Models::all();
        $jewels = Jewels::all();
        $prices = Prices::where('type', 'sell')->get();
        $stones = Stones::all();
        $materials = Materials_quantity::all();

        $photos = Gallery::where(
            [
                ['table', '=', 'products'],
                ['product_id', '=', $product->id]
            ]
        )->get();

        $pass_photos = array();

        foreach($photos as $photo){
            $url =  Storage::get('public/products/'.$photo->photo);
            $ext_url = Storage::url('public/products/'.$photo->photo);
            
            $info = pathinfo($ext_url);
            
            $image_name =  basename($ext_url,'.'.$info['extension']);
            
            $base64 = base64_encode($url);

            if($info['extension'] == "svg"){
                $ext = "png";
            }else{
                $ext = $info['extension'];
            }

            $pass_photos[] = [
                'id' => $photo->id,
                'photo' => 'data:image/'.$ext.';base64,'.$base64
            ];
        }

        return \View::make('admin/products/edit', array('photos' => $photos, 'product_stones' => $product_stones, 'product' => $product, 'jewels' => $jewels, 'models' => $models, 'prices' => $prices, 'stones' => $stones, 'materials' => $materials, 'basephotos' => $pass_photos));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $products, $product)
    {
        $product = Product::find($product);
        
        if($product){
            $product_stones = Product_stones::where('product', $product)->get();
            $models = Models::all();
            $jewels = Jewels::all();
            $prices = Prices::where('type', 'sell')->get();
            $stones = Stones::all();
    
            $photos = Gallery::where(
                [
                    ['table', '=', 'products'],
                    ['product_id', '=', $product->id]
                ]
            )->get();

            $validator = Validator::make( $request->all(), [
                'jewelsTypes' => 'required',
                'retail_price' => 'required',
                'wholesale_prices' => 'required',
                'weight' => 'required|numeric|between:0.1,10000',
                'size' => 'required|numeric|between:0.1,10000',
                'workmanship' => 'required|numeric|between:0.1,500000',
                'price' => 'required|numeric|between:0.1,500000'
            ]); 
    
            if ($validator->fails()) {
                return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
            }

            $currentMaterial = Materials_quantity::withTrashed()->find($product->material);

            if($request->material != $product->material){
                $newMaterial = Materials_quantity::withTrashed()->find($request->material);

                if($newMaterial->quantity < $request->weight){
                    return Response::json(['errors' => ['using' => ['Няма достатъчна наличност от този материал.']]], 401);
                }

                $currentMaterial->quantity = $currentMaterial->quantity + $product->weight;
                $currentMaterial->save();

                $newMaterial->quantity = $newMaterial->quantity - $request->weight;
                $newMaterial->save();

            }else if($request->weight != $product->weight){
                if($currentMaterial->quantity < $request->weight){
                    return Response::json(['errors' => ['using' => ['Няма достатъчна наличност от този материал.']]], 401);
                }

                $newQuantity = $product->weight - $request->weight;
                $currentMaterial->quantity = $currentMaterial->quantity + $newQuantity;
                $currentMaterial->save();

            }
    
            $product->model = $request->model;
            $product->jewel_type = $request->jewelsTypes;
            $product->weight = $request->weight;
            $product->retail_price = $request->retail_price;
            $product->wholesale_price  = $request->wholesale_prices;
            $product->size = $request->size;
            $product->workmanship = $request->workmanship;
            $product->price = $request->price;
    
            if($request->for_wholesale == false){
                $product->for_wholesale = 'no';
            } else{
                $product->for_wholesale = 'yes';
            }
    
            $product->save();

            $path = public_path('uploads/products/');
            
            File::makeDirectory($path, 0775, true, true);
    
            $file_data = $request->input('images'); 
            if($file_data){
                foreach($file_data as $img){
                    $memi = substr($img, 5, strpos($img, ';')-5);
                    
                    $extension = explode('/',$memi);
        
                    if($extension[1] == "svg+xml"){
                        $ext = 'png';
                    }else{
                        $ext = $extension[1];
                    }
                    
        
                    $file_name = 'productimage_'.uniqid().time().'.'.$ext;
                    
                    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                    file_put_contents(public_path('uploads/products/').$file_name, $data);

                    Storage::disk('public')->put('products/'.$file_name, file_get_contents(public_path('uploads/products/').$file_name));
        
                    $photo = new Gallery();
                    $photo->photo = $file_name;
                    $photo->product_id = $product->id;
                    $photo->table = 'products';
        
                    $photo->save();
                }
            }

            $deleteStones = Product_stones::where('product', $product->id)->delete();
    
            if($request->stones){
                foreach($request->stones as $key => $stone){
                    if($stone) {
                        $product_stones = new Product_stones();
                        $product_stones->product = $product->id;
                        $product_stones->model = $request->model;
                        $product_stones->stone = $stone;
                        $product_stones->amount = $request->stone_amount[$key];
                        $product_stones->weight = $request->stone_weight[$key];
                        if($request->stone_flow[$key] == true){
                            $product_stones->flow = 'yes';
                        }else{
                            $product_stones->flow = 'no';
                        }
                        $product_stones->save();
                    }
                }
            }

            $product_photos = Gallery::where(
                [
                    ['table', '=', 'products'],
                    ['product_id', '=', $product->id]
                ]
            )->get();
    
            $photosHtml = '';
            
            foreach($product_photos as $photo){
                $photosHtml .= '
                    <div class="image-wrapper">
                    <div class="close"><span data-url="gallery/delete/'.$photo->id.'">&#215;</span></div>
                    <img src="'.asset("uploads/products/" . $photo->photo).'" alt="" class="img-responsive" />
                </div>';
            }

            return Response::json(array('table' => View::make('admin/products/table',array('product' => $product))->render(), 'photos' => $photosHtml, 'ID' => $product->id));
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $products, $product)
    {
        $product = Product::find($product);
        
        if($product){
            $product->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
