<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('sections', function (Blueprint $table) {
      $table->id();
      $table->string('name', 100);
      $table->unsignedBigInteger('class_room_id');
      $table->unsignedBigInteger('teacher_id')->nullable();
      $table->timestamps();
    });

    Schema::table('sections', function (Blueprint $table) {
      $table->unique(['name', 'class_room_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('sections');
  }
}
