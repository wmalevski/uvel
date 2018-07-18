<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('code');
            $table->string('color');
            $table->integer('carat')->nullable();
            $table->float('stock_price');

            //$table->integer('parent_id')->references('id')->on('materials_types');
            $table->integer('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('materials_types');

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
        Schema::dropIfExists('materials');
    }
}
