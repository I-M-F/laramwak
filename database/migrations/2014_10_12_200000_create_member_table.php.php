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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('second_name');
            $table->string('maiden_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->unique();
            $table->string('photo')->default('avator.jpg');
            $table->string('id_number')->unique();
            $table->string('member_location')->default('Officer');
            $table->string('service_number')->unique();
            $table->string('spouse_name');
            $table->string('spouse_second_name');
            $table->string('spouse_maiden_name');
            $table->string('class')->default('Officer');
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
        Schema::dropIfExists('members');
    }
};
