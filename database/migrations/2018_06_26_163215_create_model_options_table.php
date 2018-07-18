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
            $table->integer('model')->unsigned();
            $table->integer('material')->unsigned();
            $table->integer('retail_price')->unsigned();
            $table->integer('wholesale_price')->unsigned();
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
