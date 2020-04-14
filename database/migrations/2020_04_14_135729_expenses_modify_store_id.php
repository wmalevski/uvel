<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExpensesModifyStoreId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('expenses', function($table) {
        $table->dropColumn('store_id');
        $table->integer('store_from_id')->references('id')->on('stores');
        $table->integer('store_to_id')->references('id')->on('stores');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('expenses', function($table) {
        $table->dropColumn('store_from_id');
        $table->dropColumn('store_to_id');
        $table->integer('store_id')->unsigned();
    });
    }
}
