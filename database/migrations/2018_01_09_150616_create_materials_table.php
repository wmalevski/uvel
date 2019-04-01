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
            $table->integer('cash_group');
            $table->integer('parent_id')->unsigned();
            $table->enum('default', ['yes', 'no'])->default('no');
            $table->enum('for_buy', ['yes', 'no'])->default('yes');
            $table->enum('for_exchange', ['yes', 'no'])->default('no');
            $table->enum('carat_transform', ['yes', 'no'])->default('yes');
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
