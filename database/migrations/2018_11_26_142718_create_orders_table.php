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
            $table->string('name');
            $table->integer('model_id')->unsigned();
            $table->integer('material_id')->unsigned();
            $table->integer('jewel_id')->unsigned();
            $table->integer('type')->default(1);
            $table->float('weight');
            $table->float('gross_weight');
            $table->integer('retail_price_id')->unsigned();
            $table->integer('size');
            $table->float('workmanship');
            $table->float('price');
            $table->string('code')->nullable();
            $table->string('barcode');
            $table->enum('status', ['available', 'selling', 'travelling', 'sold'])->default('available');
            $table->enum('weight_without_stones', ['yes', 'no'])->default('no');
            $table->integer('store_id')->unsigned();
            //$table->enum('status', ['accepted', 'ready'])->default('accepted');
            $table->integer('quantity')->default(1);
            $table->text('content')->nullable();
            $table->integer('safe_group')->nullable();
            $table->integer('deposit')->nullable();
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
