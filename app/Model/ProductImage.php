<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{

  protected $guarded = [];

  protected $appends  = ['variant_image'];


  public static function boot()
  {
    parent::boot();
    static::deleted(function ($image) {
      \Storage::delete($image->image_url);
    });
  }

  //
  // public $timestamps = false;

  public function getVariantImageAttribute()
  {
    $imageExist  =  \Storage::disk('public')->exists($this->image_url);

    if ($imageExist && $this->image_name != NULL && $this->image_name != "") {
      return asset('storage/' . $this->image_url);
    }

    return asset('storage/default/default.png');
  }
}