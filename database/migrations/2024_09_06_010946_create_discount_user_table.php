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
        Schema::create('discountcode_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('discount_code_id');
            $table->unsignedInteger('user_id');

            $table->foreign('discount_code_id')->references('id')->on('discount_codes');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discountcode_user');
    }
};
