<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('materials', function(Blueprint $table) {
			$table->foreign('parent_id')->references('id')->on('materials_types')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

		Schema::table('model_options', function(Blueprint $table) {
			$table->foreign('model')->references('id')->on('models')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('material')->references('id')->on('materials')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('retail_price')->references('id')->on('prices')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('wholesale_price')->references('id')->on('prices')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

		Schema::table('materials_quantities', function(Blueprint $table) {
			$table->foreign('material_id')->references('id')->on('materials')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('store_id')->references('id')->on('stores')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

		Schema::table('materials_travellings', function(Blueprint $table) {
			$table->foreign('material_id')->references('id')->on('materials_types')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('store_from_id')->references('id')->on('stores')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('store_to_id')->references('id')->on('stores')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('user_sent_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('materials', function(Blueprint $table) {
			$table->dropForeign('materials_parent_id_foreign');
		});
	}
}