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
        Schema::create('member_registartions', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('maiden_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique();
            $table->string('id_number')->unique();
            $table->string('county')->nullable();
            $table->string('sub_county')->nullable();
            $table->string('member_location')->default('Nairobi');
            $table->string('member_no')->nullable(); 
            $table->string('service_number')->unique();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_second_name')->nullable();
            $table->string('spouse_maiden_name')->nullable();
            $table->string('class')->nullable();
            $table->string('id_card');
            $table->string('status')->default('Pending');
            $table->string('passport_photo')->nullable();
            $table->string('marriage_cert')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('member_registartions');
    }
};
