<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
    public function cartimage()
    {
        return $this->hasMany(CartImage::class, 'cart_id', 'id');
    }

    public function image()
    {
        // return $this->belongsTo(Productimage::class,'variant_ids','id');
        return $this->belongsTo(ProductImage::class, 'image_id', 'id');
    }

    public function productvariant()
    {
        return $this->belongsTo(Productvariant::class, 'variant_id', 'id');
    }
    /*public function productoptionvalue()
		    {
		    return $this->hasOne(ProductoptionValue::class, 'product_id', 'id');
	*/

    public function scopeApiCartList($query, $device = null, $user_id = null)
    {
        $query = $query->with([
            'product' => function ($query) {
                $query->select('id', 'products.*')->with([
                    'productoptions' => function ($query) {
                        return $query->select('id', 'product_id', 'option_name');
                    }
                ]);
            },
            'image' => function ($query) {
                return $query->select('id', 'image_url as image_src');
            }, 'productvariant',
        ])
            ->when($user_id, function ($query, $user_id) {
                return $query->where('user_id', $user_id);
            });
        // dd(Auth::guard('api')->user());
        if (!Auth::guard('api')->user()) {
            $query->when($device, function ($query, $device) {
                $q = $query->where('device_id', $device)->whereNull('user_id');
                \Log::alert(Auth::guard('api')->user());
                return $q;
            });
        }

        return $query;
    }

    public function scopeCartList($query, $device, $user_id)
    {

        $query = $query->with([
            'product' => function ($query) {
                $query->select('id', 'products.*');
            },
            'image' => function ($query) {
                return $query->select('id', 'image_url as image_src');
            }, 'productvariant',
        ])
            ->when($user_id, function ($query, $user_id) {
                return $query->where('user_id', $user_id);
            });

        if ($user_id == 0 && $device != "") {

            $query->when($device, function ($query, $device) {
                $q = $query->where('session_id', $device)->where('user_id', 0);
                return $q;
            });
        }

        return $query;
    }

    public function getImageSrcAttribute($value)
    {
        // dd($value);
        if (is_null($value) || $value == "") {
            return null;
        }
        return asset('storage/' . $value);
    }
	

}
