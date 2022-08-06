<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
  public function image()
  {
    return $this->hasMany(StoryImage::class);
  }
}