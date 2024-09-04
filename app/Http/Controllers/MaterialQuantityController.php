<?php

namespace App\Http\Controllers;

use Auth;
use App\MaterialQuantity;
use App\Material;
use App\Store;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;
use App\MaterialTravelling;

class MaterialQuantityController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MaterialTravelling $travelling){
        $loggedUser = Auth::user();
        $materials = MaterialQuantity::orderBy('id', 'DESC')->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);
        $stores = Store::take(env('SELECT_PRELOADED'))->get();
        $materials_types = Material::take(env('SELECT_PRELOADED'))->get();

        return \View::make('admin/materials_quantity/index', [
            'loggedUser' => $loggedUser,
            'materials' => $materials,
            'types' => $materials_types,
            'stores' => $stores,
            'travelling' => $travelling::current()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaterialQuantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialQuantity $materialQuantity){
        $stores = Store::take(env('SELECT_PRELOADED'))->get();
        $materials_types = Material::withTrashed()->take(env('SELECT_PRELOADED'))->get();

        return \View::make('admin/materials_quantity/edit',array('material'=>$materialQuantity, 'types' => $materials_types, 'stores' => $stores));
    }

    public function materialReport(){
        if(Auth::user()->role == 'manager') {
            $user_store_id = Auth::user()->getStore()->id;
            $materials_quantities = MaterialQuantity::where('store_id', $user_store_id)->orderBy('id', 'DESC')->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);
            $stores = Store::where('id', $user_store_id)->get();
        }
        else{
            $materials_quantities = MaterialQuantity::orderBy('id', 'DESC')->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);
            $stores = Store::all();
        }

        return view('admin.reports.materials_reports.index', compact(['stores', 'materials_quantities']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaterialQuantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialQuantity $materialQuantity){
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

        if($request->type && $request->type == 'payment'){
            $materials = $materials_new->filterMaterialsPayment($request, $query);
        }else{
            $materials = $materials_new->filterMaterials($request, $query);
        }

        $materials = $materials->where('store_id', Auth::user()->getStore()->id)->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $pass_materials = array();

        foreach($materials as $material){
            if($material->material->pricesSell->first()){
                $pass_materials[] = [
                    'attributes' => [
                        'value' => $material->id,
                        'label' => $material->material->parent->name.' - '.$material->material->color.' - '.$material->material->carat,
                        'data-carat' => $material->material->carat,
                        'data-pricebuy' => $material->material->pricesBuy->first()['price'],
                        'data-price' => $material->material->pricesSell->first()['price'],
                        'for_buy'  => $material->material->for_buy,
                        'for_exchange' => $material->material->for_exchange,
                        'carat_transform' => $material->material->carat_transform,
                        'carat' => $material->material->carat,
                        'data-material' => $material->material->id,
                    ]
                ];
            }

        }

        return json_encode($pass_materials, JSON_UNESCAPED_SLASHES );
    }

    public function filter(Request $request){
        $query = MaterialQuantity::select('*');

        $materials_new = new MaterialQuantity();
        $materials = $materials_new->filterMaterials($request, $query);
        $materials = $materials->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $response = '';
        foreach($materials as $material){
            $response .= \View::make('admin/materials_quantity/table', array('material' => $material, 'listType' => $request->listType));
        }

        $materials->setPath('');
        $response .= $materials->appends(request()->except('page'))->links();

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaterialQuantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialQuantity $materialQuantity){
        if($materialQuantity){

            $usingTravelling = MaterialTravelling::where('material_id', $materialQuantity->material_id)->count();
            $usingProduct = Product::where('material_id', $materialQuantity->material_id)->count();

            if($usingTravelling || $usingProduct){
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

    public function printerReport($req){
        // If the request is coming from a non-admin account, ignore the request and force the user's store
        if(!in_array(Auth::User()->role, array('admin','storehouse'))){
            $req = Auth::User()->store_id;
        }

        $store = new Store();
        $materials = new MaterialQuantity();

        if($req!=='all'){
            $store = $store->where('id', $req);
            $materials = $materials->where('store_id', $req);
        }

        $store = $store->get();
        $materials = $materials->get();
        $totals = array();

        $mpdf = new \Mpdf\Mpdf(array(
            'mode' => 'utf-8',
            'format' => 'A6',
            'margin_top' => 5,
            'margin_bottom' => 5,
            'margin_left' => 5,
            'margin_right' => 5,
        ));

        $html = view('pdf.materials_report', compact('store', 'materials', 'totals'));

        $mpdf->WriteHTML($html->render());

        // For development purposes
        // $mpdf->Output();
        // exit;

        $mpdf->Output('materials_report_'.$req.'_'.date('d-m-Y').'.pdf',\Mpdf\Output\Destination::DOWNLOAD);

    }
}
