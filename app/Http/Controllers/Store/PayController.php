<?php

namespace App\Http\Controllers\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use PayPal;
use App\PaypalPay;
use App\Http\Controllers\Controller;

class PayController extends Controller
{
    public function pay(Request $request){
        
       return PaypalPay($request);
    }

    public function getPaymentStatus(){
        $test = new PaypalPay();
        return $test->getPaymentStatus();
    }
}
