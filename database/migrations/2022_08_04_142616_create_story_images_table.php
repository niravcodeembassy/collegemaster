<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryImagesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('story_images', function (Blueprint $table) {
      $table->id();
      $table->text('image')->nullable();
      $table->string('image_name')->nullable();
      $table->string('image_url')->nullable();
      $table->unsignedBigInteger('story_id');
      $table->foreign('story_id')->references('id')->on('stories')->onDelete('cascade');
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
    Schema::dropIfExists('story_images');
  }
}