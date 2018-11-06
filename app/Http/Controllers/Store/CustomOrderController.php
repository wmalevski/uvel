<?php

namespace App\Http\Controllers\Store;

use App\CustomOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Mail;

class CustomOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \View::make('store.pages.orders.index');
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
            'name' => 'required|string',
            'email' => 'required|string|email|max:255',
            'content' => 'required|string',
            'phone' => 'required',
            'city' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $customOrder = CustomOrder::create($request->all());

        return Redirect::back()->with('success', 'Съобщението ви беше изпратено успешно');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomOrder  $customOrder
     * @return \Illuminate\Http\Response
     */
    public function show(CustomOrder $customOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomOrder  $customOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomOrder $customOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomOrder  $customOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomOrder $customOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomOrder  $customOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomOrder $customOrder)
    {
        //
    }
}
