<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
use PayPal;

class PayPalPay extends Model
{
    private $_api_context;

    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function payWithpaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
            $item_1 = new Item();
            $item_1->setName('Item 1') /** item name **/
                        ->setCurrency('USD')
                        ->setQuantity(1)
                        ->setPrice($request->get('amount')); /** unit price **/

            $item_list = new ItemList();
            $item_list->setItems(array($item_1));

            $amount = new Amount();
            $amount->setCurrency('USD')->setTotal($request->get('amount'));

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Your transaction description');

            $redirect_urls = new RedirectUrls();
                    $redirect_urls->setReturnUrl(URL::route('paypal_status')) /** Specify return URL **/
                        ->setCancelUrl(URL::route('paypal_status'));

            $payment = new Payment();
                    $payment->setIntent('Sale')
                        ->setPayer($payer)
                        ->setRedirectUrls($redirect_urls)
                        ->setTransactions(array($transaction));
            try {
                $payment->create($this->_api_context);
            } catch (\PayPal\Exception\PPConnectionException $ex) {
                if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                                return Redirect::route('paypal_pay');
                } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                                return Redirect::route('paypal_pay');
                }
            }

            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }
            /** add payment ID to session **/
            Session::put('paypal_payment_id', $payment->getId());

            if (isset($redirect_url)) {
            /** redirect to paypal **/
                return Redirect::away($redirect_url);
            }

            \Session::put('error', 'Unknown error occurred');
                    return Redirect::route('paypal_pay');
        }

        public function getPaymentStatus()
        {
            /** Get the payment ID before session clear **/
            $payment_id = Session::get('paypal_payment_id');

            /** clear the session payment ID **/
            Session::forget('paypal_payment_id');
            if (empty($request->input('PayerID')) || empty($request->input('token'))) {
                \Session::put('error', 'Payment failed');
                return Redirect::route('cart');
            }

            $payment = Payment::get($payment_id, $this->_api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId($request->input('PayerID'));
            /**Execute the payment **/
            $result = $payment->execute($execution, $this->_api_context);

            if ($result->getState() == 'approved') {
                \Session::put('success', 'Payment success');

                $payment = new UserPayment();
                return $payment->storePayment();
            }

            \Session::put('error', 'Payment failed');

            return Redirect::route('cart');
        }
}
