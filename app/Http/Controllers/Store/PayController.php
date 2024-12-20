<?php

namespace App\Http\Controllers\Store;

use Cart;
use Illuminate\Http\Request;
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
use Auth;
use PayPal;
use Response;
use App\PayPalPay;
use App\DiscountCode;
use App\Http\Controllers\Controller;
use \Darryldecode\Cart\CartCondition;
use \Darryldecode\Cart\Helpers\Helpers as Helpers;
use Carbon\Carbon;

class PayController extends Controller
{
    public function pay(Request $request){

       return PayPalPay($request);
    }

    public function getPaymentStatus(){
        $test = new PayPalPay();
        return $test->getPaymentStatus();
    }

    public function setDiscount(Request $request, $barcode){
        $userId = Auth::user()->getId();
        $discount = new DiscountCode;
        $result = $discount->check($barcode);
        $setDiscount = false;
        $isEligible = false;

        if (!$result) {
            $setDiscount = false;
            return response()->json(['message' => __('Баркодът не е намерен')], 200);
        }

        if($result){
            $setDiscount = $result->discount;
            $isGlobal = $result->is_global == 'yes';
            // Firstly check if the user is part of a group
            if ( isset($result->group) ) {
                $isEligible = $result->group->users->contains('id', $userId);
            }
            
            if ( !$result->users->isEmpty() ) {
                $isEligible = $result->users->contains('id', $userId);
            }

            if ($isGlobal) {
                $isEligible = true;
            }

            if (!$isEligible) {
                $setDiscount = false;
            }

            // Validate Discount's expiration date
            if($result->lifetime=='no' && isset($result->expires)){
                $expires = Carbon::createFromFormat('d-m-Y', $result->expires);
                if($expires->lt(Carbon::now())){
                    $setDiscount = false;
                }
            }
        }

        if($setDiscount){
            $condition = new CartCondition(array(
                'name' => $setDiscount,
                'type' => 'discount',
                'target' => 'subtotal',
                'value' => '-'.$setDiscount.'%',
                'attributes' => array(
                    'discount_id' => $result->id,
                    // 'discount_id' => $setDiscount,
                    'discount' => $setDiscount,
                    'barcode' => $barcode,
                    'description' => 'Value added tax',
                    'more_data' => 'more data here'
                )
            ));
            Cart::session($userId)->condition($condition);
            $total = round(Cart::session($userId)->getTotal(),2);
            $subTotal = round(Cart::session($userId)->getSubTotal(),2);
            $cartConditions = Cart::session($userId)->getConditions();
            $conds = array();
            $priceCon = 0;

            if(count($cartConditions) > 0){
                foreach(\Cart::session($userId)->getConditions() as $cc){
                    $priceCon += $cc->getCalculatedValue($subTotal);
                }
            }

            foreach($cartConditions as $key => $condition){
                $conds[$key]['value'] = $condition->getValue();
                $conds[$key]['attributes'] = $condition->getAttributes();
            }

            $dds = round($subTotal - ($subTotal/1.2), 2);
            return Response::json(array('success' => true, 'total' => $total, 'subtotal' => $subTotal, 'condition' => $conds, 'priceCon' => $priceCon, 'dds' => $dds));
        } else{
            return Response::json(array('success' => false));
        }
    }

    public function removeDiscount(Request $request, $name){
        $userId = Auth::user()->getId();
        $conds = array();
        \Cart::removeCartCondition($name);
        \Cart::session($userId)->removeCartCondition($name);

        $cartConditions = \Cart::session($userId)->getConditionsByType('discount');
        foreach($cartConditions as $key => $condition){
            $conds[$key]['value'] = $condition->getValue();
            $conds[$key]['name'] = $condition->getValue();
            $conds[$key]['attributes'] = $condition->getAttributes();
        }

        $total = round(\Cart::session($userId)->getTotal(),2);
        $subTotal = round(\Cart::session(Auth::user()->getId())->getSubTotal(),2);
        $cartConditions = \Cart::session(Auth::user()->getId())->getConditions();
        $condition = \Cart::getConditions('discount');
        $priceCon = 0;

        if(count($cartConditions) > 0){
            foreach(\Cart::session(Auth::user()->getId())->getConditionsByType('discount') as $cc){
                $priceCon += $cc->getCalculatedValue($subTotal);
            }
        } else{
            $priceCon = 0;
        }

        return Response::json(array('success' => true, 'total' => $total, 'subtotal' => $subTotal, 'condition' => $conds, 'con' => $priceCon));
    }
}
