<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomOrderColumnsToOrdersTable extends Migration{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::table('orders', function(Blueprint $table){
			if(!Schema::hasColumn('orders', 'exchanged_materials')){
				$table->text('exchanged_materials')->nullable()->after('safe_group');
			}
			if(!Schema::hasColumn('orders', 'payment_id')){
				$table->integer('payment_id')->unsigned()->nullable()->after('customer_phone');
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::table('orders', function(Blueprint $table){
			if(Schema::hasColumn('orders', 'exchanged_materials')){
				$table->dropColumn('exchanged_materials');
			}
			if(Schema::hasColumn('orders', 'payment_id')){
				$table->dropColumn('payment_id');
			}
		});
	}
}