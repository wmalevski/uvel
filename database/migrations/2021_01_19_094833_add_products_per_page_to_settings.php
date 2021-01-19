<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Setting;

class AddProductsPerPageToSettings extends Migration{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		$settings = new Setting();
		$settings::insert(array(
			array(
				'key' => 'per_page',
				'value' => '12',
				'friendly_name' => 'Елементи на страница'
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
		$settings::where('key','=','per_page')->delete();
	}
}