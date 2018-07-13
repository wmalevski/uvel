<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSubstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_substitutions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users');;
            $table->integer('store_id')->references('id')->on('stores');;
            $table->date('date_from');
            $table->date('date_to');
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
        Schema::dropIfExists('user_substitutions');
    }
}
