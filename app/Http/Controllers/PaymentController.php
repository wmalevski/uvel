<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Payment;
use App\Selling;
use App\History;
use App\Repair;
use App\Product;
use App\PaymentDiscount;
use App\ProductOther;
use Response;
use Auth;
use Cart;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();
        
        return view('admin.payments.index', compact('payments'));
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
        //Store the selling
        

        //Store the payment
        if($request->given_sum >= $request->wanted_sum){
            $userId = Auth::user()->getId();

            //Check if the given sum is more or equal to the wanted sum
            $validator = Validator::make( $request->all(), [
                'wanted_sum' => 'required|numeric|between:0,1000000000',
                'given_sum'  => 'required|numeric|between:0,10000000',
            ]);
    
            if ($validator->fails()) {
                return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
            }

            $payment = new Payment();
            $payment->currency_id = $request->pay_currency;
            $payment->price = $request->wanted_sum;
            $payment->given = $request->given_sum;
            $payment->info = $request->info;
            $payment->user_id = $userId;


            if($request->pay_method == 'false'){
                $payment->method = 'cash';
            } else{
                $payment->method = 'post';
            }

            if($request->modal_reciept == 'false'){
                $payment->reciept = 'no';
            } else{
                $payment->reciept = 'yes';
            }

            if($request->modal_ticket == 'false'){
                $payment->ticket = 'no';
            } else{
                $payment->ticket = 'yes';
            }

            if($request->modal_certificate == 'false'){
                $payment->certificate = 'no';
            } else{
                $payment->certificate = 'yes';
            }


            $payment->save();

            $paymentID = $payment->id;
            
            //Saving car's conditions(discounts only) to the database.
            $cartConditions = Cart::session($userId)->getConditions();
            foreach($cartConditions as $condition){
                if($condition->getName() != 'ДДС')
                {
                    $discount = new PaymentDiscount();
                    $discount->discount_code_id = $condition->getAttributes()['discount_id'];
                    $discount->payment_id = $paymentID;
                    $discount->save();

                    //Store the notification
                    $history = new History();
                    
                    $history->action = 'discount'; 
                    $history->subaction = 'used'; 
                    $history->user_id = Auth::user()->getId();
                    $history->table = 'discount_codes';
                    $history->discount_id = $condition->getAttributes()['discount_id'];

                    $history->save();
                }
            };
            
            $items = [];
            
            Cart::session($userId)->getContent()->each(function($item) use (&$items)
            {
                $items[] = $item;
            });

            //Saving the sold item to a database
            foreach($items as $item){
                $selling = new Selling();
                $selling->weight = $item['attributes']->weight;
                $selling->quantity = $item->quantity;
                $selling->price = $item->price;
                $selling->payment_id = $payment->id;

                if($item['attributes']->type == 'repair'){
                    $repair = Repair::where('barcode', $item->id)->first();
                    $selling->repair_id = $repair->id;
                } elseif($item['attributes']->type == 'product'){
                    $product = Product::where('barcode', $item->id)->first();
                    $selling->product_id = $product->id;
                } elseif($item['attributes']->type == 'box'){
                    $box = ProductOther::where('barcode', $item->id)->first();
                    $selling->product_other_id = $box->id;
                }

                $selling->save();
            }
            
            foreach(Cart::session($userId)->getContent() as $item)
            {
                if($item['attributes']->type == 'repair'){
                    $repair = Repair::where('barcode', $item->id)->first();

                    if($repair){
                        $repair->status = 'returned';
                        $repair->save();
                    }
                } else if($item['attributes']->type == 'product'){
                    $product = Product::where('barcode', $item->id)->first();

                    if($product){
                        $product->status = 'sold';
                        $product->save();
                    }
                } else if($item['attributes']->type == 'box'){
                    $productOther = ProductOther::where('barcode', $item->id)->first();

                    if($productOther){
                        $productOther->quantity = $productOther->quantity - $item->quantity;
                        $productOther->save();
                    }
                }
            };

            //Store the notification
            $history = new History();
            
            $history->action = 'payment'; 
            $history->subaction = 'successful'; 
            $history->user_id = Auth::user()->getId();
            $history->table = 'payments';
            $history->payment_id = $payment->id;

            $history->save();
            
            Cart::clear();
            Cart::clearCartConditions();
            Cart::session($userId)->clear();
            Cart::session($userId)->clearCartConditions();

            return Response::json(array('success' => 'Успешно продадено!'));

        }else{
            return Response::json(['errors' => ['more_money' => ['Магазинера трябва да приеме сума равна или по-голяма от дължимата сума.']]], 401);
        }

        //Add to safe   
        //On hold for next sprint
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payments
     * @return \Illuminate\Http\Response
     */
    public function show(Payments $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payments
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
