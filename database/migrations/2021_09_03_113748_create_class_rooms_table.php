<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassRoomsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('class_rooms', function (Blueprint $table) {
      $table->id();
      $table->string('slug');
      $table->string('name', 100);
      $table->unsignedBigInteger('class_type_id')->nullable();
      $table->timestamps();
    });

    Schema::table('class_rooms', function (Blueprint $table) {
      $table->unique(['class_type_id', 'name']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('class_rooms');
  }
}
