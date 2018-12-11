<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('currency_id');
            $table->enum('method', ['cash', 'post']);
            $table->enum('reciept', ['yes', 'no']);
            $table->enum('ticket', ['yes', 'no']);
            $table->enum('certificate', ['yes', 'no']);
            $table->float('price');
            $table->float('given')->nullable();
            $table->float('fullPrice')->nullable();
            $table->enum('type', ['sell', 'repair', 'order']);
            $table->integer('discount_code_id')->nullable();
            $table->text('info')->nullable();
            $table->integer('user_id');
            $table->integer('store_id');
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
        Schema::dropIfExists('payments');
    }
}
