<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Setting;

class CreateSystemSettingsTable extends Migration{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up(){
		// Create the Settings table
		Schema::create('settings', function(Blueprint $table){
			$table->string('key', 200);
			$table->text('value');
			$table->text('friendly_name');
			$table->primary('key');
		});

		$system_setting = new Setting();
		$system_setting::insert(array(
			array(
				'key' => 'website_title',
				'value' => 'Ювел - Онлайн магазин',
				'friendly_name' => 'Заглавие на сайта'
			),
			array(
				'key' => 'website_logo',
				'value' => 'store/images/logo.png',
				'friendly_name' => 'Лого'
			),
			array(
				'key' => 'website_header',
				'value' => '',
				'friendly_name' => 'Фон на хедъра'
			),
			array(
				'key' => 'facebook_link',
				'value' => '#',
				'friendly_name' => 'Линк за Facebook страница'
			)
		));
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down(){
		// Drop the Settings table
		Schema::dropIfExists('settings');
	}
}