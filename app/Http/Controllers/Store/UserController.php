<?php

namespace App\Http\Controllers\Store;
use Cookie;
use Response;
use Auth;
use Cart;
use Session;
use App\MaterialType;
use App\ProductOtherType;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use DB;

class UserController extends BaseController{

    public function create(){
        return \View::make('store.pages.user.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        setcookie('register_data', json_encode($request->all()), time()+(180*30));

        $validator = Validator::make( $request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'street' => 'required',
            'street_number' => 'required',
            'postcode' => 'required',
            'city' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'g-recaptcha-response' => 'required|captcha'
         ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        Cookie::queue(Cookie::forget('register_data'));

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'street' => $request->street,
            'street_number' => $request->street_number,
            'postcode' => $request->postcode,
            'city' => $request->city,
            'country' => $request->country,
            'phone' => $request->phone
        ]);

        $user->assign('customer');

        auth()->login($user);

        return redirect()->to('/online');
    }

    public function login(){
        return view('store.pages.user.login');
    }

    public function userlogin(Request $request){
        $rules = array(
            'email'    => 'required',
            'password' => 'required|alphaNum|min:3'
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return Redirect::to('/online/login')
                ->withErrors($validator)
                ->withInput(request()->except('password'));
        }

        $userdata = array(
            'email'     => $request->email,
            'password'  => $request->password
        );

        // Save the session before the Auth attempt as it recreates it
        $session_id = Session::getId();

        // attempt to do the login
        if(!Auth::attempt($userdata)){
            return Redirect::back()->withErrors(['credentials' => 'Грешно потребителско име или парола!']);
        }


        $guest_cart = Cart::session($session_id);

        // Check if there's a Cart for this Session ID and transfer it over to the logged in user
        if($guest_cart->getContent()->count()>0){
            // Cart is not empty, we should transfer it over to the logged in user.
            // Since there's no supported way of doing this, we need to approach this manually.

            $guestCartID = $session_id.'_cart_items';
            $userCartID = Auth::user()->getId().'_cart_items';

            // Before we transfer the cart, we need to ensure the logged in user doesn't have a previous cart
            DB::table('cart_storage')->where('id',$userCartID)->delete();
            DB::table('cart_storage')->where('id',$guestCartID)->update(array('id'=>$userCartID));
        }

        return redirect()->to('/online');
    }

    public function edit()
    {
        $user = Auth::user();
        if($user){
            return \View::make('store.pages.user.settings', array('user' => $user));
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make( $request->all(), [
            'street' => 'required',
            'street_number' => 'required',
            'postcode' => 'required',
            'city' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'first_name' => 'required',
            'last_name' => 'required'
         ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->city = $request->city;
        $user->street = $request->street;
        $user->street_number = $request->street_number;
        $user->country = $request->country;
        $user->phone = $request->phone;
        $user->postcode = $request->postcode;

        if($request->password && $request->password_confirmation && ($request->password===$request->password_confirmation)){
            $user->password=bcrypt($request->password);
        }

        $user->save();

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        return Redirect::back();
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::route('store');
    }
}
