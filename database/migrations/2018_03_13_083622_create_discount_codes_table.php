<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('discount');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('expires')->nullable();
            $table->enum('active', ['yes', 'no'])->default('yes');
            $table->enum('lifetime', ['yes', 'no'])->default('no');
            $table->string('code');
            $table->string('barcode');
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
        Schema::dropIfExists('discount_codes');
    }
}
