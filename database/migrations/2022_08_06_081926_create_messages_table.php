<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('messages', function (Blueprint $table) {
      $table->id();
      $table->longText('message')->nullable();
      $table->foreignId('user_id')->constrained();
      $table->unsignedBigInteger('receiver');
      $table->foreign('receiver')->references('id')->on('users');
      $table->unsignedBigInteger('order_id');
      $table->foreign('order_id')->references('id')->on('orders');
      $table->boolean('is_seen')->default(0);
      $table->string('file')->nullable();
      $table->string('file_name')->nullable();
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
    Schema::dropIfExists('messages');
  }
}