<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('class_room_id');
            $table->unsignedBigInteger('term_id');
            $table->integer('ca1')->nullable();
            $table->integer('ca2')->nullable();
            $table->integer('total_ca')->nullable();
            $table->integer('exam_score')->nullable();
            $table->integer('total_score')->nullable();
            $table->integer('subject_position')->nullable();
            $table->unsignedBigInteger('grade_id')->nullable();
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
        Schema::dropIfExists('marks');
    }
}
