<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassRoomSubjectTeacherTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('class_room_subject_teacher', function (Blueprint $table) {
      $table->id();
      $table->foreignId('class_room_id')->constrained();
      $table->foreignId('subject_id')->constrained();
      $table->foreignId('teacher_id')->constrained();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('class_room_subject_teacher');
  }
}
