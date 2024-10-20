<?php

namespace App\Http\Controllers;

use App\DiscountCode;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;

class DiscountCodeController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $discounts = DiscountCode::with(['users', 'payments'])->orderBy('id', 'DESC')->get();
        $users = User::take(env('SELECT_PRELOADED'))->with('discountCodes')->get();

        return \View::make('admin/discounts/index', array('discounts' => $discounts, 'users' => $users));
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
    public function store(Request $request){
        $validator = Validator::make( $request->all(), [
            'discount' => 'required|integer|between:0,100',
            'barcode' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $discount = DiscountCode::create([
            'discount' => $request->discount,
            'expires' => $request->date_expires,
            'barcode' => $request->barcode,
        ]);

        $userList = explode(',', $request->input('user_list'));
        $discount->users()->sync($userList);

        if($request->lifetime == 'true' || !$request->date_expires){
            $discount->lifetime = 'yes';
        }

        $discount->barcode = $request->barcode;

        $discount->active = 'yes';

        $discount->save();

        return Response::json(array('success' => View::make('admin/discounts/table',array('discount'=>$discount))->render()));
    }

    public function generate($id){
        $discount = DiscountCode::where('id', $id)->first();

        if($discount) {
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => [40, 40],
            ]);

            $html = view('pdf.discount', compact('discount'))->render();

            $mpdf->WriteHTML($html);

            $mpdf->Output(str_replace(' ', '_', $discount->barcode).'_discount.pdf',\Mpdf\Output\Destination::DOWNLOAD);
        }

        abort(404, 'Product not found.');
    }

    public function filter(Request $request){
        $discounts = DiscountCode::filterDiscountCodes($request, new DiscountCode());
        $discounts = $discounts->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $response = '';
        foreach($discounts as $discount){
            $response .= \View::make('admin/discounts/table', array('discount' => $discount, 'listType' => $request->listType));
        }

        $discounts->setPath('');
        $response .= $discounts->appends(request()->except('page'))->links();

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
            'discount' => 'required|integer|between:0,100',
            'barcode' => 'required|integer',
        ]);

        $userList = explode(',', $request->input('user_list'));
        $discountCode->users()->sync($userList);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $users = User::all();

        $discountCode->discount = $request->discount;
        $discountCode->expires = $request->date_expires;
        $discountCode->barcode = $request->barcode;

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
