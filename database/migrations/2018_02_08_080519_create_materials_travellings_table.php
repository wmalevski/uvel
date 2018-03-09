<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTravellingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials_travellings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->float('quantity');
            $table->float('price');
            $table->integer('storeFrom')->references('id')->on('stores');;
            $table->integer('storeTo')->references('id')->on('stores');;
            $table->dateTime('dateSent');
            $table->dateTime('dateReceived')->nullable();
            $table->integer('userSent');
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
        Schema::dropIfExists('materials_travellings');
    }
}
