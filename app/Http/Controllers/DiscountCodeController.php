<?php

namespace App\Http\Controllers;

use App\DiscountCode;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;

class DiscountCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = DiscountCode::all();
        $users = User::take(env('SELECT_PRELOADED'))->get();
        
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
        $discount = new DiscountCode;
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
            'discount' => 'required|integer|between:0,100'
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }


        $discount = DiscountCode::create([
            'discount' => $request->discount,
            'expires' => $request->date_expires,
            'user_id' => $request->user_id,
        ]);

        if($request->lifetime == 'true' || !$request->date_expires){
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

    public function filter(Request $request){
        $query = DiscountCode::select('*');

        $discounts_new = new DiscountCode();
        $discounts = $discounts_new->filterDiscountCodes($request, $query);
        $discounts = $discounts->paginate(env('RESULTS_PER_PAGE'));

        $response = '';
        foreach($discounts as $discount){
            $response .= \View::make('admin/discounts/table', array('discount' => $discount, 'listType' => $request->listType));
        }

        $discounts->setPath('');
        $response .= $discounts->appends(Input::except('page'))->links();

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DiscountCode  $discount_codes
     * @return \Illuminate\Http\Response
     */
    public function show(DiscountCode $discountCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DiscountCode  $discount_codes
     * @return \Illuminate\Http\Response
     */
    public function edit(DiscountCode $discountCode)
    {
        $users = User::all();
        
        return \View::make('admin/discounts/edit', array('users' => $users, 'discount' => $discountCode));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DiscountCode  $discount_codes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DiscountCode $discountCode)
    {
        $validator = Validator::make( $request->all(), [
            'discount' => 'required|integer|between:0,100'
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $users = User::all();

        $discountCode->discount = $request->discount;
        $discountCode->expires = $request->date_expires;
        $discountCode->user_id = $request->user_id;

        if($request->active == 'false'){
            $discountCode->active = 'no';
        } else{
            $discountCode->active = 'yes';
        }

        if($request->lifetime == 'false'){
            $discountCode->lifetime = 'no';
        } else{
            $discountCode->lifetime = 'yes';
        }

        if(!$request->date_expires){
            $discountCode->lifetime = 'yes';
        }

        $discountCode->save();

        return Response::json(array('ID' => $discountCode->id, 'table' => View::make('admin/discounts/table',array('discount' => $discountCode, 'users' => $users))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DiscountCode  $discount_codes
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiscountCode $discountCode)
    {

        if($discountCode){
            $discountCode->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
