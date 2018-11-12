<?php

namespace App\Http\Controllers\Store;
use Cart;
use Response;
use App\Product;
use App\Invoice;
use App\IPNStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;
use App\ProductOther;

class CartController extends BaseController
{
    /**
     * @var ExpressCheckout
     */
    protected $provider;
    public function __construct()
    {
        $this->provider = new ExpressCheckout();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_id = session()->getId();

        $total = round(Cart::session($session_id)->getTotal(),2);
        $subtotal = round(Cart::session($session_id)->getSubTotal(),2);
        $quantity = Cart::session($session_id)->getTotalQuantity();
        
        $items = [];
        
        Cart::session($session_id)->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        return \View::make('store.pages.cart', array('items' => $items, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity));
    }

    public function addItem($item, $quantity = 1){
        $session_id = session()->getId();

        $product = Product::where('barcode', $item)->first();
        $type = '';
        $itemQuantity = 1;

        if($product){
            $item = $product;
            $type = 'product';
        }else{
            $box = ProductOther::where('barcode', $item)->first();
            
            if($box){
                $item = $box;
                $type = 'product';
            }else{
                $model = Model::where('barcode', $item)->first();

                if($model){
                    $item = $model;
                    $item->price = 0;
                    $type = 'model';
                }
            }

            if($type == 'box'){
                $itemQuantity = $quantity;
            }
        }

        if($item){
            Cart::session($session_id)->add(array(
                'id' => $item->barcode,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $itemQuantity,
                'attributes' => array(
                    'weight' => $item->weight,
                    'price' => $item->price,
                    'name' => $item->name,
                    'product_id' => $item->id,
                    'photo' => asset("uploads/products/" . $item->photos->first()['photo']),
                    'type' => 'product'
                )
            ));

            $total = round(Cart::session($session_id)->getTotal(),2);
            $subtotal = round(Cart::session($session_id)->getSubTotal(),2);
            $quantity = Cart::session($session_id)->getTotalQuantity();

            return Response::json(array('success' => true, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity));
        }else{
            return Response::json(array('success' => true, 'not_found' => 'The item is not found'));
        }
    }

    // public function pay(){
    //    $provider = new ExpressCheckout;      // To use express checkout.
    //    //$provider = new AdaptivePayments; 

    //     //$provider = PayPal::setProvider('express_checkout');      // To use express checkout(used by default).
    //     //$provider = PayPal::setProvider('adaptive_payments');     // To use adaptive payments.

    //     $data['items'] = [
    //         [
    //             'name' => 'Product 1',
    //             'price' => 9.99,
    //             'qty' => 1
    //         ],
    //         [
    //             'name' => 'Product 2',
    //             'price' => 4.99,
    //             'qty' => 2
    //         ]
    //     ];

    //     $data['invoice_id'] = 1;
    //     $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
    //     $data['return_url'] = url('/');
    //     $data['cancel_url'] = url('/');

    //     $total = 0;
    //     foreach($data['items'] as $item) {
    //         $total += $item['price']*$item['qty'];
    //     }

    //     $data['total'] = $total;
        
    //     //$response = $provider->createPayRequest($data);

    //     $response = $provider->setExpressCheckout($data);

    //     //$redirect_url = $provider->getRedirectUrl('approved', $response['payKey']);
        
    //     return redirect($response['paypal_link']);


