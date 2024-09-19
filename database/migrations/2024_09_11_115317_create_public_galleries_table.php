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
        Schema::create('public_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->enum('media_type', ['image', 'video']);
            $table->string('media_path')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->text('embed_code')->nullable();
            $table->string('alt_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_galleries');
    }
};
