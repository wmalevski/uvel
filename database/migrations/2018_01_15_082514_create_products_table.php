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
            $table->integer('model')->references('id')->on('models')->nullable();
            $table->integer('jewel_type')->references('id')->on('jewels');
            $table->integer('type')->default(1);
            $table->float('weight');
            $table->integer('retail_price')->references('id')->on('prices');
            $table->integer('wholesale_price')->references('id')->on('prices');
            $table->integer('size');
            $table->float('workmanship');
            $table->float('price');
            $table->string('code')->nullable();
            $table->string('barcode');
<<<<<<< HEAD
            $table->enum('status', ['available', 'selling', 'sold'])->default('available');
=======
            $table->enum('for_wholesale', ['yes', 'no'])->default('no');
>>>>>>> d3e3ac7d5dc9ddd72f55e16daf5dd11717c21077
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
