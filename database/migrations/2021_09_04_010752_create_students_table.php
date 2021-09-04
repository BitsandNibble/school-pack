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
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('previous_class')->nullable();
            $table->string('current_class');
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('admission_no');
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
