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
            $table->unsignedInteger('size_id');
            $table->foreign('size_id')->references('id')->on('stone_sizes');
            $table->unsignedInteger('style_id');
            $table->foreign('style_id')->references('id')->on('stone_styles');
            $table->unsignedInteger('contour_id');
            $table->foreign('contour_id')->references('id')->on('stone_contours');
            $table->integer('amount');
            $table->double('price', 12, 3);
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
        Schema::dropIfExists('stones');
    }
}
