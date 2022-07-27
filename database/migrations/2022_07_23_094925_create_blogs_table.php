<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('blogs', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('slug');
      $table->text('content')->nullable();
      $table->longText('description')->nullable();
      $table->timestamp('is_active')->nullable();
      $table->text('image')->nullable();
      $table->timestamp('published_at')->nullable();
      $table->string('meta_title')->nullable();
      $table->string('meta_description')->nullable();
      $table->string('meta_keywords')->nullable();
      $table->string('handle')->nullable();
      $table->softDeletes();
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
    Schema::dropIfExists('blogs');
  }
}