<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('stories', function (Blueprint $table) {
      $table->id();
      $table->string('title')->nullable();
      $table->string('video_url')->nullable();
      $table->longText('description')->nullable();
      $table->string('instagram_handle')->nullable();
      $table->string('instagram_handle_url')->nullable();
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
    Schema::dropIfExists('stories');
  }
}