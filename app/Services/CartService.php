<?php
namespace App\Services;

use Illuminate\Http\Request;
use Cart;
use Auth;
use Carbon\Carbon;
use App\DiscountCode;
use Response;
use Illuminate\Http\JsonResponse;
use \Darryldecode\Cart\CartCondition as CartCondition;

class CartService {
    public function storeDiscount(Request $request, string $barcode = '')
    {
        $user           = Auth::user();
        $userRole       = $user->role;
        $userId         = $user->getId();
        $discount       = new DiscountCode;
        $discountResult = $discount->check($barcode);
        $setDiscount    = $discountResult->discount;
        $isEligible     = $discountResult->users->contains('id', $userId);
        $isGlobal       = $discountResult->is_global;

        if (!$discountResult) {
            $setDiscount = false;
            return Response::json(['message' => 'Discount code not found'], 404);
        }

        if (!($isEligible && $isGlobal == 'yes')) {
            $setDiscount = false;
        }

        if( $discountResult->lifetime == 'no' && isset($discountResult->expires) ) {
            $expires = Carbon::createFromFormat('d-m-Y', $discountResult->expires);
            if ($expires->lt(Carbon::now())) {
                $setDiscount = false;
            }
        }

        if (!$setDiscount) {
            return Response::json(['success' => false]);
        }

        $condition = new CartCondition([
            'name' => $setDiscount,
            'type' => 'discount',
            'target' => 'subtotal',
            'value' => '-'.$setDiscount.'%',
            'attributes' => [
                'discount' => $setDiscount,
                'discount_id' => $discountResult->id,
                'barcode' => $barcode,
                'description' => 'Value added tax',
                'more_data' => 'more data here'
            ]
        ]);

        Cart::session($userId)->condition($condition);
        $total          = round(Cart::session($userId)->getTotal(),2);
        $subTotal       = round(Cart::session($userId)->getSubTotal(),2);
        $cartConditions = Cart::session($userId)->getConditions();
        $conds          = [];
        $priceCon       = 0;

        if(count($cartConditions) > 0){
            foreach(Cart::session($userId)->getConditions() as $cc){
                $priceCon += $cc->getCalculatedValue($subTotal);
            }
        }

        foreach($cartConditions as $key => $condition){
            $conds[$key]['value'] = $condition->getValue();
            $conds[$key]['attributes'] = $condition->getAttributes();
        }

        $dds = round($subTotal - ($subTotal/1.2), 2);
        return Response::json([
            'success' => true,
            'total' => $total,
            'subtotal' => $subTotal,
            'condition' => $conds,
            'priceCon' => $priceCon,
            'dds' => $dds
        ]);
    }
}
