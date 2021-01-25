<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Setting;

class AddEmail2smsOnOrderToSettings extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		$settings = new Setting();
		$settings::insert(array(
			array(
				'key' => 'email2sms_on_order',
				'value' => '359888770160@sms.telenor.bg',
				'friendly_name' => 'Email2SMS получател при поръчка'
			)
		));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		$settings = new Setting();
		$settings::where('key','=','email2sms_on_order')->delete();
	}
}