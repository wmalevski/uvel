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
            $table->uuid('id');
            $table->string('name');
            $table->integer('model')->references('id')->on('models');
            $table->integer('jewel_type')->references('id')->on('jewels');
            $table->integer('type');
            $table->float('weight');
            $table->integer('retail_price')->references('id')->on('prices');
            $table->integer('wholesale_price')->references('id')->on('prices');
            $table->integer('size');
            $table->float('workmanship');
            $table->float('price');
            $table->string('code')->nullable();
            $table->string('barcode');
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
        Schema::dropIfExists('products');
    }
}
