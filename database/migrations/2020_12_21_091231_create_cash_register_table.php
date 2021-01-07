<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashRegisterTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up(){
		// Create the Cash Register table
		Schema::create('cash_register', function(Blueprint $table){
			$table->date('date');
			$table->unsignedInteger('store_id');
				// Add foreign key for the Store ID
				$table->foreign('store_id')->references('id')->on('stores');
			$table->decimal('income', 10, 2)->default(0)->comment("Sum in (BGN) Default currency");
			$table->decimal('expenses', 10, 2)->default(0)->comment("Sum in (BGN) Default currency");
			$table->decimal('total', 10, 2)->default(0)->comment("Sum in (BGN) Default currency");
			$table->enum('status', array('pending', 'success', 'failed'));
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down(){
		// Remove the foreign key for Store ID
		Schema::table('cash_register', function(Blueprint $table){
			$table->dropForeign('cash_register_store_id_foreign');
		});

		// Drop the Cash Register table
		Schema::dropIfExists('cash_register');
	}
}