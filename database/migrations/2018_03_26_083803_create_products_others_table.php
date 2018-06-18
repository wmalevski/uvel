<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_others', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('type')->references('id')->on('products_others_types');
            $table->float('price');
            $table->integer('quantity');
            $table->string('barcode');
            $table->integer('store')->references('id')->on('stores');
            $table->string('code')->nullable();
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
        Schema::dropIfExists('products_others');
    }
}
