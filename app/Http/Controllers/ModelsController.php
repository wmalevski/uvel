<?php

namespace App\Http\Controllers;

use App\Models;
use App\Jewels;
use App\Prices;
use App\Stones;
use App\Model_stones;
use App\Product;
use App\Product_stones;
use App\Materials;
use App\Materials_quantity;
use App\ModelOptions;
use App\Gallery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use File;
use Auth;
use Response;
use Uuid;
use Storage;

class ModelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Models::all();
        $jewels = Jewels::all();
        $prices = Prices::all();
        $stones = Stones::all();
        $materials = Materials_quantity::where('store', Auth::user()->getStore())->get();

        $pass_stones = array();
        
        foreach($stones as $stone){
            $pass_stones[] = [
                'value' => $stone->id,
                'label' => $stone->name.' ('.\App\Stone_contours::withTrashed()->find($stone->contour)->name.', '.\App\Stone_sizes::withTrashed()->find($stone->size)->name.' )'
            ];
        }

        $pass_materials = array();
        
        foreach($materials as $material){
            $pass_materials[] = [
                'value' => $material->id,
                'label' => Materials::withTrashed()->find($material->material)->name.' - '. Materials::withTrashed()->find($material->material)->color.  ' - '  .Materials::withTrashed()->find($material->material)->carat,
                'pricebuy' => Prices::withTrashed()->where('material', $material->material)->where('type', 'buy')->first()->price,
                'material' => $material->material
            ];
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
            'jewel' => 'required|numeric|min:1',
            'stone_amount.*' => 'numeric|between:1,100',
            'stone_weight.*' => 'numeric|between:0.01,1000',
            'weight' => 'required|numeric|between:0.1,10000',
            'size'  => 'required|numeric|between:0.1,10000',
            'workmanship' => 'required|numeric|between:0.1,500000',
            'price' => 'required|numeric|between:0.1,500000',
            'material.*' => 'required',
            'retail_price.*' => 'required',
            'wholesale_price.*' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $model = new Models();
        $model->name = $request->name;
        $model->jewel = $request->jewel;
        $model->weight = $request->weight;
        $model->size = $request->size;
        $model->workmanship = $request->workmanship;
        $model->price = $request->price;
        $model->totalStones =  $request->totalStones;
        $model->save();

        if($request->stones){
            foreach($request->stones as $key => $stone){
                if($stone){
                    $model_stones = new Model_stones();
                    $model_stones->model = $model->id;
                    $model_stones->stone = $stone;
                    $model_stones->amount = $request->stone_amount[$key];
                    $model_stones->weight = $request->stone_weight[$key];
                    if($request->stone_flow[$key] == true){
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
                

                $file_name = 'productimage_'.uniqid().time().'.'.$ext;
            
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

        foreach($request->material as $key => $material){
            if($material){
                $model_option = new ModelOptions();
                $model_option->model = $model->id;
                $model_option->material = $material;
                $model_option->retail_price = $request->retail_price[$key];
                $model_option->wholesale_price = $request->wholesale_price[$key];
                $model_option->default = $request->default_material[$key];

                if($request->default_material[$key] == true){
                    $model_option->default = "yes";
                }else{
                    $model_option->default = "no";
                }

                $model_option->save();
            }
        }

        if ($request->release_product === true) {
            $default = ModelOptions::where([
                ['model', '=', $model->id],
                ['default', '=', 'yes']
            ])->first();

            $product = new Product();
            $product->name = $request->name;
            $product->model = $model->id;
            $product->jewel_type = $request->jewel;
            $product->weight = $request->weight;
            $product->material = $default->material;
            $product->retail_price = $default->retail_price;
            $product->wholesale_price  = $default->wholesale_price;
            $product->size = $request->size;
            $product->workmanship = $request->workmanship;
            $product->price = $request->price;
            $product->code = unique_number('products', 'code', 7);

            $barcode = str_replace('-', '', $product->id);

            $barcode = pack('h*', $barcode);
            $barcode = unpack('L*', $barcode);

            $newbarcode = '';

            foreach($barcode as $bars){
                $newbarcode .= $bars;
            }

            $product->barcode = '380'.unique_number('products', 'barcode', 7).'1';
            
            $product->save();

            if($request->stones){
                foreach($request->stones as $key => $stone){
                    if($stone){
                        $product_stones = new Product_stones();
                        $product_stones->product = $product->id;
                        $product_stones->model = $model->id;
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
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function edit(Models $models, $model)
    {
        $model = Models::find($model);
        $jewels = Jewels::all();
        $prices = Prices::where('type', 'sell')->get();
        $stones = Stones::all();
        $modelStones = Model_stones::where('model', $model->id)->get();
        $photos = Gallery::where(
            [
                ['table', '=', 'models'],
                ['model_id', '=', $model->id]
            ]
        )->get();

        $options = ModelOptions::where('model', $model->id)->get();

        $materials = Materials_quantity::where('store', Auth::user()->getStore())->get();

        $pass_photos = array();
        
        $pass_stones = array();
        
        foreach($stones as $stone){
            $pass_stones[] = [
                'value' => $stone->id,
                'label' => $stone->name.' ('.\App\Stone_contours::withTrashed()->find($stone->contour)->name.', '.\App\Stone_sizes::withTrashed()->find($stone->size)->name.' )'
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
                'label' => Materials::withTrashed()->find($material->material)->name.' - '. Materials::withTrashed()->find($material->material)->color.  ' - '  .Materials::withTrashed()->find($material->material)->carat,
                'pricebuy' => Prices::withTrashed()->where('material', $material->material)->where('type', 'buy')->first()->price,
                'material' => $material->material
            ];
        }

        return \View::make('admin/models/edit', array('photos' => $photos, 'model' => $model, 'jewels' => $jewels, 'prices' => $prices, 'stones' => $stones, 'modelStones' => $modelStones, 'options' => $options, 'stones' => $stones, 'materials' => $materials, 'jsMaterials' =>  json_encode($pass_materials), 'jsStones' =>  json_encode($pass_stones), 'basephotos' => $pass_photos));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Models $models, $model)
    {
        $model = Models::find($model);

        $jewels = Jewels::all();
        $prices = Prices::where('type', 'sell')->get();
        $stones = Stones::all();

        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'jewel' => 'required|numeric|min:1',
            'stone_amount.*' => 'numeric|between:1,100',
            'stone_weight.*' => 'numeric|between:0.01,1000',
            'weight' => 'required|numeric|between:0.1,10000',
            'size'  => 'required|numeric|between:0.1,10000',
            'workmanship' => 'required|numeric|between:0.1,500000',
            'price' => 'required|numeric|between:0.1,500000',
            'material.*' => 'required',
            'retail_price.*' => 'required',
            'wholesale_price.*' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }
        
        $model->name = $request->name;
        $model->jewel = $request->jewel;
        $model->price = $request->price;
        $model->workmanship = $request->workmanship;
        $model->weight = $request->weight;
        $model->totalStones =  $request->totalStones;
        $model->size = $request->size;
        
        $model->save();

        $path = public_path('storage/models/');
        
        File::makeDirectory($path, 0775, true, true);

        $deleteStones = Model_stones::where('model', $model->id)->delete();

        if($request->stones){
            foreach($request->stones as $key => $stone){
                if($stone){
                    $model_stones = new Model_stones();
                    $model_stones->model = $model->id;
                    $model_stones->stone = $stone;
                    $model_stones->amount = $request->stone_amount[$key];
                    $model_stones->weight = $request->stone_weight[$key];
                    if($request->stone_flow[$key] == true){
                        $model_stones->flow = 'yes';
                    }else{
                        $model_stones->flow = 'no';
                    }
                    $model_stones->save();
                }
            }
        }

        $deleteOptions = ModelOptions::where('model', $model->id)->delete();

        foreach($request->material as $key => $material){
            if($material){
                $model_option = new ModelOptions();
                $model_option->model = $model->id;
                $model_option->material = $material;
                $model_option->retail_price = $request->retail_price[$key];
                $model_option->wholesale_price = $request->wholesale_price[$key];
                $model_option->default = $request->default_material[$key];

                if($request->default_material[$key] == true){
                    $model_option->default = "yes";
                }else{
                    $model_option->default = "no";
                }

                $model_option->save();
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

        return Response::json(array('ID' => $model->id, 'table' => View::make('admin/models/table',array('model' => $model, 'jewels' => $jewels, 'prices' => $prices, 'stones' => $stones))->render(), 'photos' => $photosHtml));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function destroy(Models $models, $model)
    {
        $model = Models::find($model);
        
        if($model){
            $using = Product::where('model', $model->id)->count();
            
            if($using){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{
                $model->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
