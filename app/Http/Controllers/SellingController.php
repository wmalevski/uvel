<?php

namespace App\Http\Controllers;

use App\Selling;
use Illuminate\Http\Request;
use App\RepairType;
use Cart;
use App\Product;
use App\Repair;
use Auth;
use App\Currency;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\JsonResponse;
use App\DiscountCode;
use Response;
use App\ProductOther;
use App\DailyReport;
use Carbon\Carbon;
use App\Payment;
use \Darryldecode\Cart\CartCondition as CartCondition;
use \Darryldecode\Cart\Helpers\Helpers as Helpers;
use App\MaterialQuantity;
use App\OrderItem;
use Mail;
use App\Material;

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

class SellingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repairTypes = RepairType::all();
        $discounts = DiscountCode::all();
        $currencies = Currency::all();
        $subTotal = Cart::session(Auth::user()->getId())->getSubTotal();
        $cartConditions = Cart::session(Auth::user()->getId())->getConditions();
        $condition = Cart::getConditions('discount');
        $priceCon = 0;

        $materials = Material::take(env('SELECT_PRELOADED'))->get();

        $partner = false;
        if(count($cartConditions) > 0){
            foreach(Cart::session(Auth::user()->getId())->getConditions() as $cc){
                $priceCon += $cc->getCalculatedValue($subTotal);

                if($cc->getAttributes()['partner'] != 'false'){
                    $partner = true;
                }
            }
        } else{
            $priceCon = 0;
        }
        $items = [];
        
        Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        $dds = round($subTotal - ($subTotal/1.2), 2);

        $allSold = Payment::where([
            ['method', '=', 'cash'],
            ['store_id', '=', Auth::user()->getStore()]
        ])->whereDate('created_at', Carbon::today())->sum('given');
            
        $todayReport = DailyReport::where('store_id', Auth::user()->getStore())->whereDate('created_at', Carbon::today())->get();
        
        if(count($todayReport)){
            $todayReport = 'true';
        }else{
            $todayReport = 'false';
        }
        //To add kaparo from the orders when branches are merged
        
        return \View::make('admin/selling/index', array('priceCon' => $priceCon, 'repairTypes' => $repairTypes, 'items' => $items, 'discounts' => $discounts, 'conditions' => $cartConditions, 'currencies' => $currencies, 'dds' => $dds, 'materials' => $materials, 'todayReport' => $todayReport, 'partner' => $partner));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Selling  $selling
     * @return \Illuminate\Http\Response
     */
    public function show(Selling $selling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Selling  $selling
     * @return \Illuminate\Http\Response
     */
    public function edit(Selling $selling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Selling  $selling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Selling $selling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Selling  $selling
     * @return \Illuminate\Http\Response
     */
    public function destroy(Selling $selling)
    {
        //
    }

    public function sell(Request $request){
        $type = "product";

        // $tax = new \Darryldecode\Cart\CartCondition(array(
        //     'name' => 'ДДС',
        //     'type' => 'tax',
        //     'target' => 'subtotal',
        //     'value' => '+20%',
        //     'attributes' => array(
        //         'description' => 'Value added tax',
        //         'more_data' => 'more data here'
        //     ),
        //     'order' => 2
        // ));

        // Cart::condition($tax);
        // Cart::session(Auth::user()->getId())->condition($tax);

        if($request->amount_check == false){
            if($request->type_repair == true){
                $item = Repair::where(
                    [
                        ['barcode', '=', $request->barcode],
                        ['status', '=', 'done']
                    ]       
                )->first();
                $type = "repair";
            }else{
                if($request->barcode){
                    $item = Product::where('barcode', $request->barcode)->first();
                } else if($request->catalog_number){
                    $item = Product::where('code', $request->catalog_number)->first();
                }

                $type = "product";

                // if($item->order){
                //     $checkOrder = 
                // } 
            }

            if($item){
                if($item->status == 'selling'){
                    return Response::json(['errors' => array(
                        'selling' => 'Продукта вмомента принадлежи на друга продажба.'
                    )], 401);
                }

                if($item->status == 'travelling'){
                    return Response::json(['errors' => array(
                        'selling' => 'Продукта вмомента е на път.'
                    )], 401);
                }
    
                if($type == "product"){
                    $item->status = 'selling';
                    $item->save();

                    //check if carates are 14k
                    $item_material = $item->material;
                    if($item_material->carat != '14'){
                        $calculated_weight = floor(($item_material->carat/14*$item->weight) * 100) / 100;
                    }else{
                        $calculated_weight = $item->weight;
                    }


                } else if($type == 'repair'){
                    $item->status = 'returning';
                    $item->save();

                    $calculated_weight = '';
                }           
            }
        }else{
            if($request->barcode){
                $item = ProductOther::where('barcode', $request->barcode)->first();

                $type = "box";
            } else if($request->catalog_number){
                $item = ProductOther::where('code', $request->catalog_number)->first();

                $type = "box";
            }

           if($item){
            if($item->quantity < $request->quantity){
                return Response::json(['errors' => array(
                    'quantity' => 'Системата няма това количество, което желаете да продадете.'
                )], 401);
            }
            
            $item->quantity = $item->quantity-$request->quantity;
            $item->save();

            $calculated_weight = '';
           }
        }

        if($item){       
            $userId = Auth::user()->getId(); // or any string represents user identifier
            
            $find = Cart::session($userId)->get($item->barcode);

            if($find && $request->amount_check == false) {
                
            }else{
                if($item->status == 'sold'){
                    $item->price = 0;
                }

                if($type == "repair"){
                    Cart::session($userId)->add(array(
                        'id' => $item->barcode,
                        'name' => 'Връщане на ремонт - '.$item->customer_name,
                        'price' => $item->price,
                        'quantity' => 1,
                        'attributes' => array(
                            'weight' => $item->weight,
                            'type' => 'repair'
                        )
                    ));
            
                }else{
                    if($item->material){
                        $carat = $item->material->carat;
                    }else{
                        $carat = 0;
                    }
                    
                    $order = '';
                    $order_item_id = '';
                    if($type == 'product'){
                        $order_item = OrderItem::where('product_id', $item->id)->first();
                        
                        if($order_item){
                            $order = $order_item->order_id;
                            $order_item_id = $order_item->id;
                        }
                    }

                    Cart::session($userId)->add(array(
                        'id' => $item->barcode,
                        'name' => $item->name,
                        'price' => $item->price,
                        'quantity' => $request->quantity,
                        'attributes' => array(
                            'carat' => $carat,
                            'weight' => $item->weight,
                            'type' => $type,
                            'calculated_weight' => $calculated_weight,
                            'order' => $order,
                            'order_item_id' => $order_item_id
                        )
                    ));
                }
            }

        

            $total = round(Cart::session($userId)->getTotal(),2);
            $subtotal = round(Cart::session($userId)->getSubTotal(),2);
            $quantity = Cart::session($userId)->getTotalQuantity();

            $items = [];
            
            Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
            {
                $items[] = $item;
            });

            $table = '';
            foreach($items as $item){
                $table .= View::make('admin/selling/table',array('item'=>$item))->render();
            }

            $dds = round($subtotal - ($subtotal/1.2), 2);

            return Response::json(array('success' => true, 'table' => $table, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity, 'dds' => $dds));  

        }else{
            return Response::json(array('success' => false)); 
        }
    }

    public function getCartTable(){
        $userId = Auth::user()->getId(); // or any string represents user identifier

        $total = round(Cart::session($userId)->getTotal(),2);
        $subtotal = round(Cart::session($userId)->getSubTotal(),2);
        $quantity = Cart::session($userId)->getTotalQuantity();

        $items = [];
        
        Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        $table = '';
        foreach($items as $item){
            $table .= View::make('admin/selling/table',array('item'=>$item))->render();
        }

        return Response::json(array('success' => true, 'table' => $table, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity));  
    }

    public function clearCart(){
        $userId = Auth::user()->getId(); 
        
        Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
        {
            $product = Product::where('barcode', $item->id)->first();
            $product_box = ProductOther::where('barcode', $item->id)->first();
            $repair = Repair::where('barcode', $item->id)->first(); 
            if($product){
                $product->status = 'available';
                $product->save();
            }else if($product_box){
                $product_box->quantity += $item->quantity;
                $product_box->save();
            }else if($repair){
                $repair->status = 'done';
                $repair->save();
            }
        });

        Cart::clear();
        Cart::clearCartConditions();
        Cart::session($userId)->clear();
        Cart::session($userId)->clearCartConditions();

        return redirect()->route('admin');
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
        }else{
            $result = false;
            $setDiscount = $barcode;
        }
        

        if(isset($setDiscount)){
            $partner = 'false';

            if(isset($card)){
                if($card->user){
                    if($card->user->isA('corporate_partner')){
                        $partner = 'true';
                    }
                }
                
            }

            $partner_id = '';

            if($card->user){
                $partner_id = $card->user->id;
            }

            $removeDDS = new CartCustomCondition(array(
                'name' => 'remove_dds',
                'type' => 'tax',
                'target' => 'subtotal',
                'value' => '/1.2',
                'attributes' => array(
                    'partner' => $partner,
                    'partner_id' => $partner_id
                ),
                'order' => 1
            ));

            $condition = new CartCustomCondition(array(
                'name' => $setDiscount,
                'type' => 'discount',
                'target' => 'subtotal',
                'value' => '-'.$setDiscount.'%',
                'attributes' => array(
                    'discount_id' => $setDiscount,
                    'description' => 'Value added tax',
                    'partner' => $partner,
                    'partner_id' => $partner_id
                ),
                'order' => 2
            ));

            Cart::condition($removeDDS);
            Cart::condition($condition);
            Cart::session($userId)->condition($removeDDS);
            Cart::session($userId)->condition($condition);

            $total = round(Cart::session($userId)->getTotal(),2);
            $subTotal = round(Cart::session($userId)->getSubTotal(),2);
            $cartConditions = Cart::session($userId)->getConditions();
            $conds = array();
            $priceCon = 0;
    
            if(count($cartConditions) > 0){
                foreach(Cart::session(Auth::user()->getId())->getConditions() as $cc){
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

            return Response::json(array('success' => true, 'total' => $total, 'subtotal' => $subTotal, 'condition' => $conds, 'priceCon' => $priceCon, 'dds' => $dds));  
        } 
    }

    public function removeDiscount(Request $request, $name){
        $userId = Auth::user()->getId(); 
        $conds = array();

        Cart::removeCartCondition($name);
        Cart::session($userId)->removeCartCondition($name);

        $cartConditions = Cart::session($userId)->getConditionsByType('discount');
        foreach($cartConditions as $key => $condition){
            $conds[$key]['value'] = $condition->getValue();
            $conds[$key]['name'] = $condition->getValue();
            $conds[$key]['attributes'] = $condition->getAttributes();
        }

        $total = round(Cart::session($userId)->getTotal(),2);
        $subTotal = round(Cart::session(Auth::user()->getId())->getSubTotal(),2);
        $cartConditions = Cart::session(Auth::user()->getId())->getConditions();
        $condition = Cart::getConditions('discount');
        $priceCon = 0;

        if(count($cartConditions) > 0){
            foreach(Cart::session(Auth::user()->getId())->getConditionsByType('discount') as $cc){
                $priceCon += $cc->getCalculatedValue($subTotal);
            }
        } else{
            $priceCon = 0;
        }

        return Response::json(array('success' => true, 'total' => $total, 'subtotal' => $subTotal, 'condition' => $conds, 'con' => $priceCon));  
    }

    public function sendDiscount(Request $request){
        
        $userId = Auth::user()->getId(); 

        $partner = 'false';

        if(isset($card)){
            if($card->user->isA('corporate_partner')){
                $partner = 'true';
            }
        }

        $condition = new CartCustomCondition(array(
            'name' => $request->discount,
            'type' => 'discount',
            'target' => 'subtotal',
            'value' => '-'.$request->discount.'%',
            'attributes' => array(
                'discount_id' => $request->discount,
                'description' => $request->description,
                'more_data' => 'more data here',
                'partner' => $partner
            ),
            'order' => 1
        ));

        Cart::condition($condition);
        Cart::session($userId)->condition($condition);

        $cartConditions = Cart::session($userId)->getConditions();
        $subTotal = round(Cart::session(Auth::user()->getId())->getSubTotal(),2);
        $conds = array();
        $priceCon = 0;

        if(count($cartConditions) > 0){
            foreach(Cart::session(Auth::user()->getId())->getConditions() as $cc){
                $priceCon += $cc->getCalculatedValue($subTotal);
            }
        } else{
            $priceCon = 0;
        }
        
        foreach($cartConditions as $key => $condition){
            $conds[$key]['value'] = $condition->getValue();
            $conds[$key]['name'] = $condition->getValue();
            $conds[$key]['attributes'] = $condition->getAttributes();
        }

        $total = round(Cart::session($userId)->getTotal(),2);
        $subtotal = round(Cart::session($userId)->getSubTotal(),2);

        //Sending mails and SMS
        $this->sendDiscountNotification($total, $request->discount.'%', $request->description, Auth::user());

        return Response::json(array('success' => true, 'total' => $total, 'subtotal' => $subtotal, 'condition' => $conds, 'priceCon' => $priceCon));  
        
    }

    public function sendDiscountNotification($total, $condition, $description, $user) 
    {
        $emails = explode(',', env('NOTIFICATIONS_EMAILS'));
        
        Mail::send('ordernotification',
        array(
            'total' => $total,
            'condition' => $condition,
            'description' => $description,
            'user' => $user->name,
            'location' => $user->store->name
        ), function($message) use ($emails)
        {
            $message->from(env('ORDER_EMAILS'));
            $message->to($emails)->subject(trans('admin/sellings.custom_discount_email_subject'));
        });
    }

    public function removeItem($item){
        $userId = Auth::user()->getId(); 

        $product = Product::where('barcode', $item)->first();
        $product_box = ProductOther::where('barcode', $item)->first();
        $repair = Repair::where('barcode', $item)->first();

        $cartItem = Cart::session($userId)->get($item);

        if($product){
            $product->status = 'available';
            $product->save();
        }else if($product_box){
            $product_box->quantity += $cartItem->quantity;
            $product_box->save();
        }

        $remove = Cart::session($userId)->remove($item);

        $total = round(Cart::session($userId)->getTotal(),2);
        $subtotal = round(Cart::session($userId)->getSubTotal(),2);
        $quantity = Cart::session($userId)->getTotalQuantity();

        $items = [];
        
        Cart::session($userId)->getContent()->each(function($singleitem) use (&$items)
        {
            $items[] = $singleitem;
        });

        $table = '';
        foreach($items as $singleitem){
            $table .= View::make('admin/selling/table',array('item'=>$singleitem))->render();
        }

        $dds = round($subtotal - ($subtotal/1.2), 2);
        

        if($remove){
            return Response::json(array('success' => trans('admin/cart.item_deleted'), 'table' => $table, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity, 'dds' => $dds));  
        }
    }

    public function printInfo(){
        //$repair = Repairs::find($id);

        $userId = Auth::user()->getId(); 
        $total = round(Cart::session($userId)->getTotal(),2);
        $subtotal = round(Cart::session($userId)->getSubTotal(),2);

        $items = [];
        
        Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        $table = '';
        foreach($items as $item){
            $table .= View::make('admin/selling/table',array('item'=>$item))->render();
        }

        return Response::json(array('success' => 'yes', 'html' => View::make('admin/selling/information',array('items'=>$items, 'total' => $subtotal, 'subtotal' => $subtotal))->render()));
    }

    public function cartMaterialsInfo(){
        $info = new Selling();
        return $info->cartMaterialsInfo();
    }
}
