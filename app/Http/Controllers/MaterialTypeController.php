<?php

namespace App\Http\Controllers;

use App\MaterialType;
use App\Jewel;
use App\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Response;
use App\Material;

class MaterialTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = MaterialType::all();

        return \View::make('admin/materials_types/index', array('materials' => $materials));
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
            'name' => 'required',
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $material = MaterialType::create($request->all());

        return Response::json(array('success' => View::make('admin/materials_types/table',array('material'=>$material))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaterialType  $materials_type
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialType $materialType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaterialType  $materials_type
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialType $materialType)
    {
        return \View::make('admin/materials_types/edit',array('material'=>$materialType));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaterialType  $materials_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialType $materialType)
    {
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }
        
        $materialType->name = $request->name;
        
        $materialType->save();

        return Response::json(array('ID' => $materialType->id,'table' => View::make('admin/materials_types/table',array('material'=>$materialType))->render()));
    }

    public function select_search_payment(Request $request){
        $query = MaterialType::select('*');

        $materials_new = new MaterialType();
        
        $materials = $materials_new->filterMaterialsPayment($request, $query);

        $materials = $materials->paginate(env('RESULTS_PER_PAGE'));

        $pass_materials = array();

        $all_materials = Material::all();

        $second_default_price = 0;

        foreach($materials as $material){
            if($material->defaultMaterial){
                $default_price = $material->defaultMaterial->pricesBuy->first()['price'];

                $check_second_price = Price::where([
                    ['material_id', '=', $material->id],
                    ['type', '=', 'buy'],
                    ['price', '<>', $default_price],
                    ['price', '<', $default_price]
                ])->orderBy(DB::raw('ABS(price - '.$default_price.')'), 'desc')->first();

                if($check_second_price){
                    $second_default_price = $check_second_price->price;
                }

                $pass_materials[] = [
                    'attributes' => [
                        'value' => $material->id,
                        'label' => $material->name,
                        'data-type' => $material->id,
                        'data-sample' => $material->defaultMaterial->code,
                        'data-default-price' => $material->defaultMaterial->pricesBuy->first()['price'],
                        'data-second-price' => $second_default_price
                    ]
                ];
            }
        }

        return json_encode($pass_materials, JSON_UNESCAPED_SLASHES );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaterialType  $materials_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialType $materialType)
    {
        if($materialType){
            $using = Material::where('parent_id', $materialType->id)->count();
            
            if($using){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{
                $materialType->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
