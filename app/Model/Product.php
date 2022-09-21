<?php

namespace App\Model;

use App\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
  //
  use SoftDeletes;

  protected $dates = ['product_created_at', 'created_at', 'updated_at'];
  protected $fillable = ['attachment'];
  protected $appends = ['product_src'];

  public function getVarinatAttribute($value)
  {
    return json_decode($value);
  }

  public function buytogetherproducts()
  {
    return $this->belongsToMany(Product::class, 'buy_together', 'product_id', 'related_id');
  }
  //
  public function similarproducts()
  {
    return $this->belongsToMany(Product::class, 'similar_product', 'product_id', 'category_id');
  }

  public function productdefaultvariant()
  {
    return $this->hasone(Productvariant::class, 'product_id', 'id')->where('type', 'single');
  }

  // for front uesg
  public function productvariant()
  {
    return $this->hasone(Productvariant::class, 'product_id', 'id')->where('type', 'variant')
      ->orderBy('id', 'ASC');
  }

  public function productsinglevariant()
  {
    return $this->hasone(Productvariant::class, 'product_id', 'id')->where('type', 'single');
  }

  public function productvariants()
  {
    return $this->hasMany(Productvariant::class, 'product_id', 'id')->where('type', 'variant');
  }

  public function images()
  {
    return $this->hasMany(ProductImage::class, 'product_id', 'id')->orderBy('position', 'ASC');
  }

  public function image()
  {
    return $this->hasOne(ProductImage::class, 'product_id', 'id')->orderBy('position', 'DESC');
  }

  public function defaultimage()
  {
    return $this->hasOne(ProductImage::class, 'product_id', 'id')->where('position', '0');
  }

  public function optionvalues()
  {
    return $this->hasMany(OptionValue::class, 'product_id', 'id');
  }

  public function option()
  {
    return $this->hasMany(ProductOptionValue::class, 'product_id', 'id');
  }

  public function onlyoption()
  {
    return $this->hasMany(ProductOptionValue::class)->groupBy('option_id');
  }

  public function optoinvalue()
  {
    return $this->belongsToMany(OptionValue::class, 'product_option_values', 'product_id', 'option_value_id')->groupBy('option_value_id');
  }

  public function hasncode()
  {
    return $this->belongsTo(HsCode::class, 'hs_id');
  }



  public function offerbanners()
  {
    return $this->hasMany(Offerbanner::class, 'product_id', 'id');
  }

  public function category()
  {
    return $this->belongsTo(Category::class, 'category_id', 'id');
  }

  public function subcategory()
  {
    return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
  }

  public function scopeProduct($query)
  {
    return $query->with('category', 'productdefaultvariant', 'buytogetherproducts');
  }

  public function variantCombination()
  {
    return $this->hasMany(ProductVariantCombination::class, 'product_id', 'id');
  }

  public function productoptionvalue()
  {
    return $this->hasMany(ProductOptionValue::class, 'product_id', 'id');
  }

  public function scopeProductList($query, $groupBy = true)
  {
    $query->select(
      'products.id',
      'products.content',
      'products.product_type',
      'products.slug',
      'products.sku',
      'products.category_id',
      'products.sub_category_id',
      'products.name',
      'v.id as variant_id',
      'v.product_id',
      'v.mrp_price',
      'v.type',
      'v.offer_price',
      'v.taxable_price',
      'v.inventory_quantity',
      \DB::raw('(CASE WHEN v.offer_price IS NOT NULL THEN v.offer_price ELSE v.mrp_price END) AS sort_price')
    )->join('productvariants as v', function ($join) {
      return $join->on('products.id', '=', 'v.product_id')->on('v.type', '=', 'products.product_type');
    })
      ->when(Auth::check(), function ($q) {
        $q->leftjoin('wish_lists as wish', function ($join) {
          return $join->on(function ($q) {
            $q->on('wish.variant_id', '=', 'v.id')
              ->where('wish.user_id', '=', Auth::user()->id);
          });
        })->addSelect('wish.id as wish_lists_id');
      });
    if ($groupBy) {
      $query->groupBy('products.id');
    }
    // $query->orderBy('products.id', 'DESC');
    $query->where('products.is_active', 'Yes');
    return $query;
  }

  /**
   * Scope a query to only include
   *
   * @param  \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeFilterProduct($query, $request)
  {
    return $query->select(
      'products.id',
      'products.slug',
      'products.name',
      'v.id as variant_id',
      'products.created_at as product_created_at',
      'products.has_box as hasbox',
      'products.has_box',
      'products.created_at as product_created_at',
      'v.product_id',
      'v.mrp_price',
      'v.offer_price',
      'v.inventory_quantity',
      'v.productimage_id',
      'v.taxable_price',
      'm.id as image_id',
      'image_name',
      'image_url',
      'products.created_at'
    )
      ->join('productvariants as v', function ($join) {
        return $join->on('products.id', '=', 'v.product_id')
          ->on('v.type', '=', 'products.product_type');
      })
      ->leftJoin('product_images as m', function ($join) {
        return $join->on('v.productimage_id', '=', 'm.id');
      })
      ->leftJoin('wish_lists as wi', function ($join) {
        return $join->on('wi.variant_id', '=', 'v.id')->where('user_id', \Auth::id());
      })
      ->addSelect('wi.id as wishlist')
      ->when(($request->from == '0' || $request->from) && $request->to, function ($q, $stortby) use ($request) {
        $q->whereBetween('v.taxable_price', $request->only('from', 'to'));
      }, function ($q) {
        $q->orderBy('products.id', 'ASC');
      })
      ->groupBy('products.id')
      ->where('products.is_active', 'Yes')
      // ->where('v.inventory_quantity','!=', '0')

    ;
  }


  public function getVariantImageAttribute()
  {
    $imageExist  =  \Storage::disk('public')->exists('product_image/' . $this->image_name);

    if ($imageExist && $this->image_name != NULL && $this->image_name != "") {
      return asset('storage/product_image/' . $this->image_name);
    }

    return asset('storage/default/default.png');
  }

  public function hsncode()
  {
    return $this->belongsTo(HsCode::class, 'hs_id', 'id');
  }

  public function product_review()
  {
    return $this->hasMany(ProductReview::class, 'product_id', 'id');
  }

  public function getProductSrcAttribute()
  {

    foreach ($this->images->take(1) as $item) {
      return $item->variant_image;
    }
  }
}