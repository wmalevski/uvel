<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('action', [
                //General types of actions
                'transfer', 
                'repair', 
                'payment', 
                'material_travelling', 
                'material_quantity', 
                'stones',
                'discount'
            ]);

            $table->enum('subaction', [
                //For Repairs
                'accept', 
                'ready', 
                'returned', 

                //For Materials travelling
                'sent',
                'declined',
                'accepted',

                //Selling
                'successful',

                //For stones
                'added',

                //For discounts
                'used'
            ]);
            $table->integer('user_id')->unsigned();
            $table->string('table');
            $table->integer('payment_id')->nullable();
            $table->integer('selling_id')->nullable();
            $table->integer('discount_id')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('repair_id')->nullable();
            $table->integer('transfer_id')->nullable();
            $table->integer('material_travelling_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
    }
}
