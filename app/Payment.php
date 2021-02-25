<?php

namespace App;

use App\Http\Controllers\SellingController;
use App\MaterialQuantity;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\DiscountCode;
use App\Product;
use App\ProductOther;
use App\ExchangeMaterial;
use App\PaymentDiscount;
use App\History;
use App\OrderItem;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use App\CashRegister;
use App\Expense;
use App\Currency;

class Payment extends Model{

    protected $fillable = array(
        'currency',
        'method',
        'receipt',
        'ticket',
        'price',
        'given',
        'store_id'
    );

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
        $userId = Auth::user()->getId();

        // Make sure the button is not clicked on an empty cart with no Exchange
        if(Cart::session($userId)->getConditions()->count() == 0 && $request->exchangeRows_total == 0){
            return Response::json(array('errors' => array('Плащане не може да бъде извършено на празна количка')), 401);
        }

        //Store the payment
        if(($request->given_sum >= $request->wanted_sum) || (isset($request->partner_method) && $request->partner_method == true || (isset($request->return_sum) && $request->return_sum >= 0))){

            //Check if the given sum is more or equal to the wanted sum
            $validator = Validator::make( $request->all(), [
                'given_sum'  => 'required|numeric|between:0,10000000',
            ]);

            if($validator->fails()){
                if($responseType == 'JSON'){
                    return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
                }
                else{
                    return array('errors' => $validator->errors());
                }
            }

            $payment = new Payment();
            $payment->currency_id = $request->pay_currency;
            $payment->price = $request->wanted_sum;
            $payment->given = $request->given_sum;
            $payment->info = $request->info;
            $payment->store_id = Auth::user()->getStore()->id;
            $payment->user_id = $userId;

            $payment->method = ($request->pay_method == 'false'?'cash':'post');
            $payment->receipt = ($request->modal_receipt == 'no'?'no':'yes');
            $payment->ticket = ($request->modal_ticket == 'no'?'no':'yes');
            $payment->certificate = ($request->modal_certificate=='no'?'no':'yes');

            $payment->save();


            // Add the payment to the Cash Register
            $cashRegister = new CashRegister();
            $cashRegister->RecordIncome($request->wanted_sum, $request->pay_currency, $payment->store_id);


            $paymentID = $payment->id;
            $session_id = session()->getId();
            //Saving cart's conditions(discounts only) to the database.
            $cartConditions = Cart::session($userId)->getConditions();
            foreach($cartConditions as $condition){
                if($condition->getName() !== 'ДДС'){
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
            }

            $items = array();

            Cart::session($userId)->getContent()->each(function($item) use (&$items){
                $items[] = $item;
            });

            $certificates = array();
            $receipts = array(route('selling_receipt', array(
                'id' => $payment->id,
                'type' => 'order',
                'orderId' => $payment->id
            )));

            //Saving the sold item to a database
            foreach($items as $item){
                $selling = new Selling();
                $selling->weight = $item['attributes']->weight;
                $selling->quantity = $item->quantity;
                $selling->price = $item->price;
                $selling->payment_id = $payment->id;
                $selling->order_id = $payment->id;

                if($item['attributes']->type == 'repair'){
                    $selling->repair_id = $item->attributes->product_id;
                    $receipts[] = route('repair_receipt', array('id'=>$item->attributes->product_id));
                }
                elseif($item['attributes']->type == 'product'){
                    $selling->product_id = $item->attributes->product_id;
                    $certificates[] = route('selling_certificate', ['id' => $item->attributes->product_id, 'orderId' => null]);
                    // $receipts[] = route('selling_receipt', ['id' => $item->attributes->product_id, 'type' => 'product', 'orderId' => null]);
                }
                elseif($item['attributes']->type == 'box'){
                    $selling->product_other_id = $item->attributes->product_id;
                    // $receipts[] = route('selling_receipt', ['id' => $item->attributes->product_id, 'type' => 'box', 'orderId' => null]);
                }
                elseif($item['attributes']->type == 'order'){
                    $selling->order_id = $item->attributes->product_id;
                    $certificates[] = route('selling_certificate', ['id' => $item->attributes->product_id, 'orderId' => $item->attributes->product_id]);
                    // $receipts[] = route('order_receipt', ['id' => $item->attributes->product_id]);
                }

                $selling->save();
            }

            foreach(Cart::session($userId)->getContent() as $item){
                if($item->attributes->type == 'repair'){
                    $repair = Repair::where('id', $item->attributes->product_id)->first();

                    if($repair){
                        $repair->status = 'returned';
                        $repair->save();
                    }
                }
                elseif($item->attributes->type == 'order'){
                    $order = Order::where('id', $item->attributes->product_id)->first();

                    if($order){
                        $order->status = 'done';
                        $order->save();
                    }
                }
                elseif($item->attributes->type == 'product'){
                    $product = Product::where('id',$item->attributes->product_id)->first();

                    if($product){
                        $product->status = 'sold';
                        $product->save();

                        if($item->attributes->order != ''){
                            $order_item = OrderItem::find($item->attributes->order_item_id);

                            $order = Order::find($item->attributes->order);
                            $materials = $order->materials;

                            if($materials){
                                foreach($materials as $material){
                                    if($material->material_id == $order->material_id){
                                        $material->weight = $material->weight - $order_item->product->weight;
                                        if($material->weight - $order_item->product->weight <= 0){
                                            $material->weight = 0;
                                        }

                                        $material->save();
                                    }
                                }
                            }

                            $order_item->delete();

                            $order->earnest_used = 'yes';
                            $order->save();

                            if($order && count($order->items) == 0){
                                $order->status = 'done';
                                $order->save();
                            }
                        }
                    }
                }
            }

            if($request->exchange_method == 'true'){
                if($request->data_material_price){
                    // If the Cart's empty then this operation is for Buying Materials
                    // In such case, we need to add a new Selling for the transaction
                    if(empty($items)){
                        $selling = new Selling();
                        $selling->product_id = 'exchange_material';
                        $selling->payment_id = $payment->id;
                        $selling->order_id = $payment->id;
                        $selling->save();
                    }

                    foreach($request->data_material_price as $key => $material){
                        if($material){
                            $exchange_material = new ExchangeMaterial();
                            $exchange_material->material_id = $material['material_id'];
                            $exchange_material->payment_id = $payment->id;
                            $exchange_material->order_id = $payment->id;
                            $exchange_material->weight = $request->weight[$key];
                            $exchange_material->sum_price = $request->exchangeRows_total;
                            $exchange_material->additional_price = $request->calculating_price;
                            $exchange_material->material_price_id = $material['material_price'];
                            $exchange_material->save();

                            $material_quantity = MaterialQuantity::where(array(
                                array('material_id',$material['material_id']),
                                array('store_id',Auth::user()->getStore()->id)
                            ))->first();

                            if($material_quantity){
                                $material_quantity->quantity += $request->weight[$key];
                                $material_quantity->save();
                            }
                        }
                    }

                    $expenseRegister = new CashRegister();
                    $expenseRegister->RecordExpense($request->exchangeRows_total, false, Auth::user()->getStore()->id);

                    Expense::create(array(
                        'type_id' => 1,
                        'amount' => $request->exchangeRows_total,
                        'currency' => Currency::where('default', 'yes')->first()->id,
                        'user_id' => Auth::user()->id,
                        'additional_info' => 'Изкупуване на материали'
                    ));
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

            // Orders with request for no certificates
            if(isset($request->modal_certificate) && $request->modal_certificate == 'exclude'){
                $certificates = array();
            }

            if($responseType == 'JSON'){
                return Response::json(['success' => ['Успешно продадено!'], 'certificates' => $certificates, 'receipts' => $receipts]);
            }
            else{
                return array('success' => ['Успешно продадено!', 'certificates' => $certificates, 'receipts' => $receipts]);
            }
        }
        else{
            if($responseType == 'JSON'){
                return Response::json(['errors' => ['more_money' => ['Магазинера трябва да приеме сума равна или по-голяма от дължимата сума.']]], 401);
            }
            else{
                return array('errors' => array('more_money' => ['Магазинера трябва да приеме сума равна или по-голяма от дължимата сума.']));
            }
        }
    }
}
