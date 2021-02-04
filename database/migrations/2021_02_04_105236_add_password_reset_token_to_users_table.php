<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPasswordResetTokenToUsersTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('users', function(Blueprint $table){
            if(!Schema::hasColumn('users', 'password_reset_token')){
                // Using string because it can be either UserID (int) or SessionID (str)
                $table->string('password_reset_token')->nullable()->after('password');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::table('users', function(Blueprint $table){
            if(Schema::hasColumn('users', 'password_reset_token')){
                $table->dropColumn('password_reset_token');
            }
        });
    }
}