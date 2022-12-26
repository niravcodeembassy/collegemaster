<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Productvariant extends Model
{
  protected $guarded = [];
  //
  // public $timestamps = false;

  /**
   * Get the post title.
   *
   * @param  string  $value
   * @return string
   */


  public function getFinalPriceAttribute()
  {
    if ($this->offer_price && $this->offer_price != '0.00' && $this->offer_price != null) {
      return $this->offer_price;
    }
    return $this->mrp_price;
  }

  public function setOfferPriceAttribute($value)
  {
    if (floatval($value) > 0) {
      $this->attributes['offer_price'] = $value;
    } else {
      $this->attributes['offer_price'] = null;
    }
  }

  public function setTaxablePriceAttribute($value)
  {

    if (is_null($this->offer_price) && floatval($value) <= 0) {
      return $this->attributes['taxable_price'] =  $this->attributes['mrp_price'];;
    }

    $this->attributes['taxable_price'] = $value;
  }

  public function productdefault()
  {
    return $this->belongsTo(Product::class, 'product_id', 'id');
  }

  public function image()
  {
    return $this->belongsTo(ProductImage::class, 'productimage_id', 'id')->withDefault([
      'variant_image' => null
    ]);
  }


  public function images()
  {
    return $this->belongsTo(ProductImage::class, 'productimage_id', 'id');
  }

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id', 'id');
  }

  public function variantCombination()
  {
    return $this->hasMany(ProductVariantCombination::class, 'variant_id', 'id');
  }

  public function variantCombinationone()
  {
    return $this->hasOne(ProductVariantCombination::class, 'variant_id', 'id');
  }

  public function sameProduct()
  {
    return $this->hasMany(SimilarProduct::class, 'product_id', 'product_id');
  }

  public function varintOption()
  {
    return $this->hasMany(ProductOptionValue::class, 'product_id', 'local_key');
  }


  public function wishlist()
  {
    return $this->hasMany(WishList::class, 'variant_id');
  }
}
