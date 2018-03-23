<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_name');
            $table->integer('customer_phone');
            $table->integer('type');
            $table->string('date_recieved');
            $table->string('date_returned');
            $table->enum('status', ['repairing', 'done', 'returned'])->default('repairing');
            $table->string('code');
            $table->float('weight');
            $table->float('price');
            $table->float('deposit')->default(0);
            $table->float('price_after')->nullable();
            $table->string('barcode')->nullable();
            $table->integer('discount');
            $table->text('repair_description')->nullable();
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
        Schema::dropIfExists('repairs');
    }
}
