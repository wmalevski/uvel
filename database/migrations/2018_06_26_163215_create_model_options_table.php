<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model')->references('id')->on('models');
            $table->integer('material')->references('id')->on('materials');
            $table->integer('retail_price')->references('id')->on('prices');
            $table->integer('wholesale_price')->references('id')->on('prices');
            $table->enum('default', ['yes', 'no'])->default('no');
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
        Schema::dropIfExists('model_options');
    }
}
