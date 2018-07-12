<?php

namespace App\Http\Controllers;

use App\Material;
use App\MaterialTravelling;
use App\MaterialQuantity;
use App\History;
use App\Stores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Faker\Provider\tr_TR\DateTime;
use Illuminate\Support\Facades\Redirect;
use Response;
use Auth;
use Bouncer;

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
            $materials = MaterialQuantity::all();
        }else{
            $materials = MaterialQuantity::where('store', Auth::user()->getStore());
        }
        
        //$materials = Materials_quantity::all();
        //$stores = Stores::where('id', '!=', Auth::user()->store)->get();
        $stores = Stores::all();
        $materials_types = Material::all();
        $travelling = MaterialTravelling::all();
  
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
            'type' => 'required',
            'quantity' => 'required',
            'storeTo' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $check = MaterialQuantity::find($request->type);

        if($check){
            if($request->quantity <= $check->quantity && $check->quantity != 0){
                $price = Material::find($check->material);

                if($check->store == $request->storeTo){
                    return Response::json(['errors' => array('quantity' => ['Не може да изпращате материал към същият магазин'])], 401);
                }

                $material = new MaterialTravelling();
                $material->type = $request->type;
                $material->quantity = $request->quantity;
                $material->price = ($request->quantity)*($price->stock_price);
                $material->storeFrom = Auth::user()->getStore();
                $material->storeTo  = $request->storeTo;
                $material->dateSent = new \DateTime();
                $material->userSent = Auth::user()->getId();

                $material->save();

                $quantity = MaterialQuantity::find($request->type);

                if($quantity){
                    $quantity->quantity = $quantity->quantity - $request->quantity;
                    $quantity->save();
                }

                $history = new History();

                $history->action = '1';
                $history->user = Auth::user()->getId();
                $history->table = 'materials_travelling';
                $history->result_id = $material->id;

                $history->save();

                return Response::json(array('success' => View::make('admin/materials_travelling/table', array('material' => $material, 'matID' => $check->material))->render()));

            }else{
                return Response::json(['errors' => array('quantity' => ['Въведохте невалидно количество!'])], 401);
            }
        }
    }

    public function accept(Request $request, $material)
    {
        $material = MaterialTravelling::findOrFail($material);

        if($material->status == 0){
            $check = MaterialQuantity::where(
                [
                    ['material', '=', $material->type],
                    ['store', '=', $material->storeTo]
                ]
            )->first();
    
            if($check){
                $check->quantity = $check->quantity + $material->quantity;
                $check->save();
            } else{
                $quantity = new MaterialQuantity();
                $quantity->material = $material->type;
                $quantity->quantity = $material->quantity;
                $quantity->store = $material->storeTo;
                $quantity->carat = '';
    
                $quantity->save();
            }

            $material->status = '1';
            $material->dateReceived = new \DateTime();
            $material->save();

            return Redirect::back();
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
