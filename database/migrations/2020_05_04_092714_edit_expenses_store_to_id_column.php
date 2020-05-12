<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditExpensesStoreToIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('store_from_id');
            $table->dropColumn('store_to_id');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->integer('store_from_id')->references('id')->on('stores')->nullable();
            $table->integer('store_to_id')->references('id')->on('stores')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('store_from_id');
            $table->dropColumn('store_to_id');
        });
    }
}
