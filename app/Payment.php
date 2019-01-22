<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\DiscountCode;
use App\Product;
use App\ProductOther;
use App\ExchangeMaterial;
use App\PaymentDiscount;
use App\History;
use Cart;
use App\MaterialQuantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class Payment extends Model
{
    protected $fillable = [
        'currency',
        'method',
        'reciept',
        'ticket',
        'price',
        'given'
    ];

    protected $table = 'payments';

    public function discounts(){
        return $this->hasMany('App\PaymentDiscount');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function sellings(){
        return $this->hasMany('App\Selling');
    }

    public function exchange_materials(){
        return $this->hasMany('App\ExchangeMaterial');
    }

    public function store_payment($request, $responseType = 'JSON'){
        //Store the payment
        if(($request->given_sum >= $request->wanted_sum) || (isset($request->partner_method) && $request->partner_method == true)){
            $userId = Auth::user()->getId();

            //Check if the given sum is more or equal to the wanted sum
            $validator = Validator::make( $request->all(), [
                // 'wanted_sum' => 'required|numeric|between:0,1000000000',
                'given_sum'  => 'required|numeric|between:0,10000000',
            ]);
    
            if ($validator->fails()) {
                if($responseType == 'JSON'){
                    return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
                }else{
                    return array('errors' => $validator->errors());
                }
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
            $session_id = session()->getId();
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
                    $selling->repair_id = $item->id;
                } elseif($item['attributes']->type == 'product'){
                    $selling->product_id = $item->id;
                } elseif($item['attributes']->type == 'box'){
                    $selling->product_other_id = $item->id;
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

                        // if($product->order){
                        //     $product->order->status = 'done';
                        //     $product->order->save();
                        // }
                    }
                } else if($item['attributes']->type == 'box'){

                }
            }

            if($request->exchange_method == 'true'){
                if($request->material_id){
                    foreach($request->material_id as $key => $material){
                        if($material){
                            $exchange_material = new ExchangeMaterial();
                            $exchange_material->material_id = $material;
                            $exchange_material->payment_id = $paymentID;
                            $exchange_material->weight = $request->weight[$key];
                            $exchange_material->sum_price = $request->exchangeRows_total;
                            $exchange_material->additional_price = $request->calculating_price;

                            $exchange_material->save();

                            $material_quantity = MaterialQuantity::find($material);

                            if($material_quantity){
                                $material_quantity->quantity = $material_quantity->quantity+$request->weight[$key];
                                $material_quantity->save();
                            }
                        }
                    }
                }
            }

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
            Cart::session($session_id)->clear();
            Cart::session($session_id)->clearCartConditions();

            if($responseType == 'JSON'){
                return Response::json(['success' => ['Успешно продадено!']]);
            }else{
                return array('success' => ['Успешно продадено!']);
            }

        }else{
            if($responseType == 'JSON'){
                return Response::json(['errors' => ['more_money' => ['Магазинера трябва да приеме сума равна или по-голяма от дължимата сума.']]], 401);
            }else{
                return array('errors' => array('more_money' => ['Магазинера трябва да приеме сума равна или по-голяма от дължимата сума.']));
            }
        }
    }
}