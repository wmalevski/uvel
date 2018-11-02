<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTravellingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_travellings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('store_from_id')->references('id')->on('stores');
            $table->integer('store_to_id')->references('id')->on('stores');
            $table->dateTime('date_sent');
            $table->dateTime('date_received')->nullable();
            $table->integer('user_sent');
            $table->enum('status', ['0', '1'])->default(0);	
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
        Schema::dropIfExists('product_travellings');
    }
}
