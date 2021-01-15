<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Material;
use App\Currency;
use App\Setting;
use DB;
use Response;

class SettingController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$materials = Material::all();
		return \View::make('admin/settings/index', array('materials' => $materials));
	}

	public function stockPrices(){
		$materials = Material::all();
		return \View::make('admin/settings/stock', array('materials' => $materials));
	}

	public function updatePrices(Request $request){
		if($request->mat){
			foreach($request->mat as $mat => $key){
				$validator = Validator::make( $request->all(), array(
					'stock_price.*' => 'required|numeric|between:0.1,10000'
				));

				if($validator->fails()){
					return Redirect::back()->withErrors($validator);
				}

				$material = Material::find($key);
				$material->stock_price = $request->stock_price[$mat];
				$material->save();
			}
		}

		return Redirect::back();
	}

	public function currencies(){
		$currencies = Currency::all();
		return \View::make('admin/settings/currencies', array('currencies' => $currencies));
	}

	public function SystemSettings(){
		$settings = Setting::orderBy('friendly_name','ASC')->get();
		return \View::make('admin/settings/system', array('settings' => $settings));
	}

	public function EditSetting(Request $request){
		return \View::make('admin/settings/system_edit', array(
			'key' => $request->setting_type,
			'value' => Setting::get($request->setting_type),
			'friendly_name' => Setting::get($request->setting_type, true)
		));
	}

	public function UpdateSetting(Request $request, Setting $setting){
		if($setting){

			$validator = Validator::make( $request->all(), array(
				'setting_var' => 'required'
			));

			if($validator->fails()){
				return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
			}


			$value = $request->setting_value;

			// Process Image uploaders for the Header and the Logo
			if($request->hasFile('website_header') || $request->hasFile('website_logo')){
				$file = $request->file('website_'.($request->hasFile('website_header')?'header':'logo'));
				$filename = $file->getClientOriginalName();

				$image['filePath'] = $filename;
				$file->move(public_path().'/uploads/', $filename);

				$value = '/uploads/'.$filename;
			}

			Setting::set($request->setting_var, $value);

			return Response::json('SUCCESS', 200);
		}
	}

}
