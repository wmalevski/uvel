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
            $table->integer('material_id')->unsigned();
            $table->float('quantity');
            $table->float('price');
            $table->integer('store_from_id')->unsigned();
            $table->integer('store_to_id')->unsigned();
            $table->dateTime('dateSent');
            $table->dateTime('dateReceived')->nullable();
            $table->integer('user_sent_id')->unsigned();
            $table->integer('user_received_id')->unsigned();
            $table->enum('status', ['not_accepted', 'accepted'])->default('not_accepted');	
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
