<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('model_id')->unsigned();
            $table->integer('material_id')->unsigned();
            $table->integer('jewel_id')->unsigned();
            $table->float('weight');
            $table->float('gross_weight');
            $table->integer('retail_price_id')->unsigned();
            $table->integer('size');
            $table->float('workmanship');
            $table->float('price');
            $table->enum('status', ['accepted', 'ready', 'done'])->default('accepted');
            $table->enum('weight_without_stones', ['yes', 'no'])->default('no');
            $table->integer('store_id')->unsigned();
            $table->integer('quantity');
            $table->text('content')->nullable();
            $table->integer('safe_group')->nullable();
            $table->integer('earnest')->nullable()->default(0);
            $table->enum('earnest_used', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
