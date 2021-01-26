<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMaterialTypesToSupportNavigationMenuCheckbox extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::table('materials_types', function(Blueprint $table){
			if(!Schema::hasColumn('materials_types', 'site_navigation')){
				$table->enum('site_navigation', array('yes','no'))->default('yes')->after('name');
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::table('materials_types', function(Blueprint $table){
			if(Schema::hasColumn('materials_types', 'site_navigation')){
				$table->dropColumn('site_navigation');
			}
		});
	}
}