<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model{

	public $timestamps = false;
	protected $fillable = array(
		'key',
		'value'
	);

	protected $table = 'settings';
	protected $primaryKey = 'key';
	public $incrementing = false;


	/**
	 * Fetch the data for a system setting
	 *@method get
	 *@param  string		$var		The setting key to look for
	 *@param  boolean		$friendly	Set to TRUE if you want "Friendly Name"
	 *@return text			Returns whether the value of a variable ($friendly == false) or its Frintly Name ($friendly == true)
	*/
	public static function get($var, $friendly = false){
		$setting = Setting::where(array('key'=>$var))->first();
		// The key is not found, no need to proceed
		if(!is_object($setting) || !isset($setting->value)){return NULL;}

		return ($friendly ? $setting->friendly_name : $setting->value);
	}

	public static function set($var, $val, $friendly = false){
		$setting = Setting::firstOrNew(array('key'=>$var));
		$setting->value = $val;
		if($friendly){
			$setting->friendly_name = $friendly;
		}
		$setting->save();
	}

}