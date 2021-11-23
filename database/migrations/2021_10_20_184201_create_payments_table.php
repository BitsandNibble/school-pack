<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
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
      $table->string('title', 100);
      $table->integer('amount');
      $table->string('ref_no', 100)->unique();
      $table->string('method', 100)->default('cash');
      $table->unsignedBigInteger('class_room_id')->nullable();
      $table->unsignedBigInteger('student_id')->nullable();
      $table->string('description')->nullable();
      $table->string('session');
      $table->unsignedBigInteger('term_id')->nullable();
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
}
