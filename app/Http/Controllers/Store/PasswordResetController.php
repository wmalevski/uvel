<?php

namespace App\Http\Controllers\Store;

use Mail;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PasswordResetController extends BaseController{

	public function showForm(){
		return View::make('store.pages.user.password_reset');
	}

	public function tokenRequest(Request $request){
		$user = User::where(array('email'=>$request->email));
		if($user->count()>0){
			$token = base64_encode(Hash::make(str_random(8)));
			$user = $user->first();
			$user->password_reset_token = $token;
			$user->save();

			Mail::send('store.emails.password_reset',array(
				'token' => $token,
				'requested_at' => date('H:i часа на d-M-Y'),
				'requested_from' => $_SERVER['REMOTE_ADDR']
			),
			function($message){
				$message
					->from(array(
						'address'=>$_ENV['MAIL_USERNAME'],
						'name'=>$_ENV['APP_NAME']
					))
					->to($request->email)
					->subject('Смяна на парола');
			});

		}

		return View::make('store.pages.user.password_reset_requested', array(
			'email' => $request->email
		));
	}

	public function validateToken($token){
		$invalid_token = true;
		$user = User::where('password_reset_token',$token)->get();
		if($user->count()>0){
			$invalid_token = false;
		}

		return View::make('store.pages.user.password_reset_change_password', array(
			'invalid_token' => $invalid_token,
			'token' => $token
		));
	}

	public function changeUserPassword($token, Request $request){
		// Validate token
		$user = User::where('password_reset_token',$token)->first();
		if($user->count()<1){
			return View::make('store.pages.user.password_reset_change_password', array(
				'invalid_token' => true
			));
		}

		// Validate password fields
		if( !isset($request->password) || !isset($request->password_confirm) ){
			return Redirect::back()->with('error', 'И двете полета са задължителни!');
		}
		if( $request->password !== $request->password_confirm ){
			return Redirect::back()->with('error', 'Двете пароли не съвпадат');
		}

		$user->password = bcrypt($request->password);
		$user->password_reset_token = NULL;
		$user->save();

		return Redirect::to('/online/login')->with('success', 'Паролата Ви бе успешно сменена!');
	}
}