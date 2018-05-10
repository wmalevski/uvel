<?php

namespace App\Http\Controllers;

use App\Currencies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Response;

class CurrenciesController extends Controller
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

        $currency = Currencies::create($request->all());

        return Response::json(array('success' => View::make('admin/settings/currencytable',array('currency'=>$currency))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Currencies  $currencies
     * @return \Illuminate\Http\Response
     */
    public function show(Currencies $currencies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Currencies  $currencies
     * @return \Illuminate\Http\Response
     */
    public function edit(Currencies $currencies, $currency)
    {
        $currency = Currencies::find($currency);

        return \View::make('admin/settings/editCurrency', array('currency' => $currency));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Currencies  $currencies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currencies $currencies, $currency)
    {
        $currency = Currencies::find($currency);
        
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

            return Response::json(array('table' => View::make('admin/settings/currencytable',array('currency'=>$currency))->render()));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Currencies  $currencies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currencies $currencies, $currency)
    {
        $currency = Currencies::find($currency);
        
        if($currency){
            $currency->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
