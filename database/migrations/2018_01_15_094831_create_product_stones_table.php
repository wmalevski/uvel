<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product')->references('id')->on('products');
            $table->integer('model')->references('id')->on('models');
            $table->integer('stone')->references('id')->on('stones');
            $table->integer('amount');
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
        Schema::dropIfExists('product_stones');
    }
}
