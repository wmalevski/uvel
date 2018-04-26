<?php

namespace App\Http\Controllers;

use Response;
use App\Prices;
use App\Repairs;
use App\Repair_types;
use App\Materials;
use App\History;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;

class RepairsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repairTypes = Repair_types::all();
        $repairs = Repairs::all();
        $materials = Materials::all();
        
        return \View::make('admin/repairs/index', array('repairTypes' => $repairTypes, 'repairs' => $repairs, 'materials' => $materials));
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
            'customer_name' => 'required',
            'customer_phone' => 'required|numeric',
            'type' => 'required',
            'date_returned' => 'required',
            'weight' => 'required|numeric',
            'price' => 'required|numeric|between:0.1,5000',
            'deposit' => 'required|numeric|between:0.1,5000'
         ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $repair = Repairs::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'type' => $request->type,
            'date_recieved' => $request->date_recieved,
            'date_returned' => $request->date_returned,
            'code' =>  unique_random('repairs', 'code', 4),
            'weight' => $request->weight,
            'price' => $request->price,
            'deposit' => $request->deposit,
            'repair_description' => $request->repair_description,
            'material' => $request->material
        ]);
        
        $repair->barcode = '380'.unique_number('repairs', 'code', 7);

        $repair->save();

        return Response::json(array('success' => View::make('admin/repairs/table',array('repair'=>$repair))->render(), 'id' => $repair->id));
    }

    public function scan($barcode){
        $repair = Repairs::where('barcode', $barcode)->get();

        return Response::json(array('repair' => $repair));
    }

    public function certificate($id){
        $repair = Repairs::find($id);
        $repair->barcode =  \DNS1D::getBarcodePNG($repair->barcode, "EAN13");
        return Response::json(array('repair' => $repair));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Repairs  $repairs
     * @return \Illuminate\Http\Response
     */
    public function show(Repairs $repairs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Repairs  $repairs
     * @return \Illuminate\Http\Response
     */
    public function edit(Repairs $repairs, $repair)
    {
        $repair = Repairs::find($repair);
        $repairTypes = Repair_types::all();
        $materials = Materials::all();

        return \View::make('admin/repairs/edit', array('repair' => $repair, 'repairTypes' => $repairTypes, 'materials' => $materials));
    }


    public function return(Repairs $repairs, $repair)
    {
        $repair = Repairs::find($repair);
        $repairTypes = Repair_types::all();

        return \View::make('admin/repairs/return', array('repair' => $repair, 'repairTypes' => $repairTypes));
    }

    public function returnRepair(Repairs $repairs, $repair)
    {
        $repair = Repairs::find($repair);
        
        if($repair){
            $repair->status = 'returned';
            $repair->date_received = Carbon::parse(Carbon::now())->format('d-m-Y');
            $repair->save();

            $history = new History;
            $history->action = 'repair';
            $history->user = Auth::user()->id;
            $history->result_id = $repair->id;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Repairs  $repairs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Repairs $repairs, $repair)
    {
        $repair = Repairs::find($repair);
        
        $repair->customer_name = $request->customer_name;
        $repair->customer_phone = $request->customer_phone;
        $repair->date_returned = $request->date_returned;
        $repair->price_after = $request->price_after; 
        $repair->repair_description = $request->repair_description;
        $repair->material = $request->material;
        $repair->weight_after = $request->weight_after;

        if($repair->weight < $request->weight_after){
            $repair->price_after = $repair->price + ($repair->weight*Prices::where(
                [
                    ['material', '=', $repair->material],
                    ['type', '=', 'sell']
                ])->first()->price);
        }else{
            $repair->price_after = $repair->price;
        }

        if($request->status){
            $repair->status = 'done';
        }

        $validator = Validator::make( $request->all(), [
            'customer_name' => 'required',
            'customer_phone' => 'required|numeric',
            'type' => 'required',
            'date_returned' => 'required',
            'weight' => 'required|numeric',
            'price' => 'required|numeric|between:0.1,5000',
            'deposit' => 'required|numeric|between:0.1,5000'
         ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }
    
        $repair->save();
        
        return Response::json(array('table' => View::make('admin/repairs/table',array('repair'=>$repair))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Repairs  $repairs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repairs $repairs, $repair)
    {
        $repair = Repairs::find($repair);

        if($repair){
            $repair->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
