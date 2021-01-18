<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeTable extends Migration{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('income', function (Blueprint $table){
			$table->increments('id');
			$table->integer('type_id')->unsigned();
			$table->float('amount');
			$table->float('given');
			$table->integer('currency_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('store_id')->references('id')->on('stores');
			$table->text('additional_info');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		// Remove the foreign key for Store ID
		// Schema::table('income', function(Blueprint $table){
		// 	$table->dropForeign('income_store_id_foreign');
		// });

		Schema::dropIfExists('income');
	}
}