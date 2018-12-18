<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
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

class ProductTravelling extends Model
{
    public function store($request)
    {
        $validator = Validator::make( $request->all(), [
            'product_id' => 'required',
            'store_to_id' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $check = Product::find($request->product_id);

        if($check){
            if($check->store_id == $request->store_to_id){
                return Response::json(['errors' => array('quantity' => ['Не може да изпращате материал към същият магазин'])], 401);
            }
        }

        $travel = new ProductTravelling();
        $travel->product_id = $request->product_id;
        $travel->store_from_id = Auth::user()->getStore()->id;
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

        return Response::json(array('success' => View::make('admin/products_travelling/table', array('product' => $travel, 'proID' => $travel->id))->render()));
    }
}
