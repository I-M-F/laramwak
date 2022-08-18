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
            $table->string('member_location')->default('Nairobi');
            $table->string('service_number')->unique();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_second_name')->nullable();
            $table->string('spouse_maiden_name');
            $table->string('class')->default('Officer');
            $table->string('id_card');
            $table->string('passport_photo');
            $table->string('marriage_cert');
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
