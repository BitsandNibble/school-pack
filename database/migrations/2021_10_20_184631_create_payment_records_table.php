<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentRecordsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('payment_records', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('payment_id');
      $table->unsignedBigInteger('student_id');
      $table->string('ref_no', 100)->unique()->nullable();
      $table->integer('amount_paid')->nullable();
      $table->integer('balance')->nullable();
      $table->tinyInteger('paid')->default(0);
      $table->string('session');
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
    Schema::dropIfExists('payment_records');
  }
}
