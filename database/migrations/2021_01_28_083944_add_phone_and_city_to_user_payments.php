<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneAndCityToUserPayments extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::table('user_payments', function(Blueprint $table){
			if(!Schema::hasColumn('user_payments', 'city')){
				$table->string('city')->nullable()->after('store_id');
			}
			if(!Schema::hasColumn('user_payments', 'phone')){
				$table->string('phone')->nullable()->after('payment_method');
			}

			// Add Processing status to the order
			if(Schema::hasColumn('user_payments', 'status')){
                DB::statement("ALTER TABLE user_payments MODIFY status ENUM('waiting_user','waiting_staff','done')");
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::table('user_payments', function(Blueprint $table){
			if(Schema::hasColumn('user_payments', 'city')){
				$table->dropColumn('city');
			}
			if(Schema::hasColumn('user_payments', 'phone')){
				$table->dropColumn('phone');
			}
		});
	}
}