<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('materials', function(Blueprint $table) {
			$table->foreign('parent_id')->references('id')->on('materials_types')
						->onDelete('restrict')
						->onUpdate('restrict');
		});

		Schema::table('model_options', function(Blueprint $table) {
			$table->foreign('model')->references('id')->on('models')
						->onDelete('restrict')
						->onUpdate('restrict');

			$table->foreign('material')->references('id')->on('materials')
						->onDelete('restrict')
						->onUpdate('restrict');

			$table->foreign('retail_price')->references('id')->on('prices')
						->onDelete('restrict')
						->onUpdate('restrict');

			$table->foreign('wholesale_price')->references('id')->on('prices')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('materials', function(Blueprint $table) {
			$table->dropForeign('materials_parent_id_foreign');
		});
	}
}