<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelStonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_stones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id')->unsigned();
            $table->integer('stone_id')->unsigned();
            $table->integer('amount');
            $table->integer('weight');
            $table->enum('flow', ['yes', 'no'])->default('no');
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
        Schema::dropIfExists('model_stones');
    }
}
