<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingColumnsToCustomOrdersTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::table('custom_orders', function(Blueprint $table){
			if(!Schema::hasColumn('custom_orders', 'deadline')){
				$table->date('deadline')->nullable()->after('status');
			}
			if(!Schema::hasColumn('custom_orders', 'offer')){
				$table->text('offer')->nullable()->after('deadline');
			}
			if(!Schema::hasColumn('custom_orders', 'ready_product')){
				$table->text('ready_product')->nullable()->after('offer');
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::table('custom_orders', function(Blueprint $table){
			if(Schema::hasColumn('custom_orders', 'deadline')){
				$table->dropColumn('deadline');
			}
			if(Schema::hasColumn('custom_orders', 'offer')){
				$table->dropColumn('offer');
			}
			if(Schema::hasColumn('custom_orders', 'ready_product')){
				$table->dropColumn('ready_product');
			}
		});
	}
}