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

    public function check($barcode){
        $discount = new Discount_codes;
        return json_encode($discount->check($barcode));
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
            'discount' => 'required|integer|between:1,100'
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

        if($request->lifetime){
            $discount->lifetime = 'yes';
        }
        
        $bar = '380'.unique_number('discount_codes', 'barcode', 7).'2'; 
        
        $digits =(string)$bar;
        // 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
        $even_sum = $digits{1} + $digits{3} + $digits{5} + $digits{7} + $digits{9} + $digits{11};
        // 2. Multiply this result by 3.
        $even_sum_three = $even_sum * 3;
        // 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
        $odd_sum = $digits{0} + $digits{2} + $digits{4} + $digits{6} + $digits{8} + $digits{10};
        // 4. Sum the results of steps 2 and 3.
        $total_sum = $even_sum_three + $odd_sum;
        // 5. The check character is the smallest number which, when added to the result in step 4,  produces a multiple of 10.
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;
        $discount->barcode = $digits . $check_digit;

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
    public function update(Request $request, Discount_codes $discount_codes, $discount)
    {
        $validator = Validator::make( $request->all(), [
            'discount' => 'required|integer|between:1,100'
         ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $users = User::all();
        $discount = Discount_codes::find($discount);

        $discount->discount = $request->discount;
        $discount->expires = $request->date_expires;
        $discount->user = $request->user;

        if($request->active == false){
            $discount->active = 'no';
        } else{
            $discount->active = 'yes';
        }

        if($request->lifetime == false){
            $discount->lifetime = 'no';
        } else{
            $discount->lifetime = 'yes';
        }

        $discount->save();

        return Response::json(array('table' => View::make('admin/discounts/table',array('discount' => $discount, 'users' => $users))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount_codes  $discount_codes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount_codes $discount_codes, $discount)
    {
        $discount = Discount_codes::find($discount);
        
        if($discount){
            $discount->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
