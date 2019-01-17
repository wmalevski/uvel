<?php

namespace App\Http\Controllers;

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
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MaterialQuantity $materials)
    {
        $products = Product::all();
        $models = Model::all();
        $jewels = Jewel::all();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::all();
        $stores = Store::all();

        $pass_stones = array();
        
        foreach($stones as $stone){
            $pass_stones[] = [
                'value' => $stone->id,
                'label' => $stone->nomenclature->name.' ('. $stone->contour->name .', '. $stone->size->name .' )',
                'type'  => $stone->type,
                'price' => $stone->price
            ];
        }

        return \View::make('admin/products/index', array('stores' => $stores ,'products' => $products, 'jewels' => $jewels, 'models' => $models, 'prices' => $prices, 'stones' => $stones, 'materials' => $materials->scopeCurrentStore(), 'jsStones' =>  json_encode($pass_stones, JSON_UNESCAPED_SLASHES )));
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

    public function search($term){
        $product = new Product();
        $search = $product->search($term);

        return json_encode($search, JSON_UNESCAPED_SLASHES );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product = $product->store($request, 'JSON');
        
        if(isset($product->id)){
            return Response::json(array('success' => View::make('admin/products/table',array('product'=>$product))->render()));
        }else{
            return $product;
        }
        
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
    public function edit(Product $product)
    {
        $product_stones = $product->stones;
        $models = Model::all();
        $jewels = Jewel::all();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::all();
        $materials = MaterialQuantity::all();
        $stores = Store::all();

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

        return \View::make('admin/products/edit', array('stores' => $stores ,'photos' => $photos, 'product_stones' => $product_stones, 'product' => $product, 'jewels' => $jewels, 'models' => $models, 'prices' => $prices, 'stones' => $stones, 'materials' => $materials, 'basephotos' => $pass_photos));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if($product){
            $product_stones = ProductStone::where('product_id', $product)->get();
            $models = Model::all();
            $jewels = Jewel::all();
            $prices = Price::where('type', 'sell')->get();
            $stones = Stone::all();
    
            $photos = Gallery::where(
                [
                    ['table', '=', 'products'],
                    ['product_id', '=', $product->id]
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

            $currentMaterial = MaterialQuantity::withTrashed()->find($product->material);

            if($request->material != $product->material){
                $newMaterial = MaterialQuantity::withTrashed()->find($request->material);

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
    
            $product->model_id = $request->model_id;
            $product->jewel_id = $request->jewel_id;
            $product->weight = $request->weight;
            $product->gross_weight = $request->gross_weight;
            $product->retail_price_id = $request->retail_price_id;
            $product->size = $request->size;
            $product->workmanship = $request->workmanship;
            $product->price = $request->price;
            $product->store_id = $request->store_id;

            if($request->with_stones == 'false'){
                $product->weight_without_stones = 'no';
            } else{
                $product->weight_without_stones = 'yes';
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

            $deleteStones = ProductStone::where('product_id', $product->id)->delete();
    
            if($request->stones){
                foreach($request->stones as $key => $stone){
                    if($stone) {
                        $product_stones = new ProductStone();
                        $product_stones->product_id = $product->id;
                        $product_stones->model_id = $request->model_id;
                        $product_stones->stone_id = $stone;
                        $product_stones->amount = $request->stone_amount[$key];
                        $product_stones->weight = $request->stone_weight[$key];
                        if($request->stone_flow[$key] == 'true'){
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
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
}
