<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductVariantCombination extends Model
{
    //
    // public $timestamps = false;


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function variant()
    {
        return $this->belongsTo(Productvariant::class, 'variant_id', 'id');
    }
    
    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id', 'id');
    }
    
    public function optionvalue()
    {
        return $this->belongsTo(OptionValue::class, 'option_value_id', 'id');
    }


    public function scopeFilterVariantByProduct($query , $matrix , $product)
    {
        return $query->when(isset($matrix), function ($query) use ($matrix) {
            foreach ($matrix as $keya => $data) {
                if (count($data) < 1) {
                    continue;
                }
                if ($keya == 0) {
                    $query->where(function ($query) use ($data) {
                        foreach ($data as $key => $value) {
                            $query->whereJsonContains('variants->' . $key, $value);
                        }
                        return $query;
                    });
                } else {
                    $query->orWhere(function ($query) use ($data) {
                        foreach ($data as $key => $value) {
                            $query->whereJsonContains('variants->' . $key, $value);
                        }
                        return $query;
                    });
                }
            }
            return $query;
        })->groupBy('variant_id')->whereIn('product_variant_combinations.product_id', $product);
    }

    public function getVariantsAttribute($value)
    {
        return json_decode($value ,true);
    }

}
