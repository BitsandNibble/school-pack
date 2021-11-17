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

    Schema::table('principals', function (Blueprint $table) {
      $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
      $table->foreign('lga_id')->references('id')->on('lgas')->onDelete('set null');
      $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('set null');
    });

    Schema::table('accountants', function (Blueprint $table) {
      $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
      $table->foreign('lga_id')->references('id')->on('lgas')->onDelete('set null');
      $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('set null');
    });

    Schema::table('teachers', function (Blueprint $table) {
      $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
      $table->foreign('lga_id')->references('id')->on('lgas')->onDelete('set null');
      $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('set null');
    });

    Schema::table('students', function (Blueprint $table) {
      $table->foreign('class_room_id')->references('id')->on('class_rooms')->onDelete('set null');
      $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
      $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
      $table->foreign('lga_id')->references('id')->on('lgas')->onDelete('set null');
      $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('set null');
    });

    Schema::table('class_room_subject_teacher', function (Blueprint $table) {
      $table->foreign('class_room_id')->references('id')->on('class_rooms')->onDelete('cascade');
      $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
      $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
    });

    Schema::table('grades', function (Blueprint $table) {
      $table->foreign('class_type_id')->references('id')->on('class_types')->onDelete('set null');
    });

    Schema::table('marks', function (Blueprint $table) {
      $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
      $table->foreign('class_room_id')->references('id')->on('class_rooms')->onDelete('cascade');
      $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
      $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
      $table->foreign('grade_id')->references('id')->on('grades')->onDelete('set null');
    });

    Schema::table('exam_records', function (Blueprint $table) {
      $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
      $table->foreign('class_room_id')->references('id')->on('class_rooms')->onDelete('cascade');
      $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
    });

    Schema::table('lgas', function (Blueprint $table) {
      $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
    });

    Schema::table('skills', function (Blueprint $table) {
      $table->foreign('class_type_id')->references('id')->on('class_types')->onDelete('set null');
    });

    Schema::table('promotions', function (Blueprint $table) {
      $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
      $table->foreign('from_class')->references('id')->on('class_rooms')->onDelete('cascade');
      $table->foreign('from_section')->references('id')->on('sections')->onDelete('cascade');
      $table->foreign('to_section')->references('id')->on('sections')->onDelete('cascade');
      $table->foreign('to_class')->references('id')->on('class_rooms')->onDelete('cascade');
    });

    Schema::table('payments', function (Blueprint $table) {
      $table->foreign('class_room_id')->references('id')->on('class_rooms')->onDelete('cascade');
      $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
    });

    Schema::table('payment_records', function (Blueprint $table) {
      $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
      $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
    });

    Schema::table('receipts', function (Blueprint $table) {
      $table->foreign('pr_id')->references('id')->on('payment_records')->onDelete('cascade');
    });

    Schema::table('notice_boards', function (Blueprint $table) {
      $table->foreign('author_id')->references('id')->on('principals')->onDelete('cascade');
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
