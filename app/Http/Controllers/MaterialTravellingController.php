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
        if(Bouncer::is(Auth::user())->an('admin')){
            $materials = MaterialQuantity::take(env('SELECT_PRELOADED'))->get();
        }else{
            $materials = MaterialQuantity::CurrentStore()->take(env('SELECT_PRELOADED'))->get();
        }
        
        $stores = Store::where('id', '!=', Auth::user()->getStore()->id)->take(env('SELECT_PRELOADED'))->get();
        $materials_types = Material::take(env('SELECT_PRELOADED'))->get();
        $travelling = MaterialTravelling::take(env('SELECT_PRELOADED'))->get();

        if(Bouncer::is(Auth::user())->an('admin')){
            $travelling = MaterialTravelling::all();
        }else{
            $travelling = MaterialTravelling::where('store_from_id', '=', Auth::user()->getStore()->id)->orWhere('store_to_id', '=', Auth::user()->getStore()->id)->get();
        }

  
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

        $check = MaterialQuantity::find($request->material_id);

        if($check){
            if($request->quantity <= $check->quantity && $check->quantity != 0){
                $price = Material::withTrashed()->find($check->material_id);

                if($check->store == $request->storeTo){
                    return Response::json(['errors' => array('quantity' => ['Не може да изпращате материал към същият магазин'])], 401);
                }

                $material = new MaterialTravelling();
                $material->material_id = $request->material_id;
                $material->quantity = $request->quantity;
                $material->price = ($request->quantity)*($price->stock_price);
                $material->store_from_id = Auth::user()->getStore()->id;
                $material->store_to_id  = $request->store_to_id;
                $material->dateSent = new \DateTime();
                $material->user_sent_id = Auth::user()->getId();

                $material->save();

                $quantity = MaterialQuantity::find($request->material_id);

                if($quantity){
                    $quantity->quantity = $quantity->quantity - $request->quantity;
                    $quantity->save();
                }

                return Response::json(array('success' => View::make('admin/materials_travelling/table', array('material' => $material, 'matID' => $check->material->id))->render()));

            }else{
                return Response::json(['errors' => array('quantity' => ['Въведохте невалидно количество!'])], 401);
            }
        }
    }

    public function accept(Request $request, MaterialTravelling $material)
    {
        if($material->status == 0){
            $check = MaterialQuantity::where(
                [
                    ['material_id', '=', $material->material_id],
                    ['store_id', '=', $material->store_to_id]
                ]
            )->first();
    
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

            $material->status = '1';
            $material->dateReceived = Carbon::now()->format('Y-m-d H:i:s');
            $material->save();

            return Response::json(array('success' => View::make('admin/materials_travelling/table', array('material' => $material, 'matID' => $material->id))->render()));
        }
    }

    public function decline(Request $request, MaterialTravelling $material)
    {
        if($material->status == 0){
            $check = MaterialQuantity::where(
                [
                    ['material_id', '=', $material->material_id],
                    ['store_id', '=', $material->store_to_id]
                ]
            )->first();
    
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

            $material->dateReceived = Carbon::now()->format('Y-m-d H:i:s');
            $material->save();

            return Response::json(array('success' => View::make('admin/materials_travelling/table', array('material' => $material, 'matID' => $material->id))->render()));
        }
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
