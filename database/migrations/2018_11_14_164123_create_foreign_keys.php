<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('store_id')->references('id')->on('stores')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

		Schema::table('materials', function(Blueprint $table) {
			$table->foreign('parent_id')->references('id')->on('materials_types')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

		Schema::table('model_options', function(Blueprint $table) {
			$table->foreign('model_id')->references('id')->on('models')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('material_id')->references('id')->on('materials_quantities')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('retail_price_id')->references('id')->on('prices')
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
			$table->foreign('material_id')->references('id')->on('materials_quantities')
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

		Schema::table('stones', function (Blueprint $table) {

            $table->foreign('size_id')->references('id')->on('stone_sizes')
            			->onDelete('cascade')
            			->onUpdate('cascade');

            $table->foreign('style_id')->references('id')->on('stone_styles')
            			->onDelete('cascade')
            			->onUpdate('cascade');

            $table->foreign('contour_id')->references('id')->on('stone_contours')
            			->onDelete('cascade')
            			->onUpdate('cascade');

        });

        Schema::table('discount_codes', function (Blueprint $table) {

            $table->foreign('user_id')->references('id')->on('users')
            			->onDelete('cascade')
            			->onUpdate('cascade');
		});

		Schema::table('blog_comments', function (Blueprint $table) {
			
			$table->foreign('blog_id')->references('id')->on('blogs')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		
		Schema::table('repairs', function (Blueprint $table) {
			
			$table->foreign('type_id')->references('id')->on('repair_types')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('material_id')->references('id')->on('materials')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

		Schema::table('prices', function (Blueprint $table) {
			
			$table->foreign('material_id')->references('id')->on('materials')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

		Schema::table('products_others', function (Blueprint $table) {
			
			$table->foreign('type_id')->references('id')->on('products_others_types')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

		Schema::table('reviews', function (Blueprint $table) {
			
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('model_id')->references('id')->on('models')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('product_others_id')->references('id')->on('products_others')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

		Schema::table('wish_lists', function (Blueprint $table) {
			
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('model_id')->references('id')->on('models')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('product_others_id')->references('id')->on('products_others')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

	}

	public function down()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_store_id_foreign');
			$table->dropColumn('store_id');
		});

		Schema::table('materials', function(Blueprint $table) {
			$table->dropForeign('materials_parent_id_foreign');
			$table->dropColumn('parent_id');
		});

		Schema::table('model_options', function(Blueprint $table) {
			$table->dropForeign('model_options_model_id_foreign');
			$table->dropForeign('model_options_material_id_foreign');
			$table->dropForeign('model_options_retail_price_id_foreign');

			$table->dropColumn('model_id');
			$table->dropColumn('material_id');
			$table->dropColumn('retail_price_id');
		});

		Schema::table('materials_quantities', function(Blueprint $table) {
			$table->dropForeign('materials_quantities_material_id_foreign');
			$table->dropForeign('materials_quantities_store_id_foreign');

			$table->dropColumn('material_id');
			$table->dropColumn('store_id');
		});

		Schema::table('materials_travellings', function(Blueprint $table) {
			$table->dropForeign('materials_travellings_material_id_foreign');
			$table->dropForeign('materials_travellings_store_from_id_foreign');
			$table->dropForeign('materials_travellings_store_to_id_foreign');
			$table->dropForeign('materials_travellings_user_sent_id_foreign');

			$table->dropColumn('material_id');
			$table->dropColumn('store_from_id');
			$table->dropColumn('store_to_id');
			$table->dropColumn('user_sent_id');
		});

		Schema::table('stones', function(Blueprint $table) {
			$table->dropForeign('stones_style_id_foreign');
			$table->dropForeign('stones_contour_id_foreign');
			$table->dropForeign('stones_size_id_foreign');

			$table->dropColumn('size_id');
			$table->dropColumn('style_id');
			$table->dropColumn('contour_id');
		});

		Schema::table('discount_codes', function(Blueprint $table) {
			$table->dropForeign('discount_codes_user_id_foreign');
			$table->dropColumn('user_id');
		});

		Schema::table('prices', function(Blueprint $table) {
			$table->dropForeign('prices_material_id_foreign');
			$table->dropColumn('material_id');
		});

		Schema::table('products_others', function(Blueprint $table) {
			$table->dropForeign('products_others_type_id_foreign');
			$table->dropColumn('type_id');
		});

		Schema::table('blog_comments', function(Blueprint $table) {
			$table->dropForeign('blog_comments_blog_id_foreign');
			$table->dropColumn('blog_id');
		});

		Schema::table('reviews', function(Blueprint $table) {
			$table->dropForeign('reviews_user_id_foreign');
			$table->dropColumn('user_id');
			$table->dropForeign('reviews_product_id_foreign');
			$table->dropColumn('product_id');
			$table->dropForeign('reviews_model_id_foreign');
			$table->dropColumn('model_id');
			$table->dropForeign('reviews_product_others_id_foreign');
			$table->dropColumn('product_others_id');
		});

		Schema::table('wish_lists', function(Blueprint $table) {
			$table->dropForeign('wish_lists_user_id_foreign');
			$table->dropColumn('user_id');
			$table->dropForeign('wish_lists_product_id_foreign');
			$table->dropColumn('product_id');
			$table->dropForeign('wish_lists_model_id_foreign');
			$table->dropColumn('model_id');
			$table->dropForeign('wish_lists_product_others_id_foreign');
			$table->dropColumn('product_others_id');
		});
	}
}