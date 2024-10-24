<?php

namespace App\Http\Controllers;

use App\Stone;
use App\StoneStyle;
use App\StoneContour;
use App\StoneSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Support\Facades\View;
use Uuid;
use App\Gallery;
use File;
use App\ModelStone;
use App\ProductStone;
use App\Store;
use Storage;
use App\Nomenclature;
use Auth;
use Illuminate\Support\Facades\Cache;

class StoneController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $stones = Stone::take(env('SELECT_PRELOADED'))->orderBy('id','DESC')->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);
        // $stone_sizes = StoneSize::take(env('SELECT_PRELOADED'))->get();
        // $stone_contours = StoneContour::take(env('SELECT_PRELOADED'))->get();
        // $stone_styles = StoneStyle::take(env('SELECT_PRELOADED'))->get();
        // $stores = Store::take(env('SELECT_PRELOADED'))->get();
        // $nomenclatures = Nomenclature::take(env('SELECT_PRELOADED'))->get();
        $preloadCount = env('SELECT_PRELOADED');

        // Eager load related data in a single query if necessary (this depends on your actual use case)
        $stone_sizes = Cache::remember('stone_sizes', 60, function () use ($preloadCount) {
            return StoneSize::take($preloadCount)->get();
        });

        $stone_contours = Cache::remember('stone_contours', 60, function () use ($preloadCount) {
            return StoneContour::take($preloadCount)->get();
        });

        $stone_styles = Cache::remember('stone_styles', 60, function () use ($preloadCount) {
            return StoneStyle::take($preloadCount)->get();
        });

        $stores = Cache::remember('stores', 60, function () use ($preloadCount) {
            return Store::take($preloadCount)->get();
        });

        $nomenclatures = Cache::remember('nomenclatures', 60, function () use ($preloadCount) {
            return Nomenclature::take($preloadCount)->get();
        });

        return view('admin.stones.index', compact('stones', 'stone_sizes', 'stone_contours', 'stone_styles', 'stores', 'nomenclatures'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator = Validator::make( $request->all(), [
            'nomenclature_id' => 'required',
            'type' => 'required',
            'weight' => 'required|numeric|between:0.001,100000',
            'carat' => 'required|numeric',
            'size_id' => 'required|numeric',
            'style_id' => 'required',
            'contour_id' => 'required',
            'price' => 'required|numeric|regex:/^\d*(\.\d{1,3})?$/',
            'amount' => 'required|numeric|between:0.01,100000',
            'store_id' => 'required'
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $stone = Stone::where([
            ['nomenclature_id', '=',  $request->nomenclature_id],
            ['type', '=', $request->type],
            ['weight', '=', $request->weight],
            ['carat', '=', $request->carat],
            ['size_id', '=', $request->size_id],
            ['style_id', '=', $request->style_id],
            ['contour_id', '=', $request->contour_id],
            ['price', '=', $request->price],
            ['store_id', '=', $request->store_id]
            ]
        )->first();

        if ($stone) {
            $stone->amount += $request->amount;
            $stone->save();
        }
        else {
            $stone = Stone::create($request->all());

            $path = public_path('uploads/stones/');

            File::makeDirectory($path, 0775, true, true);
            Storage::disk('public')->makeDirectory('stones', 0775, true);

            $file_data = $request->input('images');
            if ($file_data) {
                foreach ($file_data as $img) {
                    $file_name = 'productimage_' . uniqid() . time() . '.png';
                    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                    file_put_contents(public_path('uploads/stones/') . $file_name, $data);

                    Storage::disk('public')->put('stones/' . $file_name, file_get_contents(public_path('uploads/stones/') . $file_name));

                    $photo = new Gallery();
                    $photo->photo = $file_name;
                    $photo->stone_id = $stone->id;
                    $photo->table = 'stones';

                    $photo->save();
                }
            }
        }

        return Response::json(array('success' => View::make('admin/stones/table',array('stone'=>$stone))->render()));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stone  $stone
     * @return \Illuminate\Http\Response
     */
    public function edit(Stone $stone){
        $stone_sizes = StoneSize::take(env('SELECT_PRELOADED'))->get();
        $stone_contours = StoneContour::take(env('SELECT_PRELOADED'))->get();
        $stone_styles = StoneStyle::take(env('SELECT_PRELOADED'))->get();
        $stores = Store::take(env('SELECT_PRELOADED'))->get();
        $nomenclatures = Nomenclature::take(env('SELECT_PRELOADED'))->get();
        $stone_photos = Gallery::where(
            [
                ['table', '=', 'stones'],
                ['stone_id', '=', $stone->id]
            ]
        )->get();

        return \View::make('admin/stones/edit', array('stone' => $stone, 'stone_sizes' => $stone_sizes, 'stone_contours' => $stone_contours, 'stone_styles' => $stone_styles, 'stone_photos' => $stone_photos, 'stores' => $stores, 'nomenclatures' => $nomenclatures));
    }

    public function topUp(Request $request, Stone $stone){
        $validator = Validator::make( $request->all(), [
            'amount' => 'required|numeric|between:1,100000'
        ]);

        if($validator->fails()){
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $stone->amount += $request->amount;
        $stone->save();

        $stone_photos = Gallery::where(array(
            array('table', '=', 'stones'),
            array('stone_id', '=', $stone->id)
        ))->get();

        $photosHtml = '';

        foreach($stone_photos as $photo){
            $photosHtml .= '<div class="image-wrapper">
                <div class="close"><span data-url="gallery/delete/'.$photo->id.'">&#215;</span></div>
                <img src="'.asset("uploads/stones/" . $photo->photo).'" alt="" class="img-responsive" />
            </div>';
        }

        return Response::json(array('ID' => $stone->id, 'table' => View::make('admin/stones/table',array('stone'=>$stone))->render(), 'photos' => $photosHtml));
    }

    public function decreaseQnty(Request $request, Stone $stone){
        $validator = Validator::make( $request->all(), [
            'amount' => 'required|numeric|between:1,100000'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $stone->amount -= $request->amount;

        if($stone->amount < 0) {
            return Response::json(['errors' => ['using' => ['Камъните не могат да бъдат отрицателна бройка.']]], 401);
        } else {
            $stone->save();
        }

        $stone_photos = Gallery::where(
            [
                ['table', '=', 'stones'],
                ['stone_id', '=', $stone->id]
            ]
        )->get();

        $photosHtml = '';

        foreach($stone_photos as $photo){
            $photosHtml .= '
            <div class="image-wrapper">
            <div class="close"><span data-url="gallery/delete/'.$photo->id.'">&#215;</span></div>
            <img src="'.asset("uploads/stones/" . $photo->photo).'" alt="" class="img-responsive" />
        </div>';
        }

        return Response::json(array('ID' => $stone->id, 'table' => View::make('admin/stones/table',array('stone'=>$stone))->render(), 'photos' => $photosHtml));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stone  $stone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stone $stone){
        $validator = Validator::make( $request->all(), [
            'nomenclature_id' => 'required',
            'type' => 'required',
            'weight' => 'required|numeric|between:0.001,100000',
            'carat' => 'required|numeric',
            'size_id' => 'required|numeric',
            'style_id' => 'required',
            'contour_id' => 'required',
            'price' => 'required|numeric|regex:/^\d*(\.\d{1,3})?$/',
            'amount' => 'required|numeric|between:0.01,100000',
            'store_id' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $stone->nomenclature_id = $request->nomenclature_id;
        $stone->type = $request->type;
        $stone->weight = $request->weight;
        $stone->carat = $request->carat;
        $stone->contour_id = $request->contour_id;
        $stone->style_id = $request->style_id;
        $stone->size_id = $request->size_id;
        $stone->amount = $request->amount;
        $stone->price = $request->price;
        $stone->store_id = $request->store_id;

        $stone->save();

        $file_data = $request->input('images');

        $path = public_path('uploads/stones/');

        File::makeDirectory($path, 0775, true, true);

        if($file_data){
            foreach($file_data as $img){
                $file_name = 'stoneimage_'.uniqid().time().'.png';
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                file_put_contents(public_path('uploads/stones/').$file_name, $data);

                Storage::disk('public')->put('stones/'.$file_name, file_get_contents(public_path('uploads/stones/').$file_name));

                $photo = new Gallery();
                $photo->photo = $file_name;
                $photo->stone_id = $stone->id;
                $photo->table = 'stones';

                $photo->save();
            }
        }

        $stone_photos = Gallery::where(
            [
                ['table', '=', 'stones'],
                ['stone_id', '=', $stone->id]
            ]
        )->get();

        $photosHtml = '';

        foreach($stone_photos as $photo){
            $photosHtml .= '
                <div class="image-wrapper">
                <div class="close"><span data-url="gallery/delete/'.$photo->id.'">&#215;</span></div>
                <img src="'.asset("uploads/stones/" . $photo->photo).'" alt="" class="img-responsive" />
            </div>';
        }

        return Response::json(array('ID' => $stone->id, 'table' => View::make('admin/stones/table',array('stone'=>$stone))->render(), 'photos' => $photosHtml));
    }

    public function select_search(Request $request, Stone $stone){
        $search = $request->search ?? $request->byName;
        return $stone->searchQuery($search);
    }

    public function filter(Request $request){
        $query = Stone::select('*');

        $stones_new = new Stone();
        $stones = $stones_new->filterStones($request, $query);
        $stones = $stones->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $response = '';
        foreach($stones as $stone){
            $response .= \View::make('admin/stones/table', array('stone' => $stone, 'listType' => $request->listType));
        }

        $stones->setPath('');
        $response .= $stones->appends(request()->except('page'))->links();

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stone  $stone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stone $stone){
        if($stone){
            $usingModel = $stone->modelStones->count();
            $usingProduct = $stone->productStones->count();

            if($usingModel || $usingProduct){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{
                $stone->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
