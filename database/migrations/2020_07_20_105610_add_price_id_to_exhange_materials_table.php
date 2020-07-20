<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceIdToExhangeMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exchange_materials', function (Blueprint $table) {
            if(!Schema::hasColumn('exchange_materials', 'material_price_id')) {
                $table->integer('material_price_id')->unsigned();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exchange_materials', function (Blueprint $table) {
            $table->dropColumn('material_price_id');
        });
    }
}
