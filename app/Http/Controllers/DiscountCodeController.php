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
            'discount' => 'required|integer|between:0,100',
            'barcode' => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }


        $discount = DiscountCode::create([
            'discount' => $request->discount,
            'expires' => $request->date_expires,
            'user_id' => $request->user_id,
            'barcode' => $request->barcode,
        ]);

        if($request->lifetime == 'true' || !$request->date_expires){
            $discount->lifetime = 'yes';
        }

        $discount->barcode = $request->barcode;

        $discount->active = 'yes';

        $discount->save();

        return Response::json(array('success' => View::make('admin/discounts/table',array('discount'=>$discount))->render()));
    }

    public function generate($id) {
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
            'discount' => 'required|integer|between:0,100',
            'barcode' => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $users = User::all();

        $discountCode->discount = $request->discount;
        $discountCode->expires = $request->date_expires;
        $discountCode->user_id = $request->user_id;
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
