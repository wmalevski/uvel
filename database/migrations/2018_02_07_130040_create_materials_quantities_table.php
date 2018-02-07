<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsQuantitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials_quantities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('material')->references('id')->on('materials');
            $table->float('quantity');
            $table->integer('store')->references('id')->on('stores');
            $table->float('carat');
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
        Schema::dropIfExists('materials_quantities');
    }
}
