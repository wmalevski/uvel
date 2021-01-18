<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\IncomeType;

class CreateIncomeTypesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('income_types', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});

		$income_type = new IncomeType();
		$income_type::insert(array(
			array(
				'id' => 1,
				'name' => 'Други'
			)
		));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::dropIfExists('income_types');
	}
}