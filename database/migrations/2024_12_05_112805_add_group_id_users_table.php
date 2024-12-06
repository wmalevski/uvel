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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('user_groups_id')->nullable()->after('store_id');
        });

        Schema::table('discount_codes', function (Blueprint $table) {
            $table->integer('group_id')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_groups_id');
        });

        Schema::table('discount_codes', function (Blueprint $table) {
            $table->dropColumn('group_id');
        });
    }
};
