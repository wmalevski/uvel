<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\CMS;

class CreateCMSTable extends Migration{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up(){
		// Create the Settings table
		Schema::create('cms', function(Blueprint $table){
			$table->string('key', 200);
			$table->text('value');
			$table->text('friendly_name');
			$table->primary('key');
		});

		$cms = new CMS();
		$cms::insert(array(
			// array(
			// 	'key' => 'website_title',
			// 	'value' => 'Ювел - Онлайн магазин',
			// 	'friendly_name' => 'Заглавие на сайта'
			// )
		));
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down(){
		// Drop the Settings table
		Schema::dropIfExists('cms');
	}
}