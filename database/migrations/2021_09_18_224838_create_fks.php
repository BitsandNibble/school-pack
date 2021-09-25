<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFks extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('class_rooms', function (Blueprint $table) {
      $table->foreign('class_type_id')->references('id')->on('class_types')->onDelete('set null');
    });

    Schema::table('sections', function (Blueprint $table) {
      $table->foreign('class_room_id')->references('id')->on('class_rooms')->onDelete('cascade');
      $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
    });

    Schema::table('students', function (Blueprint $table) {
      $table->foreign('class_room_id')->references('id')->on('class_rooms')->onDelete('set null');
      $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
    });

    Schema::table('class_room_subject_teacher', function (Blueprint $table) {
      $table->foreign('class_room_id')->references('id')->on('class_rooms')->onDelete('cascade');
      $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
      $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
    });

    Schema::table('grades', function (Blueprint $table) {
      $table->foreign('class_type_id')->references('id')->on('class_types')->onDelete('set null');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('fks');
  }
}
