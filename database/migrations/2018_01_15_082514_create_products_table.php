<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('model_id')->unsigned();
            $table->integer('material_id')->unsigned();
            $table->integer('material_type_id')->unsigned();
            $table->integer('jewel_id')->unsigned();
            $table->integer('type')->default(1);
            $table->float('weight');
            $table->float('gross_weight');
            $table->integer('retail_price_id')->unsigned();
            $table->integer('size');
            $table->float('workmanship');
            $table->float('price');
            $table->string('barcode');
            $table->enum('status', ['available', 'selling', 'travelling', 'reserved', 'sold'])->default('available');
            $table->enum('weight_without_stones', ['yes', 'no'])->default('no');
            $table->enum('website_visible', ['yes', 'no'])->default('yes');
            $table->integer('store_id')->unsigned();
            $table->integer('order_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
