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
      $table->unsignedBigInteger('class_room_id');
      $table->unsignedBigInteger('subject_id');
      $table->unsignedBigInteger('teacher_id')->nullable();
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
