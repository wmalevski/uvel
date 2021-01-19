<?php

namespace App\Http\Controllers;

use App\StoneSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Support\Facades\View;

class StoneSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = StoneSize::all();

        return \View::make('admin/stone_sizes/index', array('sizes' => $sizes));
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
            'name' => 'required|unique:stone_sizes',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $size = new StoneSize();
        $response = $size->create($request->all());

        return Response::json(array('success' => View::make('admin/stone_sizes/table',array('size'=>$response))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StoneSize  $stoneSize
     * @return \Illuminate\Http\Response
     */
    public function show(StoneSize $stoneSize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StoneSize  $stoneSize
     * @return \Illuminate\Http\Response
     */
public function edit(StoneSize $stoneSize)
    {
        return \View::make('admin/stone_sizes/edit', array('size' => $stoneSize));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StoneSize  $stoneSize
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoneSize $stoneSize)
    {
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $stoneSize->name = $request->name;

        $stoneSize->save();

        return Response::json(array('ID' => $stoneSize->id, 'table' => View::make('admin/stone_sizes/table', array('size' => $stoneSize))->render()));
    }

    public function select_search(Request $request){
        $query = StoneSize::select('*');

        $sizes_new = new Stonesize();
        $sizes = $sizes_new->filterSizes($request, $query);
        $sizes = $sizes->paginate(\App\Setting::where('key','per_page')->get()[0]->value);

        $pass_sizes = array();

        foreach($sizes as $size){
            $pass_sizes[] = [
                'attributes' => [
                    'value' => $size->id,
                    'label' => $size->name
                ]
            ];
        }

        return json_encode($pass_sizes, JSON_UNESCAPED_SLASHES );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StoneSize  $stoneSize
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoneSize $stoneSize)
    {
        if($stoneSize){
            if($stoneSize->stones->count()){
                return Response::json(['errors' => ['using' => ['Този контур се използва от системата и не може да бъде изтрит.']]], 401);
            }else {
                $stoneSize->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
