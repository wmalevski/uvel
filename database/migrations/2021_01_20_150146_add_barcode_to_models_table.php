<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBarcodeToModelsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::table('models', function(Blueprint $table){
			if(!Schema::hasColumn('models', 'barcode')){
				$table->string('barcode')->after('name');
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::table('models', function(Blueprint $table){
			$table->dropColumn('barcode');
		});
	}
}