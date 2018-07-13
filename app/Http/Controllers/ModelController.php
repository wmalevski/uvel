<?php

namespace App\Http\Controllers;

use App\Model;
use App\Jewel;
use App\Price;
use App\Stone;
use App\ModelStone;
use App\Product;
use App\ProductStone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Gallery;
use File;

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

        $pass_stones = array();
        
        foreach($stones as $stone){
            $pass_stones[] = [
                'value' => $stone->id,
                'label' => $stone->name.' ('.\App\StoneContour::withTrashed()->find($stone->contour)->name.', '.\App\StoneSize::withTrashed()->find($stone->size)->name.' )'
            ];
        }

        return \View::make('admin/models/index', array('jsStones' =>  json_encode($pass_stones), 'jewels' => $jewels, 'models' => $models, 'prices' => $prices, 'stones' => $stones));
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
            'jewel' => 'required',
            'retail_price' => 'required',
            'stone_amount.*' => 'nullable|numeric|between:1,100',
            'weight' => 'required|numeric|between:0.1,10000',
            'size'  => 'required|numeric|between:0.1,10000',
            'workmanship' => 'required|numeric|between:0.1,500000',
            'price' => 'required|numeric|between:0.1,500000'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $model = Models::create($request->all());

        foreach($request->stones as $key => $stone){
            if($stone){
                $model_stones = new ModelStone();
                $model_stones->model = $model->id;
                $model_stones->stone = $stone;
                $model_stones->amount = $request->stone_amount[$key];
                $model_stones->save();
            }
        }

        $path = public_path('uploads/models/');
        
        File::makeDirectory($path, 0775, true, true);

        $file_data = $request->input('images'); 
        
        foreach($file_data as $img){
            $file_name = 'productimage_'.uniqid().time().'.png';
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
            file_put_contents(public_path('uploads/models/').$file_name, $data);

            $photo = new Gallery();
            $photo->photo = $file_name;
            $photo->row_id = $model->id;
            $photo->table = 'models';

            $photo->save();
        }

        if ($request->release_product == true) {
            $product = new Product();
            $product->id = $request->id;
            $product->name = $request->name;
            $product->model = $model->id;
            $product->jewel_type = $request->jewel;
            $product->weight = $request->weight;
            $product->retail_price = $request->retail_price;
            $product->wholesale_price  = $request->wholesale_price;
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

            foreach($request->stones as $key => $stone){
                if($stone){
                    $product_stones = new ProductStone();
                    $product_stones->product = $product->id;
                    $product_stones->model = $model->id;
                    $product_stones->stone = $stone;
                    $product_stones->amount = $request->stone_amount[$key];
                    $product_stones->save();
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
     * @param  \App\Model  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $model)
    {
        $model = Model::find($model);
        $jewels = Jewel::all();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::all();
        $modelStones = ModelStone::where('model', $model->id)->get();
        $photos = Gallery::where(
            [
                ['table', '=', 'models'],
                ['row_id', '=', $model->id]
            ]
        )->get();

        //dd($modelStones);
        
        //return Response::json(array('success' => View::make('admin/models/edit',array('model' => $model, 'jewels' => $jewels, 'prices' => $prices, 'stones' => $stones))->render()));

        //$product = Products_others::find($product);
        //$types = Products_others_types::all();

        return \View::make('admin/models/edit', array('photos' => $photos, 'model' => $model, 'jewels' => $jewels, 'prices' => $prices, 'stones' => $stones, 'modelStones' => $modelStones));
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
        $model = Model::find($model);

        $jewels = Jewel::all();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::all();
        
        $model->name = $request->name;
        $model->jewel = $request->jewel;
        $model->retail_price = $request->retail_price;
        $model->wholesale_price = $request->wholesale_price;
        $model->weight = $request->weight;
        
        $model->save();

        $path = public_path('uploads/models/');
        
        File::makeDirectory($path, 0775, true, true);

        $deleteStones = ModelStone::where('model', $model->id)->delete();

        foreach($request->stones as $key => $stone){
            if($stone){
                $model_stones = new ModelStone();
                $model_stones->model = $model->id;
                $model_stones->stone = $stone;
                $model_stones->amount = $request->stone_amount[$key];
                $model_stones->save();
            }
        }

        $file_data = $request->input('images'); 
        
        foreach($file_data as $img){
            $file_name = 'modelimage_'.uniqid().time().'.png';
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
            file_put_contents(public_path('uploads/models/').$file_name, $data);

            $photo = new Gallery();
            $photo->photo = $file_name;
            $photo->row_id = $model->id;
            $photo->table = 'models';

            $photo->save();
        }

        $model_photos = Gallery::where(
            [
                ['table', '=', 'models'],
                ['row_id', '=', $model->id]
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
    public function destroy(Models $model)
    {
        $model = Model::find($model);
        
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