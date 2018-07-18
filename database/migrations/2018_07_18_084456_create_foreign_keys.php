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

<<<<<<< HEAD
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
=======
		Schema::table('stones', function (Blueprint $table) {

            $table->foreign('size_id')->references('id')->on('stone_sizes')->onDelete('restrict')->onUpdate('restrict');

            $table->foreign('style_id')->references('id')->on('stone_styles')->onDelete('restrict')->onUpdate('restrict');

            $table->foreign('contour_id')->references('id')->on('stone_contours')->onDelete('restrict')->onUpdate('restrict');

        });
>>>>>>> 22e5f8b029cccd5cece6b0acf2e5e604d8b81806
	}

	public function down()
	{
		Schema::table('materials', function(Blueprint $table) {
			$table->dropForeign('materials_parent_id_foreign');
		});

		Schema::table('stones', function(Blueprint $table) {
			$table->dropForeign('stones_parent_id_foreign');
		});

	}
}