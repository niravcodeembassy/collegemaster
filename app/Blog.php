<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Blog extends Model
{
  use SoftDeletes;

  public function getImageSrcAttribute($value)
  {
    if ($this->image && Storage::exists($this->image)) {
      return asset('storage/' . $this->image);
    }
    return asset('storage/category/default.png');
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class);
  }
}