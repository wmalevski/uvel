<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('type');
            $table->float('weight');
            $table->float('carat');
            $table->integer('size')->nullable()->references('id')->on('stone_sizes');
            $table->integer('style')->references('id')->on('stone_styles');
            $table->integer('contour')->references('id')->on('stone_contours');
            $table->integer('amount');
            $table->float('price');
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
        Schema::dropIfExists('stones');
    }
}
