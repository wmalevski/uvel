<?php

namespace App\Http\Controllers;

use App\StoneStyle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Support\Facades\View;

class StoneStyleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $styles = StoneStyle::all();

        return \View::make('admin/stone_styles/index', array('styles' => $styles));
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
            'name' => 'required|unique:stone_styles',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $style = StoneStyle::create($request->all());
        return Response::json(array('success' => View::make('admin/stone_styles/table',array('style'=>$style))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StoneStyle  $stoneStyle
     * @return \Illuminate\Http\Response
     */
    public function show(StoneStyle $stoneStyle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StoneStyle  $stoneStyle
     * @return \Illuminate\Http\Response
     */
    public function edit(StoneStyle $stoneStyle)
    {
        return \View::make('admin/stone_styles/edit', array('style' => $stoneStyle));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StoneStyle  $stoneStyle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoneStyle $stoneStyle)
    {
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $stoneStyle->name = $request->name;

        $stoneStyle->save();

        return Response::json(array('ID' => $stoneStyle->id, 'table' => View::make('admin/stone_styles/table', array('style' => $stoneStyle))->render()));
    }

    public function select_search(Request $request){
        $query = StoneStyle::select('*');

        $styles_new = new StoneStyle();
        $styles = $styles_new->filterStyles($request, $query);
        $styles = $styles->paginate(\App\Setting::where('key','per_page')->get()[0]->value);

        $pass_styles = array();

        foreach($styles as $style){
            $pass_styles[] = [
                'attributes' => [
                    'value' => $style->id,
                    'label' => $style->name
                ]
            ];
        }

        return json_encode($pass_styles, JSON_UNESCAPED_SLASHES );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StoneStyle  $stoneStyle
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoneStyle $stoneStyle)
    {
        if($stoneStyle){
            if($stoneStyle->stones->count()){
                return Response::json(['errors' => ['using' => ['Този контур се използва от системата и не може да бъде изтрит.']]], 401);
            }else {
                $stoneStyle->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
