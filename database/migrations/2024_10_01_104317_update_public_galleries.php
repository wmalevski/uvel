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
            $table->integer('unique_number')->unsigned()->after('alt_text');
            $table->datetime('archive_date')->nullable()->after('alt_text');
            $table->float('weight', 6, 2)->nullable()->after('alt_text');
            $table->integer('jewel_id')->unsigned()->nullable()->after('alt_text');
            $table->foreign('jewel_id')
                ->references('id')
                ->on('jewels');
            $table->double('size', 8, 2)->nullable()->after('alt_text');
            $table->renameColumn('alt_text', 'description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            $table->dropColumn([
                'unique_number',
                'archive_date',
                'weight',
                'jewel_id',
                'size'
            ]);
    }
};
