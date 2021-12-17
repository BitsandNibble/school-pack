<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassStudentSubjectsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('class_student_subjects', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('class_room_id');
      $table->unsignedBigInteger('student_id');
      $table->unsignedBigInteger('subject_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('class_student_subjects');
  }
}
