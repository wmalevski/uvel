<?php

namespace App\Http\Controllers\Store;
use Response;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function create()
    {
        return \View::make('store.pages.user.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make( $request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'street' => 'required',
            'street_number' => 'required',
            'postcode' => 'required',
            'city' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'first_name',
            'last_name'
         ]);
        
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $user = User::create([
            'name' => $request->name,
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

    public function login()
    {
        return \View::make('store.pages.user.login');
    }

    public function userlogin()
    {
        $rules = array(
            'email'    => 'required|email', 
            'password' => 'required|alphaNum|min:3'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
            return Redirect::to('login')
                ->withErrors($validator) 
                ->withInput(Input::except('password'));  
        } else {
            $userdata = array(
                'email'     => Input::get('email'),
                'password'  => Input::get('password')
            );
        
            // attempt to do the login
            if (Auth::attempt($userdata)) {
                return redirect()->to('/online');
        
            } else {        
                return Redirect::back()->withErrors(['credentials' => 'Грешно потребителско име или парола!']);
            }
        }
    }

    public function edit()
    {
        $user = Auth::user();
        if($user){
            return \View::make('store.pages.user.settings', array('user' => $user));
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('login');
    }

}
