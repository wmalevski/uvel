<?php

namespace App\Http\Controllers;

use App\Discount_codes;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;

class DiscountCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount_codes::all();
        $users = User::all();
        
        return \View::make('admin/discounts/index', array('discounts' => $discounts, 'users' => $users));
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
            'discount' => 'required',
            'date_expires' => 'required',
         ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }


        $discount = Discount_codes::create([
            'discount' => $request->discount,
            'expires' => $request->date_expires,
            'user' => $request->user,
            'code' =>  unique_random('discount_codes', 'code', 4),
        ]);
        
        $discount->barcode = '380'.unique_number('discount_codes', 'code', 7);

        $discount->active = 'yes';

        $discount->save();

        return Response::json(array('success' => View::make('admin/discounts/table',array('discount'=>$discount))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discount_codes  $discount_codes
     * @return \Illuminate\Http\Response
     */
    public function show(Discount_codes $discount_codes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount_codes  $discount_codes
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount_codes $discount_codes, $discount)
    {
        $users = User::all();
        $discount = Discount_codes::find($discount);
        
        return \View::make('admin/discounts/edit', array('users' => $users, 'discount' => $discount));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discount_codes  $discount_codes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount_codes $discount_codes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount_codes  $discount_codes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount_codes $discount_codes)
    {
        //
    }
}
