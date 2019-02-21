<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->float('safe_money_amount')->nullable();
            $table->float('given_money_amount')->nullable();

            $table->float('safe_jewels_amount')->nullable();
            $table->float('given_jewels_amount')->nullable();

            $table->float('fiscal_amount')->nullable();

            $table->float('safe_materials_amount')->nullable();
            $table->float('given_materials_amount')->nullable();

            $table->integer('store_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('type', ['money', 'jewels', 'materials']);
            $table->enum('status', ['successful', 'unsuccessful'])->default('successful');
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
        Schema::dropIfExists('daily_reports');
    }
}
