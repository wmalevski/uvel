<?php

namespace App\Http\Controllers;

use Auth;
use App\MaterialQuantity;
use App\Material;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;
use App\MaterialTravelling;

class MaterialQuantityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MaterialTravelling $travelling)
    {
        //$materials = Materials_quantity::where('store', Auth::user()->store)->get();
        //$stores = Store::where('id', '!=', Auth::user()->store)->get();
        $materials = MaterialQuantity::all();
        $stores = Store::all();
        $materials_types = Material::all();
        
        return \View::make('admin/materials_quantity/index', array('materials' => $materials, 'types' => $materials_types, 'stores' => $stores, 'travelling' => $travelling::current()));
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
            'material_id' => 'required',
            'quantity' => 'required',
            'store_id' => 'required'
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $checkQuantity = MaterialQuantity::where([
            ['material_id', '=', $request->material_id],
            ['store_id', '=', $request->store_id]
            
        ])->first();

        if($checkQuantity){
            return Response::json(['errors' => ['using' => ['Вече имате добавена наличност от този материал, можете да я редактирате..']]], 401);
        }

        $material = MaterialQuantity::create($request->all());

        return Response::json(array('success' => View::make('admin/materials_quantity/table',array('material'=>$material))->render()));
    }

    public function sendMaterial(Request $request){
        return Response::json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaterialQuantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialQuantity $materialQuantity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaterialQuantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialQuantity $materialQuantity)
    {
        $stores = Store::all();
        $materials_types = Material::withTrashed()->get();
        
        return \View::make('admin/materials_quantity/edit',array('material'=>$materialQuantity, 'types' => $materials_types, 'stores' => $stores));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaterialQuantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialQuantity $materialQuantity)
    {
        $materialQuantity->material_id = $request->material_id;
        $materialQuantity->quantity = $request->quantity;
        $materialQuantity->store_id = $request->store_id;

        $validator = Validator::make( $request->all(), [
            'material_id' => 'required',
            'quantity' => 'required',
            'store_id' => 'required'
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }
        
        $materialQuantity->save();
        
        return Response::json(array('ID' => $materialQuantity->id, 'table' => View::make('admin/materials_quantity/table', array('material' => $materialQuantity))->render()));
    }

    public function search(Request $request){
        $material = new MaterialQuantity();
        $search = $material->search($request);

        return json_encode($search, JSON_UNESCAPED_SLASHES );
    }

    public function select_search(Request $request){
        $query = MaterialQuantity::select('*');

        $materials_new = new MaterialQuantity();
        $materials = $materials_new->filterMaterials($request, $query);
        $materials = $materials->where('store_id', Auth::user()->getStore()->id)->paginate(env('RESULTS_PER_PAGE'));
        $pass_materials = array();

        if($materials->count() == 0){
            $materials = MaterialQuantity::paginate(env('RESULTS_PER_PAGE'));
        }

        foreach($materials as $material){
            $pass_materials[] = [
                'value' => $material->id,
                'label' => $material->material->parent->name.' - '.$material->material->color.' - '.$material->material->carat,
                'data-carat' => $material->material->carat,
                'data-pricebuy' => $material->material->pricesBuy->first()->price
            ];
        }

        return json_encode($pass_materials, JSON_UNESCAPED_SLASHES );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaterialQuantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialQuantity $materialQuantity)
    {
        if($materialQuantity){

            $using = MaterialTravelling::where('material_id', $materialQuantity->material_id)->count();
            
            if($using){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{
                $materialQuantity->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }

    public function deleteByMaterial($material){
        MaterialQuantity::where('material_id', $material)->delete();
        return Response::json(array('success' => 'Успешно изтрито!'));
    }
}