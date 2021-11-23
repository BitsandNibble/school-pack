<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamRecordsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('exam_records', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('term_id');
      $table->unsignedBigInteger('student_id');
      $table->unsignedBigInteger('class_room_id');
      $table->integer('total')->nullable();
      $table->string('average')->nullable();
      $table->string('class_average')->nullable();
      $table->integer('position')->nullable();
      $table->string('af')->nullable();
      $table->string('ps')->nullable();
      $table->longText('principals_comment')->nullable();
      $table->longText('teachers_comment')->nullable();
      $table->string('year');
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
    Schema::dropIfExists('exam_records');
  }
}
