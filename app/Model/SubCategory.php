<?php

namespace App\Model;

use App\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class SubCategory extends Model
{
  //
  use SoftDeletes;

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function product()
  {
    return $this->hasMany(Product::class);
  }

  public function getImageSrcAttribute($value)
  {
    if ($this->image && Storage::exists($this->image)) {
      return asset('storage/' . $this->image);
    }
    return asset('storage/category/default.png');
  }
}