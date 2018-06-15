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
            $table->string('date_received');
            $table->enum('status', ['repairing', 'done', 'returning', 'returned'])->default('repairing');
            $table->string('code');
            $table->float('weight');
            $table->float('weight_after')->nullable();
            $table->float('price');
            $table->float('deposit')->default(0)->nullable();
            $table->float('price_after')->nullable();
            $table->string('barcode')->nullable();
            $table->integer('discount');
            $table->text('repair_description')->nullable();
            $table->integer('material')->nullable();
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
        Schema::dropIfExists('repairs');
    }
}
