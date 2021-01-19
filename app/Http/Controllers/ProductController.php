<?php

namespace App\Http\Controllers;

use App\Product;
use App\Model;
use App\Jewel;
use App\Price;
use App\ProductTravelling;
use App\Stone;
use App\Review;
use App\ModelStone;
use App\ProductStone;
use App\ModelOption;
use Illuminate\Http\Request;
use App\Gallery;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;
use Response;
use File;
use App\Material;
use App\Store;
use App\MaterialQuantity;
use Storage;
use Auth;
use Milon\Barcode\DNS1D;

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
        $models = Model::take(env('SELECT_PRELOADED'))->get();
        $jewels = Jewel::take(env('SELECT_PRELOADED'))->get();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::take(env('SELECT_PRELOADED'))->get();
        $stores = Store::take(env('SELECT_PRELOADED'))->get();
        $loggedUser = Auth::user();

        $pass_stones = array();

        foreach($stones as $stone){
            $pass_stones[] = [
                'value' => $stone->id,
                'label' => $stone->nomenclature->name.' ('. $stone->contour->name .', '. $stone->size->name .' )',
                'type'  => $stone->type,
                'price' => $stone->price
            ];
        }

        return \View::make('admin/products/index', array('loggedUser' => $loggedUser,'stores' => $stores ,'products' => $products, 'jewels' => $jewels, 'models' => $models, 'prices' => $prices, 'stones' => $stones, 'materials' => $materials->scopeCurrentStore(), 'jsStones' =>  json_encode($pass_stones, JSON_UNESCAPED_SLASHES )));
    }

    /**
     * Show all products reviews
     */
    public function showReviews()
    {
        $reviews = Review::where([
            ['product_id', '!=', '']
        ])->get();

        return \View::make('admin/products_reviews/index', array('reviews'=>$reviews));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function productsReport()
    {
        $products = Product::selectRaw('material_id')->selectRaw('store_id')->selectRaw('id')->selectRaw('model_id')->groupBy('store_id')->selectRaw('COUNT(id) as count')->get();
        $stores = Store::all();

        return view('admin.reports.products_reports.index', compact(['stores', 'products']));
    }

    public function chainedSelects(Request $request, Model $model){
        $product = new Product;
        return $product->chainedSelects($model);
    }

    public function select_search(Request $request){
        $products = Product::filterProducts($request)->where('status', 'available')->paginate(\App\Setting::where('key','per_page')->get()[0]->value);
        $pass_products = array();
        $loggedUser = Auth::user();

        foreach($products as $product){
            if($loggedUser->role != 'admin' && $loggedUser->role != 'storehouse' && $loggedUser->store_id == $product->store_info->id) {
                $pass_products[] = [
                    'attributes' => [
                        'value' => $product->id,
                        'name' => $product->name,
                        'label' => $product->id,
                        'barcode' => $product->barcode,
                        'weight' => $product->weight,
                        'data-product-id' => $product->id,
                        'data-barcode' => $product->barcode
                    ]
                ];
            } elseif ($loggedUser->role == 'admin' || $loggedUser->role == 'storehouse') {
                $pass_products[] = [
                    'attributes' => [
                        'value' => $product->id,
                        'name' => $product->name,
                        'label' => $product->id,
                        'barcode' => $product->barcode,
                        'weight' => $product->weight,
                        'data-product-id' => $product->id,
                        'data-barcode' => $product->barcode
                    ]
                ];
            }

        }

        return json_encode($pass_products, JSON_UNESCAPED_SLASHES );
    }

    public function filter(Request $request){
        $products = Product::filterProducts($request)->paginate(\App\Setting::where('key','per_page')->get()[0]->value);
        $response = '';
        foreach($products as $product){
            $response .= \View::make('admin/products/table', array('product' => $product, 'listType' => $request->listType));
        }

        $products->setPath('');
        $response .= $products->appends(Input::except('page'))->links();

        return $response;
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
        $models = Model::take(env('SELECT_PRELOADED'))->get();
        $jewels = Jewel::take(env('SELECT_PRELOADED'))->get();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::take(env('SELECT_PRELOADED'))->get();
        $materials = Material::take(env('SELECT_PRELOADED'))->get();
        $stores = Store::take(env('SELECT_PRELOADED'))->get();

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

            $validate_data = [
                'status' => 'required',
                'jewel_id' => 'required',
                'retail_price_id' => 'required|numeric|min:1',
                'weight' => 'required|numeric|between:0.1,10000',
                'gross_weight' => 'required|numeric|between:0.1,10000',
                'size' => 'required|numeric|between:0.1,10000',
                'workmanship' => 'required|numeric|between:0.1,500000',
                'price' => 'required|numeric|between:0.1,500000',
            ];

            if(Auth::user()->role != 'storehouse') {
                $validate_data['store_id'] = 'required|numeric';
            }

            $validator = Validator::make( $request->all(), $validate_data);

            if ($validator->fails()) {
                return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
            }

            $currentMaterial = MaterialQuantity::withTrashed()->where('material_id', '=', $product->material_id)->first();

            if($request->material_id != $product->material_id){
                $newMaterial = MaterialQuantity::withTrashed()->where('material_id', '=', $request->material_id)->first();

                if (!$newMaterial) {
                    $newMaterial = new MaterialQuantity();
                    $newMaterial->material_id = $request->material_id;
                    $newMaterial->quantity = 0;
                    $newMaterial->store_id = Auth::user()->store_id;
                }

                $currentMaterial->quantity -= $product->weight;
                $currentMaterial->save();

                $newMaterial->quantity += $request->weight;
                $newMaterial->save();

            }else if($request->weight != $product->weight){
                $currentMaterial->quantity -= $product->weight;
                $currentMaterial->quantity += $request->weight;
                $currentMaterial->save();

            }

            $store_data = Auth::user()->role == 'storehouse' && !isset($request->store_id)? "1" : $request->store_id;

            $product->material_id = $request->material_id;
            $product->model_id = $request->model_id;
            $product->jewel_id = $request->jewel_id;
            $product->weight = $request->weight;
            $product->gross_weight = round($request->gross_weight, 3);
            $product->retail_price_id = $request->retail_price_id;
            $product->size = $request->size;
            $product->workmanship = round($request->workmanship);
            $product->price = round($request->price);
            $product->status = $request->status;
            $product->store_id = $store_data;

            if($request->with_stones == 'false'){
                $product->weight_without_stones = 'yes';
            } else{
                $product->weight_without_stones = 'no';
            }

            if($request->website_visible == 'true'){
                $product->website_visible =  'yes';
            }else{
                $product->website_visible =  'no';
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

            foreach($product->stones as $productStone){
                $productStone->stone->amount = $productStone->stone->amount + $productStone->amount;
                $productStone->stone->save();
            }

            $deleteStones = $product->stones()->delete();

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
     * Send information for specific product
     *
     * @param Model $model
     * @return \Illuminate\Http\Response
     */
    public function getProductInformation(Product $product)
    {
        $photos = Gallery::where(
            [
                ['table', '=', 'products'],
                ['product_id', '=', $product->id]
            ]
        )->get();

        $product_stones = array();
        $stones = ProductStone::where('product_id', $product->id)->get();

        foreach($stones as $stone){
            $product_stones[] = array(
                "name"      => $this->getProductStoneName($stone->stone_id),
                "amount"    => $stone->amount,
                "weight"    => $stone->weight,
                "flow"      => $stone->flow,
                "size"      => $stone->stone->size->name
            );
        }

        $material =  Material::where('id', $product->material_id)->first();
        $jewel = Jewel::where('id',$product->jewel_id)->first();
        $barcode = new DNS1D();
        $barcode = $barcode->getBarcodeSVG($product->barcode, "EAN13",1,33,"black", true);

        $product_info = array(
            "id"                => $product->id,
            "name"              => $product->name,
            "jewelName"         => $jewel->name,
            "workmanshipPrice"  => $product->workmanship,
            "size"              => $product->size,
            "material"          => $material->name . '-' . $material->code . '-' . $material->color,
            "stones"            => $product_stones,
            "barcode"           => $barcode,
            "websiteVisible"    => $product->website_visible,
            "price"             => $product->price,
            "created"           => $product->created_at,
            "updated"           => $product->updated_at,
            "photos"            => $this->getProductPhotos($photos)
        );

        if($product->weight_without_stones == 'no') {
            $product_info["weight"] = $product->gross_weight;
        }else {
            $product_info["weight"] = $product->weight;
        }

        return Response::json(['product' => $product_info], 200);
    }

    /**
     * Get product stone name
     *
     * @param $productStoneId
     *
     * @return string
     */
    private function getProductStoneName($productStoneId)
    {
        $preloaded_stones = Stone::take(env('SELECT_PRELOADED'))->get();

        foreach($preloaded_stones  as $stone) {
            if($stone->id == $productStoneId){
                return $stone->nomenclature->name . ' (' . $stone->contour->name . ', ' . $stone->style->name . ')';
            }
        }
    }

    /**
     * Get product images
     *
     * @param $photos
     * @return array
     */
    private function getProductPhotos($photos)
    {
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

        return $pass_photos;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product) {
            if ($product->status != 'selling') {
                if (($product_travelling = ProductTravelling::where('product_id', $product->id)) && $product_travelling->first()) {
                    $product_travelling->delete();
                }
                $material = MaterialQuantity::withTrashed()->where([
                    ['material_id', '=', $product->material_id],
                    ['store_id', '=', $product->store_id]
                ])->first();
                if($material) {
                  $material->quantity -= $product->weight;
                  $material->save();
                }
                $product->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            } else {
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }
        }
    }
}
