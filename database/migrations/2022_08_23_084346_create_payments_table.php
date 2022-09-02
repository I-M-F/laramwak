<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();                
             $table->string('phone')->nullable();
             $table->string('member_no')->nullable();       
             $table->string('amount')->nullable();
             $table->string('payment_description')->nullable();          
             $table->string('tx_number')->nullable();
             $table->string('status')->nullable();   
             $table->string('date')->nullable();  
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
        Schema::dropIfExists('payments');
    }
};
