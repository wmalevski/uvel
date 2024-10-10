<?php

namespace App\Http\Controllers;

use App\Price;
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

class MaterialController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $materials = Material::all();
        $parents = MaterialType::all();

        return \View::make('admin/materials/index', array('materials' => $materials, 'parents' => $parents));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
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

        $material->for_buy = ($request->for_buy == 'false' ? 'no' : 'yes');
        $material->for_exchange = ($request->for_exchange == 'false' ? 'no' : 'yes');
        $material->carat_transform = ($request->carat_transform == 'false' ? 'no' : 'yes');

        $material->save();

        $material_quantity = new MaterialQuantity();
        $material_quantity->material_id = $material->id;
        $material_quantity->quantity = 0;
        $material_quantity->store_id = 1;
        $material_quantity->save();

        return Response::json(array('success' => View::make('admin/materials/table',array('material'=>$material))->render()));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Material  $materials
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material){
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
    public function update(Request $request, Material $material){
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


        $material->for_buy = ($request->for_buy == 'false' ? 'no' : 'yes');
        $material->for_exchange = ($request->for_exchange == 'false' ? 'no' : 'yes');
        $material->carat_transform = ($request->carat_transform == 'false' ? 'no' : 'yes');

        $material->save();

        return Response::json(array('ID' => $material->id,'table' => View::make('admin/materials/table',array('material'=>$material))->render()));
    }

    public function filter(Request $request){
        $query = Material::select('*');

        $materials_new = new Material();
        $materials = $materials_new->filterMaterials($request, true);
        $materials = $materials->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $response = '';
        foreach($materials as $material){
            $response .= \View::make('admin/materials/table', array('material' => $material, 'listType' => $request->listType));
        }

        $materials->setPath('');
        $response .= $materials->appends(request()->except('page'))->links();

        return $response;
    }

    public function select_search(Request $request, Material $material){
        if($request->type && $request->type == 'payment'){
            return $material->filterMaterialsPayment($request);
        }

        return $material->filterMaterials($request);
    }

    public function select_search_withPrice(Request $request, Material $material){
        if ($request->type && $request->type == 'payment'){
            return $material->filterMaterialsPayment($request);
        } else {
            return $material->filterMaterials($request);
        }
    }

    public function select_materials(Request $request){
        $materialsQueryBuilder = Material::where('parent_id', $request->type_id);
        $materials = $materialsQueryBuilder->get();
        $paginatedResult = $materialsQueryBuilder->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);
        $result_materials = array();

        foreach($materials->get() as $material){
            if(isset($material->pricesExchange[0]) && isset($material->pricesExchange[1])){
                $result_materials['results'][] = [
                    'id' => $material->id,
                    'text' => $material->parent->name .' - '. $material->color . ' - ' .$material->code,
                    'attributes' => [
                        'data-sample' => $material->code,
                        'data-price-1' => $material->pricesExchange[0]->price,
                        'data-price-1-id' => $material->pricesExchange[0]->id,
                        'data-price-2' => $material->pricesExchange[1]->price,
                        'data-price-2-id' => $material->pricesExchange[1]->id
                    ],
                ];
            }
        }

        $result_materials['pagination'] = [
            'more' => $paginatedResult->hasMorePages()
        ];

        return $result_materials;
    }

    public function select_material_prices(Request $request){
        $materials = Material::find($request->id)->first();
        $paginatedResult = $materials->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $result_materials = array();

        foreach($materials->pricesBuy as $prices) {
            $result_materials['results'][] = [
                'id' => $prices->id,
                'text' => $prices->slug .' - '. $prices->price .' лв.',
                'attributes' => [
                    'data-price' => $prices->price,
                ],
            ];
        }

        $result_materials['pagination'] = ['more' => $paginatedResult->hasMorePages()];

        return response()->json($result_materials);
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
