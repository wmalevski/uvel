<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeadlineToSellingsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::table('sellings', function(Blueprint $table){
			if(!Schema::hasColumn('sellings', 'deadline')){
				$table->date('deadline')->nullable()->after('payment_id');
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::table('sellings', function(Blueprint $table){
			if(Schema::hasColumn('sellings', 'deadline')){
				$table->dropColumn('deadline');
			}
		});
	}
}