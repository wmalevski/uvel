<?php

namespace App\Http\Middleware;

use App\Product;
use App\ProductOther;
use Closure;
use Session;
use Cart;
use Illuminate\Session\Store;

class SessionTimeout {

    protected $session;

    public function __construct(Store $session){
        $this->session = $session;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->cookie('cookie_name_time')) {
            if ($request->cookie('cookie_name')) {
                foreach (Cart::session($request->cookie('cookie_name'))->getContent() as $item) {
                    switch ($item->attributes->type) {
                        case 'product':
                            $product_id = $item->attributes->product_id;
                            Product::where('id', $product_id)->update(['status' => 'available']);
                            break;
                        case 'box':
                            $product_others_id = $item->attributes->product_id;
                            $quantity = $item->quantity;
                            $current_quantity = Product::where('id', $product_others_id)->first()->quantity;
                            ProductOther::where('id', $product_others_id)->update(['quantity' => ($current_quantity + $quantity)]);
                            break;
                    }
                    Cart::session($request->cookie('cookie_name'))->remove($item->id);
                }
            }
        }

        return $next($request);
    }
}
