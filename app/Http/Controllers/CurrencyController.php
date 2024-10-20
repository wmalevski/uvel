<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Response;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'currency' => 'numeric|between:0.1,100'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $currency = Currency::create($request->all());

        return Response::json(array('success' => View::make('admin/settings/currencytable',array('currency'=>$currency))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Currency  $currencies
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Currency  $currencies
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        return \View::make('admin/settings/editCurrency', array('currency' => $currency));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Currency  $currencies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency){
        if($currency){
            $validator = Validator::make( $request->all(), [
                'name' => 'required',
                'currency' => 'numeric|between:0,100'
            ]);

            if ($validator->fails()) {
                return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
            }

            $currency->name = $request->name;
            $currency->currency = $request->currency;

            $currency->save();

            return Response::json(array('ID' => $currency->id, 'table' => View::make('admin/settings/currencytable',array('currency'=>$currency))->render()));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Currency  $currencies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        if($currency){
            $currency->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
