<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_travellings', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable()->after('product_id');

            $table->index('order_id', 'order_id_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_travellings', function (Blueprint $table) {
            $table->dropForeign('order_id_foreign');
            $table->dropIndex(['order_id_index']);
            $table->dropColumn('order_id');
        });
    }
};
