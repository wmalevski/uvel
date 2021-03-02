<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrepaidColumnToRepairsTable extends Migration{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::table('repairs', function(Blueprint $table){
			if(!Schema::hasColumn('repairs', 'prepaid')){
				$table->double('prepaid', 8, 2)->default('0.00')->after('weight_after');
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::table('repairs', function(Blueprint $table){
			if(Schema::hasColumn('repairs', 'prepaid')){
				$table->dropColumn('prepaid');
			}
		});
	}
}