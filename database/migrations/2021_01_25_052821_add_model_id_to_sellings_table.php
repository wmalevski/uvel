<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModelIdToSellingsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::table('sellings', function(Blueprint $table){
			if(!Schema::hasColumn('sellings', 'model_id')){
				$table->string('model_id')->after('repair_id')->nullable();
			}
			if(!Schema::hasColumn('sellings', 'model_size')){
				$table->text('model_size')->after('model_id')->nullable();
			}
			if(!Schema::hasColumn('sellings', 'model_status')){
				$table->enum('model_status', array('pending', 'accepted', 'ready', 'delivered'))->default('pending')->after('model_size');
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
			if(Schema::hasColumn('sellings', 'model_id')){
				$table->dropColumn('model_id');
			}
			if(Schema::hasColumn('sellings', 'model_size')){
				$table->dropColumn('model_size');
			}
			if(Schema::hasColumn('sellings', 'model_status')){
				$table->dropColumn('model_status');
			}
		});
	}
}