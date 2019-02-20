<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id');
            $table->integer('user_id');
            $table->text('additional_description');
            $table->enum('status', ['pending', 'accepted', 'ready', 'delivered'])->default('pending');
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
        Schema::dropIfExists('model_orders');
    }
}
