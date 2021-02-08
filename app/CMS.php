<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CMS extends Model{

	public $timestamps = false;
	protected $fillable = array(
		'key',
		'value'
	);

	protected $table = 'cms';
	protected $primaryKey = 'key';
	public $incrementing = false;

	/**
	 * Fetch the data for a CMS block
	 *@method get
	 *@param  string		$var		The block key to look for
	 *@param  boolean		$friendly	Set to TRUE if you want "Friendly Name"
	 *@return text			Returns whether the base64 decoded value of a block ($friendly == false) or its Friendly Name ($friendly == true)
	*/
	public static function get($var, $friendly = false){
		$setting = CMS::where(array('key'=>$var))->first();
		// The key is not found, no need to proceed
		if(!is_object($setting) || !isset($setting->value)){return NULL;}

		return ($friendly ? $setting->friendly_name : base64_decode($setting->value));
	}

	public static function set($var, $val, $friendly = false){
		$setting = CMS::firstOrNew(array('key'=>$var));
		$setting->value = base64_encode($val);
		if($friendly){
			$setting->friendly_name = $friendly;
		}
		$setting->save();
	}

}