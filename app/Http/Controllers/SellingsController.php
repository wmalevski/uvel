<?php

namespace App\Http\Controllers;

use App\Sellings;
use Illuminate\Http\Request;
use App\Repair_types;
use Cart;
use App\Products;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\JsonResponse;
use Response;

class SellingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repairTypes = Repair_types::all();

        $items = [];

        Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        //dd($items);
        
        return \View::make('admin/selling/index', array('repairTypes' => $repairTypes, 'items' => $items));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sellings  $sellings
     * @return \Illuminate\Http\Response
     */
    public function show(Sellings $sellings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sellings  $sellings
     * @return \Illuminate\Http\Response
     */
    public function edit(Sellings $sellings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sellings  $sellings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sellings $sellings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sellings  $sellings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sellings $sellings)
    {
        //
    }

    public function sell(Request $request){
        $item = Products::where('barcode', $request->barcode)->first();

        if($item){            
            $userId = Auth::user()->getId(); // or any string represents user identifier
            Cart::session($userId)->add(array(
                'id' => $item->barcode,
                'name' => 'Sample Item',
                'price' => $item->price,
                'quantity' => $request->quantity,
                'attributes' => array(
                    'weight' => $item->weight
                )
            ));
            
            // $row = Cart::add(['id' => $request->barcode, 'name' => $item->name, 'qty' => $request->quantity, 'price' => 9.99, 'options' => ['weight' => $item->weight]]);

            // $cart = Cart::restore(Auth::user()->getId());


            // if(!$cart){
            //     Cart::store(Auth::user()->getId());
            // }

            // return Response::json(array('table' => View::make('admin/selling/table',array('row'=>$row))->render()));  



        }else{
            echo 'no';
        }
    }
}
