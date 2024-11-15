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
        Schema::table('public_galleries', function (Blueprint $table) {
            $table->index(['unique_number', 'archive_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('public_galleries', function (Blueprint $table) {
            $table->dropIndex(['unique_number', 'archive_date']);
        });
    }
};
