<?php

namespace App\Http\Controllers;

use App\Model;
use App\Jewel;
use App\Price;
use App\Stone;
use App\ModelStone;
use App\Review;
use App\Product;
use App\ProductStone;
use App\Material;
use App\MaterialQuantity;
use App\ModelOption;
use App\Gallery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Input;
use Response;
use Illuminate\Support\Facades\View;
use File;
use Auth;
use Uuid;
use Storage;

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Model::all();
        $jewels = Jewel::take(env('SELECT_PRELOADED'))->get();
        $prices = Price::all();
        $stones = Stone::take(env('SELECT_PRELOADED'))->get();
        $materials = Material::take(env('SELECT_PRELOADED'));
        $pass_stones = array();
        
        foreach($stones as $stone){
            $pass_stones[] = [
                'value' => $stone->id,
                'label' => $stone->nomenclature->name.' ('.$stone->contour->name.', '.$stone->size->name.', '.$stone->style->name.' )',
                'type' => $stone->type,
                'price' => $stone->price
            ];
        }

        $pass_materials = array();
        
        foreach($materials as $material){
            if($material->pricesSell->first()){
                $pass_materials[] = [
                    'value' => $material->id,
                    'label' => $material->parent->name.' - '. $material->color.  ' - '  .$material->carat,
                    'price' => $material->pricesSell->first()->price,
                    'pricebuy' => $material->pricesBuy->first()->price,
                    'material' => $material->id
                ];
            }
        }

        return \View::make('admin/models/index', array('jsMaterials' =>  json_encode($pass_materials), 'jsStones' =>  json_encode($pass_stones), 'jewels' => $jewels, 'models' => $models, 'prices' => $prices, 'stones' => $stones, 'materials' => $materials));
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
            'name' => 'required|unique:models,name',
            'jewel_id' => 'required|numeric|min:1',
            'stone_amount.*' => 'numeric|between:1,100',
            'stone_weight.*' => 'numeric|between:0.01,1000',
            'weight' => 'required|numeric|between:0.1,10000',
            'size'  => 'required|numeric|between:0.1,10000',
            'workmanship' => 'required|numeric|between:0.1,500000',
            'price' => 'required|numeric|between:0.1,500000',
            'material_id.*' => 'required',
            'retail_price_id.*' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $model = new Model();
        $model->name = $request->name;
        $model->jewel_id = $request->jewel_id;
        $model->weight = $request->weight;
        $model->size = $request->size;
        $model->workmanship = $request->workmanship;
        $model->price = $request->price;
        $model->totalStones =  $request->totalStones;
        $model->code = 'M'.unique_random('models', 'code', 7);

        if($request->website_visible == 'true'){
            $model->website_visible =  'yes';
        }else{
            $model->website_visible =  'no';
        }

        $model->save();

        if($request->stones){
            foreach($request->stones as $key => $stone){
                if($stone){
                    $model_stones = new ModelStone();
                    $model_stones->model_id = $model->id;
                    $model_stones->stone_id = $stone;
                    $model_stones->amount = $request->stone_amount[$key];
                    $model_stones->weight = $request->stone_weight[$key];
                    if($request->stone_flow[$key] == 'true'){
                        $model_stones->flow = 'yes';
                    }else{
                        $model_stones->flow = 'no';
                    }
                    
                    $model_stones->save();
                }
            }
        }

        $path = public_path('uploads/models/');
        
        File::makeDirectory($path, 0775, true, true);
        Storage::disk('public')->makeDirectory('models', 0775, true);

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
                

                $file_name = 'modelimage_'.uniqid().time().'.'.$ext;
            
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                file_put_contents(public_path('uploads/models/').$file_name, $data);

                Storage::disk('public')->put('models/'.$file_name, file_get_contents(public_path('uploads/models/').$file_name));

                $photo = new Gallery();
                $photo->photo = $file_name;
                $photo->model_id = $model->id;
                $photo->table = 'models';

                $photo->save();
            }
        }

        if($request->material_id){
            foreach($request->material_id as $key => $material){
                if($material){
                    $model_option = new ModelOption();
                    $model_option->model_id = $model->id;
                    $model_option->material_id = $material;
                    $model_option->retail_price_id = $request->retail_price_id[$key];
                    $model_option->default = $request->default_material[$key];
    
                    if($request->default_material[$key] == 'true'){
                        $model_option->default = "yes";
                    }else{
                        $model_option->default = "no";
                    }
    
                    $model_option->save();
                }
            }
        }

        if ($request->release_product == 'true') {
            $default = ModelOption::where([
                ['model_id', '=', $model->id],
                ['default', '=', 'yes']
            ])->first();

            $material = MaterialQuantity::where([
                ['material_id', $default->material_id],
                ['store_id', Auth::user()->getStore()->id]
            ])->first();

            if(!$material || $material->quantity < $request->weight){
                return Response::json(['errors' => ['using' => ['Няма достатъчна наличност от този материал.']]], 401);
            }

            $product = new Product();
            $product->name = $request->name;
            $product->model_id = $default->material_id;
            $product->jewel_id= $request->jewel_id;
            $product->weight = $request->weight;
            $product->material_id = $default->material_id;
            $product->material_type_id = $request->material_id;
            $product->retail_price_id = $default->retail_price_id;
            $product->size = $request->size;
            $product->workmanship = $request->workmanship;
            $product->price = $request->price;
            $product->code = unique_number('products', 'code', 7);
            $product->store_id = 1;
            $bar = '380'.unique_number('products', 'barcode', 7).'1'; 
            
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

            $product->website_visible =  'yes';
           
            
            $product->save();

            if($request->stones){
                foreach($request->stones as $key => $stone){
                    if($stone){
                        $product_stones = new ProductStone();
                        $product_stones->product_id = $product->id;
                        $product_stones->model_id = $model->id;
                        $product_stones->stone_id = $stone;
                        $product_stones->amount = $request->stone_amount[$key];
                        $product_stones->weight = $request->stone_weight[$key];
                        $product_stones->flow = $request->stone_flow[$key];

                        if($request->stone_flow[$key] == 'true'){
                            $product_stones->flow = 'yes';
                        }else{
                            $product_stones->flow = 'no';
                        }
                        $product_stones->save();
                    }
                }
            }

            $path = public_path('uploads/products/');
        
            File::makeDirectory($path, 0775, true, true);
            Storage::disk('public')->makeDirectory('models', 0775, true);

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
        }

        return Response::json(array('success' => View::make('admin/models/table',array('model'=>$model))->render()));
    }

     /**
     * Display all reviews
     */
    public function showReviews()
    {
        $reviews = Review::where([
            ['model_id', '!=', '']
        ])->get();

        if (count($reviews)) {
            return \View::make('admin.models_reviews.index', array('reviews'=>$reviews));
        } else {
            return redirect()->route('admin_models')->with('success', 'Съобщението ви беше изпратено успешно');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function show(Models $models)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $model)
    {
        $jewels = Jewel::take(env('SELECT_PRELOADED'))->get();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::take(env('SELECT_PRELOADED'))->get();
        $modelStones = $model->stones;
        $photos = Gallery::where(
            [
                ['table', '=', 'models'],
                ['model_id', '=', $model->id]
            ]
        )->get();

        $options = $model->options;

        $materials = Material::take(env('SELECT_PRELOADED'))->get();
        $pass_photos = array();        
        $pass_stones = array();
        
        foreach($stones as $stone){
            $pass_stones[] = [
                'value' => $stone->id,
                'label' => $stone->nomenclature->name.' ('.$stone->contour->name.', '.$stone->style->name.' )',
                'type'  => $stone->type,
                'price' => $stone->price
            ];
        }

        foreach($photos as $photo){
            $url =  Storage::get('public/models/'.$photo->photo);
            $ext_url = Storage::url('public/models/'.$photo->photo);

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


        $pass_materials = array();
        
        foreach($materials as $material){
            $pass_materials[] = [
                'value' => $material->id,
                'label' => $material->parent->name.' - '. $material->color.  ' - '  .$material->carat,
                'pricebuy' => $material->pricesBuy->first()['price'],
            ];
        }

        return \View::make('admin/models/edit', array('photos' => $photos, 'model' => $model, 'jewels' => $jewels, 'prices' => $prices, 'stones' => $stones, 'modelStones' => $modelStones, 'options' => $options, 'stones' => $stones, 'materials' => $materials, 'jsMaterials' =>  json_encode($pass_materials), 'jsStones' =>  json_encode($pass_stones), 'basephotos' => $pass_photos));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Model $model)
    {
        $jewels = Jewel::all();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::currentStore();

        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'jewel_id' => 'required|numeric|min:1',
            'stone_amount.*' => 'numeric|between:1,100',
            'stone_weight.*' => 'numeric|between:0.01,1000',
            'weight' => 'required|numeric|between:0.1,10000',
            'size'  => 'required|numeric|between:0.1,10000',
            'workmanship' => 'required|numeric|between:0.1,500000',
            'price' => 'required|numeric|between:0.1,500000',
            'material_id.*' => 'required',
            'retail_price_id.*' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }
        
        $model->name = $request->name;
        $model->jewel_id = $request->jewel_id;
        $model->price = $request->price;
        $model->workmanship = $request->workmanship;
        $model->weight = $request->weight;
        $model->totalStones =  $request->totalStones;
        $model->size = $request->size;

        if($request->website_visible == 'true'){
            $model->website_visible =  'yes';
        }else{
            $model->website_visible =  'no';
        }
        
        $model->save();

        $path = public_path('storage/models/');
        
        File::makeDirectory($path, 0775, true, true);

        $deleteStones = ModelStone::where('model_id', $model->id)->delete();

        if($request->stones){
            foreach($request->stones as $key => $stone){
                if($stone){
                    $model_stones = new ModelStone();
                    $model_stones->model_id = $model->id;
                    $model_stones->stone_id = $stone;
                    $model_stones->amount = $request->stone_amount[$key];
                    $model_stones->weight = $request->stone_weight[$key];
                    if($request->stone_flow[$key] == 'true'){
                        $model_stones->flow = 'yes';
                    }else{
                        $model_stones->flow = 'no';
                    }
                    $model_stones->save();
                }
            }
        }

        $deleteOptions = ModelOption::where('model_id', $model->id)->delete();

        if($request->material_id){
            foreach($request->material_id as $key => $material){
                if($material){
                    $model_option = new ModelOption();
                    $model_option->model_id = $model->id;
                    $model_option->material_id = $material;
                    $model_option->retail_price_id = $request->retail_price_id[$key];
                    $model_option->default = $request->default_material[$key];
    
                    if($request->default_material[$key] == 'true'){
                        $model_option->default = "yes";
                    }else{
                        $model_option->default = "no";
                    }
    
                    $model_option->save();
                }
            }
        }

        $file_data = $request->input('images'); 
        
        if($file_data){
            foreach($file_data as $img){
                $memi = substr($img, 5, strpos($img, ';')-5);
                
                $extension = explode('/',$memi);
                if($extension[1] == "svg+xml"){
                    $ext = 'svg';
                }else{
                    $ext = $extension[1];
                }         
                
                $file_name = 'modelimage_'.uniqid().time().'.'.$ext;

                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));

                file_put_contents(public_path('uploads/models/').$file_name, $data);

                Storage::disk('public')->put('models/'.$file_name, file_get_contents(public_path('uploads/models/').$file_name));

                $photo = new Gallery();
                $photo->photo = $file_name;
                $photo->model_id = $model->id;
                $photo->table = 'models';
                $photo->save();
            }
        }

        $model_photos = Gallery::where(
            [
                ['table', '=', 'models'],
                ['model_id', '=', $model->id]
            ]
        )->get();

        $photosHtml = '';
        
        foreach($model_photos as $photo){
            $photosHtml .= '
                <div class="image-wrapper">
                <div class="close"><span data-url="gallery/delete/'.$photo->id.'">&#215;</span></div>
                <img src="'.asset("uploads/models/" . $photo->photo).'" alt="" class="img-responsive" />
            </div>';
        }

        if ($request->release_product == 'true') {
            $default = ModelOption::where([
                ['model_id', '=', $model->id],
                ['default', '=', 'yes']
            ])->first();

            $material = MaterialQuantity::where([
                ['material_id', $default->material_id],
                ['store_id', Auth::user()->getStore()->id]
            ])->first();

            if(!$material || $material->quantity < $request->weight){
                return Response::json(['errors' => ['using' => ['Няма достатъчна наличност от този материал.']]], 401);
            }

            $product = new Product();
            $product->name = $request->name;
            $product->model_id = $default->material_id;
            $product->jewel_id= $request->jewel_id;
            $product->weight = $request->weight;
            $product->material_id = $default->$material_id;
            $product->material_type_id = $request->material_id;
            $product->retail_price_id = $default->retail_price_id;
            $product->size = $request->size;
            $product->workmanship = $request->workmanship;
            $product->price = $request->price;
            $product->code = 'P'.unique_random('products', 'code', 7);
            $product->store_id = 1;
            $bar = '380'.unique_number('products', 'barcode', 7).'1'; 
            
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

            $product->website_visible =  'yes';
           
            
            $product->save();

            if($request->stones){
                foreach($request->stones as $key => $stone){
                    if($stone){
                        $checkStone = Stone::find($stone);
                        
                        if($checkStone->amount < $request->stone_amount[$key]){
                            return Response::json(['errors' => ['stone_weight' => ['Няма достатъчна наличност от този камък.']]], 401);
                        }

                        $product_stones = new ProductStone();
                        $product_stones->product_id = $product->id;
                        $product_stones->model_id = $model->id;
                        $product_stones->stone_id = $stone;
                        $product_stones->amount = $request->stone_amount[$key];
                        $product_stones->weight = $request->stone_weight[$key];
                        $product_stones->flow = $request->stone_flow[$key];

                        if($request->stone_flow[$key] == 'true'){
                            $product_stones->flow = 'yes';
                        }else{
                            $product_stones->flow = 'no';
                        }
                        $product_stones->save();
                    }
                }
            }

            $path = public_path('uploads/products/');
        
            File::makeDirectory($path, 0775, true, true);
            Storage::disk('public')->makeDirectory('models', 0775, true);

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
        }

        return Response::json(array('ID' => $model->id, 'table' => View::make('admin/models/table',array('model' => $model, 'jewels' => $jewels, 'prices' => $prices, 'stones' => $stones))->render(), 'photos' => $photosHtml));
    }

    public function select_search(Request $request){
        $query = Model::select('*');

        $models_new = new Model();
        $models = $models_new->filterModels($request, $query);
        $models = $models->paginate(env('RESULTS_PER_PAGE'));

        $pass_models = array();

        foreach($models as $model){
            $pass_models[] = [
                'attributes' => [
                    'value' => $model->id,
                    'label' => $model->name
                ]
            ];
        }

        return json_encode($pass_models, JSON_UNESCAPED_SLASHES );
    }
    
    public function filter(Request $request){
        $query = Model::select('*');

        $models_new = new Model();
        $models = $models_new->filterModels($request, $query)->paginate(env('RESULTS_PER_PAGE'));
        
        $response = '';
        foreach($models as $model){
            $response .= \View::make('admin/models/table', array('model' => $model, 'listType' => $request->listType));
        }

        $models->setPath('');
        $response .= $models->appends(Input::except('page'))->links();

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $model)
    {
        if($model){
            $using = Product::where('model_id', $model->id)->count();
            
            if($using){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{
                $model->photos()->delete();
                $model->delete();
                
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}