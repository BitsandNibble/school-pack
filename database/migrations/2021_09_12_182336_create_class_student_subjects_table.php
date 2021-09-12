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
      $table->foreignId('class_room_id')->constrained();
      $table->foreignId('student_id')->constrained();
      $table->foreignId('subject_id')->constrained();
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
