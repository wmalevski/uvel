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
            $table->string('nomenclature_id');
            $table->integer('type');
            $table->decimal('weight', 10, 3);
            $table->float('carat');
            $table->unsignedInteger('size_id');
            $table->unsignedInteger('style_id');
            $table->unsignedInteger('contour_id');
            $table->unsignedInteger('store_id');
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
