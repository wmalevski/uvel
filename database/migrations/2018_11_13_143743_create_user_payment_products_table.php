<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPaymentProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_payment_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable(); 
            $table->integer('product_other_id')->unsigned()->nullable(); 
            $table->integer('model_id')->unsigned()->nullable(); 
            $table->integer('quantity');
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
        Schema::dropIfExists('user_payment_products');
    }
}
