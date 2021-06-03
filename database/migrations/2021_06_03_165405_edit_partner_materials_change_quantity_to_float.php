<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditPartnerMaterialsChangeQuantityToFloat extends Migration{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::table('partner_materials', function(Blueprint $table){
			if(Schema::hasColumn('partner_materials', 'quantity')){
				DB::unprepared('ALTER TABLE partner_materials CHANGE `quantity` `quantity` DECIMAL(10,4) NOT NULL');
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::table('partner_materials', function(Blueprint $table){
			if(Schema::hasColumn('partner_materials', 'quantity')){
				DB::unprepared('ALTER TABLE partner_materials CHANGE `quantity` `quantity` INT(10) NOT NULL');
			}
		});
	}
}