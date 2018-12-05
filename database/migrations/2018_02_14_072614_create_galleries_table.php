<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('photo');
            $table->integer('product_id')->nullable()->unsigned();
            $table->integer('model_id')->nullable()->unsigned();
            $table->integer('stone_id')->nullable()->unsigned();
            $table->integer('article_id')->nullable()->unsigned();
            $table->integer('slider_id')->nullable()->unsigned();
            $table->integer('custom_order_id')->nullable()->unsigned();
            $table->integer('product_other_id')->nullable()->unsigned();
            $table->string('table');
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
        Schema::dropIfExists('galleries');
    }
}
