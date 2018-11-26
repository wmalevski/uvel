<?php

namespace App\Http\Controllers\Store;
use Cart;
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
use Auth;
use PayPal;
use Response;
use App\PaypalPay;
use App\DiscountCode;
use App\Http\Controllers\Controller;
use \Darryldecode\Cart\CartCondition as CartCondition;
use \Darryldecode\Cart\Helpers\Helpers as Helpers;

Class CartCustomCondition extends CartCondition {
    public function apply($totalOrSubTotalOrPrice, $conditionValue){
        if( $this->valueIsPercentage($conditionValue) )
        {
            if( $this->valueIsToBeSubtracted($conditionValue) )
            {
                $price = $totalOrSubTotalOrPrice;
                if($this->getTarget() == 'subtotal'){
                    $price = \Cart::getSubTotal();
                }elseif($this->getTarget() == 'total'){
                    $price = \Cart::getTotal();
                }
                
                $value = Helpers::normalizePrice( $this->cleanValue($conditionValue) );
                $this->parsedRawValue = $price * ($value / 100);
                $result = floatval($totalOrSubTotalOrPrice - $this->parsedRawValue);
            }
            else if ( $this->valueIsToBeAdded($conditionValue) )
            {
                $value = Helpers::normalizePrice( $this->cleanValue($conditionValue) );

                $this->parsedRawValue = $totalOrSubTotalOrPrice * ($value / 100);

                $result = floatval($totalOrSubTotalOrPrice + $this->parsedRawValue);
            }
            else
            {
                $value = Helpers::normalizePrice($conditionValue);

                $this->parsedRawValue = $totalOrSubTotalOrPrice * ($value / 100);

                $result = floatval($totalOrSubTotalOrPrice + $this->parsedRawValue);
            }
        }

        // if the value has no percent sign on it, the operation will not be a percentage
        // next is we will check if it has a minus/plus sign so then we can just deduct it to total/subtotal/price
        else
        {
            if( $this->valueIsToBeSubtracted($conditionValue) )
            {
                $this->parsedRawValue = Helpers::normalizePrice( $this->cleanValue($conditionValue) );

                $result = floatval($totalOrSubTotalOrPrice - $this->parsedRawValue);
            }
            else if ( $this->valueIsToBeAdded($conditionValue) )
            {
                $this->parsedRawValue = Helpers::normalizePrice( $this->cleanValue($conditionValue) );

                $result = floatval($totalOrSubTotalOrPrice + $this->parsedRawValue);
            }
            else
            {
                $this->parsedRawValue = Helpers::normalizePrice($conditionValue);

                $result = floatval($totalOrSubTotalOrPrice + $this->parsedRawValue);
            }
        }

        // Do not allow items with negative prices.
        return $result < 0 ? 0.00 : $result;
    }

    public function getCalculatedValue($totalOrSubTotalOrPrice)
    {
        $this->apply($totalOrSubTotalOrPrice, $this->getValue());

        return $this->parsedRawValue;
    }
}

class PayController extends Controller
{
    public function pay(Request $request){
        
       return PaypalPay($request);
    }

    public function getPaymentStatus(){
        $test = new PaypalPay();
        return $test->getPaymentStatus();
    }

    public function setDiscount(Request $request, $barcode){
        
        $userId = Auth::user()->getId(); 

        if(strlen($barcode) == 13){
            $discount = new DiscountCode;
            $result = json_encode($discount->check($barcode));

            if($result == 'true'){
                $card = DiscountCode::where('barcode', $barcode)->first();
                $setDiscount = $card->discount;
            }
        }
        

        if(isset($setDiscount)){
            $condition = new CartCustomCondition(array(
                'name' => $setDiscount,
                'type' => 'discount',
                'target' => 'subtotal',
                'value' => '-'.$setDiscount.'%',
                'attributes' => array(
                    'discount_id' => $setDiscount,
                    'description' => 'Value added tax',
                    'more_data' => 'more data here'
                )
            ));

            Cart::condition($condition);
            Cart::session($userId)->condition($condition);

            $total = round(Cart::session($userId)->getTotal(),2);
            $subtotal = round(Cart::session($userId)->getSubTotal(),2);
            $subTotal = round(Cart::session($userId)->getSubTotal(),2);
            $cartConditions = Cart::session($userId)->getConditions();
            $conds = array();
            $priceCon = 0;
    
            if(count($cartConditions) > 0){
                foreach(Cart::session($userId)->getConditions() as $cc){
                    $priceCon += $cc->getCalculatedValue($subTotal);
                }
            } else{
                $priceCon = 0;
            }

            foreach($cartConditions as $key => $condition){
                $conds[$key]['value'] = $condition->getValue();
                $conds[$key]['attributes'] = $condition->getAttributes();
            }

            $dds = round($subTotal - ($subTotal/1.2), 2);

            return Response::json(array('success' => true, 'total' => $total, 'subtotal' => $subtotal, 'condition' => $conds, 'priceCon' => $priceCon, 'dds' => $dds));  
        } else{
            return Response::json(array('success' => true));  
        }
    }
}