    // }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getExpressCheckout(Request $request)
    {
        $recurring = ($request->get('mode') === 'recurring') ? true : false;
        $cart = $this->getCheckoutData($recurring);
        try {
            $response = $this->provider->setExpressCheckout($cart, $recurring);

            dd($response);
            return redirect($response['paypal_link']);
        } catch (\Exception $e) {
            $invoice = $this->createInvoice($cart, 'Invalid');
            session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order $invoice->id!"]);
        }
    }
    /**
     * Process payment on PayPal.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getExpressCheckoutSuccess(Request $request)
    {
        $recurring = ($request->get('mode') === 'recurring') ? true : false;
        $token = $request->get('token');
        $PayerID = $request->get('PayerID');
        $cart = $this->getCheckoutData($recurring);
        // Verify Express Checkout Token
        $response = $this->provider->getExpressCheckoutDetails($token);
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            if ($recurring === true) {
                $response = $this->provider->createMonthlySubscription($response['TOKEN'], 9.99, $cart['subscription_desc']);
                if (!empty($response['PROFILESTATUS']) && in_array($response['PROFILESTATUS'], ['ActiveProfile', 'PendingProfile'])) {
                    $status = 'Processed';
                } else {
                    $status = 'Invalid';
                }
            } else {
                // Perform transaction on PayPal
                $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
                $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
            }
            $invoice = $this->createInvoice($cart, $status);
            if ($invoice->paid) {
                session()->put(['code' => 'success', 'message' => "Order $invoice->id has been paid successfully!"]);
            } else {
                session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order $invoice->id!"]);
            }
            return redirect('/');
        }
    }
    public function getAdaptivePay()
    {
        $this->provider = new AdaptivePayments();
        $data = [
            'receivers'  => [
                [
                    'email'   => 'johndoe@example.com',
                    'amount'  => 10,
                    'primary' => true,
                ],
                [
                    'email'   => 'janedoe@example.com',
                    'amount'  => 5,
                    'primary' => false,
                ],
            ],
            'payer'      => 'EACHRECEIVER', // (Optional) Describes who pays PayPal fees. Allowed values are: 'SENDER', 'PRIMARYRECEIVER', 'EACHRECEIVER' (Default), 'SECONDARYONLY'
            'return_url' => url('payment/success'),
            'cancel_url' => url('payment/cancel'),
        ];
        $response = $this->provider->createPayRequest($data);
        dd($response);
    }
    /**
     * Parse PayPal IPN.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function notify(Request $request)
    {
        if (!($this->provider instanceof ExpressCheckout)) {
            $this->provider = new ExpressCheckout();
        }
        $post = [
            'cmd' => '_notify-validate'
        ];
        $data = $request->all();
        foreach ($data as $key => $value) {
            $post[$key] = $value;
        }
        $response = (string) $this->provider->verifyIPN($post);
        $ipn = new IPNStatus();
        $ipn->payload = json_encode($post);
        $ipn->status = $response;
        $ipn->save();            
    }
    /**
     * Set cart data for processing payment on PayPal.
     *
     * @param bool $recurring
     *
     * @return array
     */
    protected function getCheckoutData($recurring = false)
    {
        $data = [];
        $order_id = Invoice::all()->count() + 1;
        if ($recurring === true) {
            $data['items'] = [
                [
                    'name'  => 'Monthly Subscription '.config('paypal.invoice_prefix').' #'.$order_id,
                    'price' => 0,
                    'qty'   => 1,
                ],
            ];
            $data['return_url'] = url('/paypal/ec-checkout-success?mode=recurring');
            $data['subscription_desc'] = 'Monthly Subscription '.config('paypal.invoice_prefix').' #'.$order_id;
        } else {
            $data['items'] = [
                [
                    'name'  => 'Product 1',
                    'price' => 9.99,
                    'qty'   => 1,
                ],
                [
                    'name'  => 'Product 2',
                    'price' => 4.99,
                    'qty'   => 2,
                ],
            ];
            $data['return_url'] = url('/paypal/ec-checkout-success');
        }
        $data['invoice_id'] = config('paypal.invoice_prefix').'_'.$order_id;
        $data['invoice_description'] = "Order #$order_id Invoice";
        $data['cancel_url'] = url('/');
        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }
        $data['total'] = $total;
        return $data;
    }
    /**
     * Create invoice.
     *
     * @param array  $cart
     * @param string $status
     *
     * @return \App\Invoice
     */
    protected function createInvoice($cart, $status)
    {
        $invoice = new Invoice();
        $invoice->title = $cart['invoice_description'];
        $invoice->price = $cart['total'];
        if (!strcasecmp($status, 'Completed') || !strcasecmp($status, 'Processed')) {
            $invoice->paid = 1;
        } else {
            $invoice->paid = 0;
        }
        $invoice->save();
        collect($cart['items'])->each(function ($product) use ($invoice) {
            $item = new Item();
            $item->invoice_id = $invoice->id;
            $item->item_name = $product['name'];
            $item->item_price = $product['price'];
            $item->item_qty = $product['qty'];
            $item->save();
        });
        return $invoice;
    }

    public function removeItem($item){
        $session_id = session()->getId();

        $remove = Cart::session($session_id)->remove($item);

        $total = round(Cart::session($session_id)->getTotal(),2);
        $subtotal = round(Cart::session($session_id)->getSubTotal(),2);
        $quantity = Cart::session($session_id)->getTotalQuantity();

        if($remove){
            return Response::json(array('success' => true, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity));
        }
    }

}
