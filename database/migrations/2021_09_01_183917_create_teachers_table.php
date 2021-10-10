<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('teachers', function (Blueprint $table) {
      $table->id();
      $table->string('fullname')->unique();
      $table->string('slug');
      $table->string('title');
      $table->string('gender')->nullable();
      $table->date('date_of_birth')->nullable();
      $table->string('school_id');
      $table->string('email')->unique()->nullable();
      $table->unsignedBigInteger('nationality_id')->nullable();
      $table->longText('address')->nullable();
      $table->unsignedBigInteger('state_id')->nullable();
      $table->unsignedBigInteger('lga_id')->nullable();
      $table->string('password');
      $table->string('phone_number')->nullable();
      $table->rememberToken();
      $table->string('profile_photo', 2048)->nullable();
      $table->date('date_of_employment')->nullable();
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
    Schema::dropIfExists('teachers');
  }
}
