<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Team extends Model
{
  use SoftDeletes;

  public function getImageSrcAttribute($value)
  {
    if ($this->image && Storage::exists($this->image)) {
      return asset('storage/' . $this->image);
    }
    return asset('storage/category/default.png');
  }
}