<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->enum('shipping_method', ['store', 'office_address', 'home_address']);
            $table->enum('payment_method', ['paypal', 'borika', 'on_delivery']);
            $table->integer('store_id')->unsigned()->nullable();
            $table->string('shipping_address')->nullable();
            $table->float('price');
            $table->text('information')->nullable();
            $table->enum('status', ['waiting_user', 'done'])->default('waiting_user');
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
        Schema::dropIfExists('user_payments');
    }
}
