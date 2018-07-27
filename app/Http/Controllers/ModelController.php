<?php

namespace App\Http\Controllers;

use App\Model;
use App\Jewel;
use App\Price;
use App\Stone;
use App\ModelStone;
use App\Product;
use App\ProductStone;
use App\Material;
use App\MaterialQuantity;
use App\ModelOption;
use App\Gallery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;
use File;
use Auth;

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
        $jewels = Jewel::all();
        $prices = Price::all();
        $stones = Stone::all();
        $materials = MaterialQuantity::where('store_id', 1)->get();
        $pass_stones = array();
        
        foreach($stones as $stone){
            $pass_stones[] = [
                'value' => $stone->id,
                'label' => $stone->name.' ('.$stone->contour->name.', '.$stone->style->name.' )'
            ];
        }

        $pass_materials = array();
        
        foreach($materials as $material){
            $pass_materials[] = [
                'value' => $material->id,
                'label' => $material->material->parent->name.' - '. $material->material->parent->color.  ' - '  .$material->material->parent->carat,
                'pricebuy' => $material->material->pricesBuy->first()->price,
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
            'jewel_id' => 'required',
            'stone_amount.*' => 'numeric|between:1,100',
            'stone_weight.*' => 'numeric|between:1,100',
            'weight' => 'required|numeric|between:0.1,10000',
            'size'  => 'required|numeric|between:0.1,10000',
            'workmanship' => 'required|numeric|between:0.1,500000',
            'price' => 'required|numeric|between:0.1,500000'
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
        $model->save();

        if($request->stones){
            foreach($request->stones as $key => $stone){
                if($stone){
                    $model_stones = new ModelStone();
                    $model_stones->model_id = $model->id;
                    $model_stones->stone_id = $stone;
                    $model_stones->amount = $request->stone_amount[$key];
                    $model_stones->weight = $request->stone_weight[$key];
                    $model_stones->flow = $request->stone_flow[$key];
                    $model_stones->save();
                }
            }
        }

        $path = public_path('uploads/models/');
        
        File::makeDirectory($path, 0775, true, true);

        $file_data = $request->input('images'); 
        
        if($file_data){
            foreach($file_data as $img){
                $file_name = 'productimage_'.uniqid().time().'.png';
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                file_put_contents(public_path('uploads/models/').$file_name, $data);
    
                $photo = new Gallery();
                $photo->photo = $file_name;
                $photo->model_id = $model->id;
                $photo->table = 'models';
    
                $photo->save();
            }
        }
        
        if($request->material){
            foreach($request->material as $key => $material){
                if($material){
                    $model_option = new ModelOption();
                    $model_option->model_id = $model->id;
                    $model_option->material_id = $material;
                    $model_option->retail_price_id = $request->retail_price[$key];
                    $model_option->wholesale_price_id = $request->wholesale_price[$key];
                    $model_option->default = $request->default_material[$key];
    
                    if($request->default_material[$key] == true){
                        $model_option->default = "yes";
                    }else{
                        $model_option->default = "no";
                    }
    
                    $model_option->save();
                }
            }
        }

        if ($request->release_product == true) {
            $default = ModelOption::where([
                ['model_id', '=', $model->id],
                ['default', '=', 'yes']
            ])->first();

            $product = new Product();
            $product->name = $request->name;
            $product->model_id = $model->id;
            $product->jewel_id= $request->jewel_id;
            $product->weight = $request->weight;
            $product->material_id = $default->material_id;
            $product->retail_price_id = $default->retail_price_id;
            $product->wholesale_price_id  = $default->wholesale_price_id;
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
                        $product_stones = new ProductStone();
                        $product_stones->product_id = $product->id;
                        $product_stones->model_id = $model->id;
                        $product_stones->stone_id = $stone;
                        $product_stones->amount = $request->stone_amount[$key];
                        $product_stones->weight = $request->stone_weight[$key];
                        $product_stones->flow = $request->stone_flow[$key];

                        if($request->stone_flow[$key] == true){
                            $model_stones->flow = 'yes';
                        }else{
                            $model_stones->flow = 'no';
                        }
                        $product_stones->save();
                    }
                }
            }

            foreach($file_data as $img){
                $file_name = 'productimage_'.uniqid().time().'.png';
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                file_put_contents(public_path('uploads/products/').$file_name, $data);
    
                $photo = new Gallery();
                $photo->photo = $file_name;
                $photo->model_id = $product->id;
                $photo->table = 'products';
    
                $photo->save();
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
     * @param  \App\Model  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $model)
    {
        $model = Model::find($model)->first();
        $jewels = Jewel::all();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::all();
        $modelStones = $model->stones;
        $photos = Gallery::where(
            [
                ['table', '=', 'models'],
                ['model_id', '=', $model->id]
            ]
        )->get();

        $options = $model->options;

        $materials = MaterialQuantity::where('store_id', Auth::user()->getStore())->get();
        
        $pass_stones = array();
        
        foreach($stones as $stone){
            $pass_stones[] = [
                'value' => $stone->id,
                'label' => $stone->name.' ('.$stone->contour->name.', '.$stone->style->name.' )'
            ];
        }

        $pass_materials = array();
        
        foreach($materials as $material){
            $pass_materials[] = [
                'value' => $material->id,
                'label' => $material->material->parent->name.' - '. $material->material->parent->color.  ' - '  .$material->material->parent->carat,
                'pricebuy' => $material->material->pricesBuy->first()->price,
                'material' => $material->material
            ];
        }

        return \View::make('admin/models/edit', array('photos' => $photos, 'model' => $model, 'jewels' => $jewels, 'prices' => $prices, 'stones' => $stones, 'modelStones' => $modelStones, 'options' => $options, 'stones' => $stones, 'materials' => $materials, 'jsMaterials' =>  json_encode($pass_materials), 'jsStones' =>  json_encode($pass_stones)));
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
        //$model = Model::find($model);

        $jewels = Jewel::all();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::all();

        $validator = Validator::make( $request->all(), [
            'jewel_id' => 'required',
            'stone_amount.*' => 'numeric|between:1,100',
            'stone_weight.*' => 'numeric|between:1,100',
            'weight' => 'required|numeric|between:0.1,10000',
            'size'  => 'required|numeric|between:0.1,10000',
            'workmanship' => 'required|numeric|between:0.1,500000',
            'price' => 'required|numeric|between:0.1,500000'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }
        
        $model->name = $request->name;
        $model->jewel_id = $request->jewel_id;
        $model->price = $request->price;
        $model->workmanship = $request->workmanship;
        $model->weight = $request->weight;
        
        $model->save();

        $path = public_path('uploads/models/');
        
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
                    if($request->stone_flow[$key] == true){
                        $model_stones->flow = 'yes';
                    }else{
                        $model_stones->flow = 'no';
                    }
                    $model_stones->save();
                }
            }
        }
        

        $deleteOptions = ModelOption::where('model_id', $model->id)->delete();

        if($request->material){
            foreach($request->material as $key => $material){
                if($material){
                    $model_option = new ModelOption();
                    $model_option->model_id = $model->id;
                    $model_option->material_id = $material;
                    $model_option->retail_price_id = $request->retail_price[$key];
                    $model_option->wholesale_price_id = $request->wholesale_price[$key];
                    $model_option->default = $request->default_material[$key];
    
                    if($request->default_material[$key] == true){
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
                $file_name = 'modelimage_'.uniqid().time().'.png';
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                file_put_contents(public_path('uploads/models/').$file_name, $data);
    
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
     * @param  \App\Model  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $model)
    {
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