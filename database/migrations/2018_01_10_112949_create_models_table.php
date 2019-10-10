<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('jewel_id')->unsigned();
            $table->float('weight');
            $table->float('size');
            $table->float('workmanship');
            $table->float('totalStones')->nullable();
            $table->enum('website_visible', ['yes', 'no'])->default('yes');
            $table->enum('release_product', ['yes', 'no'])->default('no');
            $table->float('price');
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
        Schema::dropIfExists('models');
    }
}
