<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('fullname');
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('school_id');
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->rememberToken();
            $table->string('profile_photo', 2048)->nullable();
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
        Schema::dropIfExists('students');
    }
}
