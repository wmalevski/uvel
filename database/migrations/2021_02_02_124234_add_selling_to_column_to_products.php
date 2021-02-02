<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSellingToColumnToProducts extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::table('products', function(Blueprint $table){
			if(!Schema::hasColumn('products', 'selling_to')){
				// Using string because it can be either UserID (int) or SessionID (str)
				$table->string('selling_to')->nullable()->after('status');
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::table('products', function(Blueprint $table){
			if(Schema::hasColumn('products', 'selling_to')){
				$table->dropColumn('selling_to');
			}
		});
	}
}