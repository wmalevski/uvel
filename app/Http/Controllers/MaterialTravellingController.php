<?php

namespace App\Http\Controllers;

use App\Material;
use App\MaterialTravelling;
use App\MaterialQuantity;
use App\History;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Response;
use Auth;
use Bouncer;
use Carbon\Carbon;

class MaterialTravellingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = MaterialQuantity::CurrentStore()->take(env('SELECT_PRELOADED'));

        $stores = Store::where('id', '!=', Auth::user()->getStore()->id)->take(env('SELECT_PRELOADED'))->get();
        $materials_types = Material::take(env('SELECT_PRELOADED'))->get();

        $travelling = MaterialTravelling::where('store_from_id', '=', Auth::user()->getStore()->id)->orWhere('store_to_id', '=', Auth::user()->getStore()->id)->paginate(\App\Setting::where('key','per_page')->get()[0]->value);

// dd($materials);
        return \View::make('admin/materials_travelling/index', array('materials' => $materials, 'types' => $materials_types, 'stores' => $stores, 'travelling' => $travelling));
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

    public function mtravellingReport()
    {
        $materials_travellings = MaterialTravelling::all();

        return view('admin.reports.mtravelling_reports.index', compact(['materials_travellings']));
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
            'store_to_id' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $check = MaterialQuantity::where([
            ['material_id', '=', $request->material_id],
            ['store_id', '=', Auth::user()->getStore()->id]
        ])->first();

        if($check){
            if($request->quantity <= $check->quantity && $check->quantity != 0){
                $price = Material::withTrashed()->find($check->material_id);
                if(Auth::user()->getStore()->id == $request->store_to_id){
                    return Response::json(['errors' => array('quantity' => [trans('admin/materials_travelling.store_duplicate')])], 401);
                }

                $material = new MaterialTravelling();
                $material->material_id = $request->material_id;
                $material->quantity = $request->quantity;
                $material->price = ($request->quantity)*($price->stock_price);
                $material->store_from_id = Auth::user()->getStore()->id;
                $material->store_to_id  = $request->store_to_id;
                $material->dateSent = new \DateTime();
                $material->user_sent_id = Auth::user()->getId();
                $material->status = 'not_accepted';
                $material->dateReceived = NULL;

                $material->save();

                $quantity = MaterialQuantity::where([
                    ['material_id', '=', $request->material_id],
                    ['store_id', '=', Auth::user()->getStore()->id]
                ])->first();

                if($quantity){
                    $quantity->quantity = $quantity->quantity - $request->quantity;
                    $quantity->save();
                }

                return Response::json(array('success' => View::make('admin/materials_travelling/table', array('material' => $material, 'matID' => $check->material->id))->render()));

            }else{
                return Response::json(['errors' => array('quantity' => [trans('admin/materials_travelling.material_quantity_not_matching')])], 401);
            }
        }else{
            return Response::json(['errors' => array('quantity' => [trans('admin/materials_travelling.material_quantity_not_matching')])], 401);
        }
    }

    public function accept(Request $request, MaterialTravelling $material)
    {
        if($material->status == 'not_accepted'){
            $check = MaterialQuantity::where([
                ['material_id', '=', $material->material_id],
                ['store_id', '=', $material->store_to_id]
            ])->first();

            if($check){
                $check->quantity = $check->quantity + $material->quantity;
                $check->save();
            } else{
                $quantity = new MaterialQuantity();
                $quantity->material_id = $material->material_id;
                $quantity->quantity = $material->quantity;
                $quantity->store_id = $material->store_to_id;
                $quantity->carat = '';

                $quantity->save();
            }
            $material->user_received_id = Auth::user()->id;
            $material->status = 'accepted';
            $material->dateReceived = Carbon::now()->format('Y-m-d H:i:s');
            $material->save();

            return Response::json(array('success' => View::make('admin/materials_travelling/table', array('material' => $material, 'matID' => $material->id))->render()));
        }
    }

    public function decline(Request $request, MaterialTravelling $material)
    {
        $check = MaterialQuantity::where([
                ['material_id', '=', $material->material_id],
                ['store_id', '=', $material->store_from_id]
            ])->first();

        if($check){
            $check->quantity = $check->quantity + $material->quantity;
            $check->save();
        } else{
            $quantity = new MaterialQuantity();
            $quantity->material_id = $material->material_id;
            $quantity->quantity = $material->quantity;
            $quantity->store_id = $material->store_from_id;
            $quantity->carat = '';

            $quantity->save();
        }

        $material->dateReceived = Carbon::now()->format('Y-m-d H:i:s');
        $material->save();

        return Response::json(array('success' => View::make('admin/materials_travelling/table', array('material' => $material, 'matID' => $material->id))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaterialTravelling  $materialTravelling
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialTravelling $materialTravelling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaterialTravelling  $materialTravelling
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialTravelling $materialTravelling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaterialTravelling  $materialTravelling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialTravelling $materialTravelling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaterialTravelling  $materialTravelling
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialTravelling $materialTravelling)
    {
        //
    }
}
