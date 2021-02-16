<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\ProductTravelling;
use App\Product;
use App\Store;
use Response;
use Redirect;
use Auth;

class ProductTravelling extends BaseModel{

    protected $dates = array('date_sent', 'date_received');

    public function store($request, $responseType = 'JSON'){
        $validator = Validator::make( $request->all(), [
            'product_id' => 'required',
            'store_to_id' => 'required',
        ]);

        if ($validator->fails()) {
            if($responseType == 'JSON'){
                return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
            }else{
                return array('errors' => $validator->errors());
            }
        }

        $check = Product::find($request->product_id);

        if($request->store_from_id){
            $store_from = $request->store_from_id;
        }else{
            $store_from = Auth::user()->getStore()->id;
        }

        if($check){
            if($store_from == $request->store_to_id){
                if($responseType == 'JSON'){
                    return Response::json(['errors' => array('quantity' => ['Не може да изпращате бижу към същия магазин'])], 401);
                }else{
                    return array('errors' => array('quantity' => ['Не може да изпращате бижу към същия магазин']));
                }
            }
        }

        $travel = new ProductTravelling();
        $travel->product_id = $request->product_id;
        $travel->store_from_id = $store_from;
        $travel->store_to_id  = $request->store_to_id;
        $travel->date_sent = new \DateTime();
        $travel->user_sent = Auth::user()->getId();

        $travel->save();

        $product = Product::find($request->product_id);
        $product->status = 'travelling';
        $product->save();


        // $history = new History();

        // $history->action = '1';
        // $history->user = Auth::user()->getId();
        // $history->table = 'products_travelling';
        // $history->result_id = $travel->id;

        // $history->save();

        return $product;
    }
}
