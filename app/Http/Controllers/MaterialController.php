<?php

namespace App\Http\Controllers;

use Auth;
use App\Material;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Jewel;
use App\MaterialType;
use App\MaterialQuantity;
use Illuminate\Support\Facades\Input;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $materials = Material::all();
        $parents = MaterialType::all();
        
        return \View::make('admin/materials/index', array('materials' => $materials, 'parents' => $parents));
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
            'code' => 'required',
            'color' => 'required',
            'carat' => 'nullable|numeric|between:1,100',
            'parent_id' => 'required|nullable|numeric',
            'cash_group' => 'required|numeric'
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $material = Material::create($request->all());

        $material = Material::find($material->id);

        $name = $material->parent->name;
        $material->name = $name;
        
        if($request->for_buy == 'false'){
            $material->for_buy = 'no';
        } else{
            $material->for_buy = 'yes';
        }

        if($request->for_exchange == 'false'){
            $material->for_exchange = 'no';
        } else{
            $material->for_exchange = 'yes';
        }

        if($request->carat_transform == 'false'){
            $material->carat_transform = 'no';
        } else{
            $material->carat_transform = 'yes';
        }

        if($request->default_material == 'false'){
            $material->default = 'no';
        } else{
            Material::where('parent_id', '=', $request->parent_id)
            ->update([
                'default' => 'no',
            ]);

            $material->default = 'yes';
        }

        $material->save();

        return Response::json(array('success' => View::make('admin/materials/table',array('material'=>$material))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Material  $materials
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Material  $materials
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        $parents = MaterialType::all();

        return \View::make('admin/materials/edit',array('material'=>$material, 'parents' => $parents));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material  $materials
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        $validator = Validator::make( $request->all(), [
            'code' => 'required',
            'color' => 'required',
            'carat' => 'nullable|numeric|between:1,100',
            'parent_id' => 'required|nullable|numeric',
            'cash_group' => 'required|numeric'
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $material->code = $request->code;
        $material->color = $request->color;
        $material->carat = $request->carat;
        $material->cash_group = $request->cash_group;
        $material->parent_id = $request->parent_id;

        if($request->for_buy == 'false'){
            $material->for_buy = 'no';
        } else{
            $material->for_buy = 'yes';
        }

        if($request->for_exchange == 'false'){
            $material->for_exchange = 'no';
        } else{
            $material->for_exchange = 'yes';
        }

        if($request->carat_transform == 'false'){
            $material->carat_transform = 'no';
        } else{
            $material->carat_transform = 'yes';
        }

        if($request->default_material == 'false'){
            $material->default = 'no';
        } else{
            Material::where('parent_id', '=', $request->parent_id)
            ->update([
                'default' => 'no',
            ]);

            $material->default = 'yes';
        }
        
        $material->save();

        return Response::json(array('ID' => $material->id,'table' => View::make('admin/materials/table',array('material'=>$material))->render()));
    }

    public function filter(Request $request){
        $query = Material::select('*');

        $materials_new = new Material();
        $materials = $materials_new->filterMaterials($request, $query);
        $materials = $materials->paginate(env('RESULTS_PER_PAGE'));

        $response = '';
        foreach($materials as $material){
            $response .= \View::make('admin/materials/table', array('material' => $material, 'listType' => $request->listType));
        }

        $materials->setPath('');
        $response .= $materials->appends(Input::except('page'))->links();

        return $response;
    }

    public function select_search(Request $request){
        $query = Material::select('*');

        $materials_new = new Material();
        
        if($request->type && $request->type == 'payment'){
            $materials = $materials_new->filterMaterialsPayment($request, $query);
        }else{
            $materials = $materials_new->filterMaterials($request, $query);
        }

        $materials = $materials->paginate(env('RESULTS_PER_PAGE'));
        $pass_materials = array();

        foreach($materials as $material){
            $pass_materials[] = [
                'attributes' => [
                    'value' => $material->id,
                    'label' => $material->parent->name.' - '.$material->color.' - '.$material->code,
                    'data-carat' => $material->carat,
                    'data-transform' => $material->carat_transform,
                    'data-pricebuy' => $material->pricesBuy->first()['price'],
                    'data-price' => $material->pricesSell->first()['price'],
                    'data-material' => $material->id,
                ]
            ];
            
        }

        return json_encode($pass_materials, JSON_UNESCAPED_SLASHES );
    }

    public function select_search_withPrice(Request $request){
        $query = Material::select('*');

        $materials_new = new Material();
        if($request->type && $request->type == 'payment'){
            $materials = $materials_new->filterMaterialsPayment($request, $query);
        }else{
            $materials = $materials_new->filterMaterials($request, $query);
        }
        $materials = $materials->paginate(env('RESULTS_PER_PAGE'));
        $pass_materials = array();

        foreach($materials as $material){
            if($material->pricesSell->first()){
                $pass_materials[] = [
                    'attributes' => [
                        'value' => $material->id,
                        'label' => $material->parent->name.' - '.$material->color.' - '.$material->code,
                        'data-carat' => $material->carat,
                        'data-transform' => $material->carat_transform,
                        'data-pricebuy' => $material->pricesBuy->first()['price'],
                        'data-price' => $material->pricesSell->first()['price'],
                        'data-material' => $material->id,
                        'data-type' => $material->parent->id
                    ]
                ];
            } 
        }

        return json_encode($pass_materials, JSON_UNESCAPED_SLASHES );
    }

    public function select_search_payment(Request $request){
        $query = Material::select('*');

        $materials_new = new Material();

        $materials = $materials_new->filterMaterialsPay($request, $query);

        $materials = $materials->paginate(env('RESULTS_PER_PAGE'));
        
        $pass_materials = array();

        foreach($materials as $material){
            if($material->pricesSell->first()){
                $pass_materials[] = [
                    'attributes' => [
                        'value' => $material->id,
                        'label' => $material->parent->name.' - '.$material->color.' - '.$material->code,
                        'data-carat' => $material->carat,
                        'data-transform' => $material->carat_transform,
                        'data-pricebuy' => $material->pricesBuy->first()['price'],
                        'data-price' => $material->pricesSell->first()['price'],
                        'data-material' => $material->id,
                        'data-type' => $material->parent->id,
                        'data-sample' => $material->code
                    ]
                ];
            } 
        }

        return json_encode($pass_materials, JSON_UNESCAPED_SLASHES );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material  $materials
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        if($material){
            $usingQuantity = MaterialQuantity::where('material_id', $material->id)->count();

            if($usingQuantity){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{
                $material->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
