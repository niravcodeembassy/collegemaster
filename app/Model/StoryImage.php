<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StoryImage extends Model
{
  protected $appends  = ['image_url'];

  public function story()
  {
    return $this->belongsTo(Story::class);
  }

  public function getImageUrlAttribute()
  {
    $imageExist  = $this->image && \Storage::exists($this->image);
    if ($imageExist && $this->image != NULL && $this->image != "") {
      return asset('storage/' . $this->image);
    }
    return asset('storage/default/default.png');
  }
}