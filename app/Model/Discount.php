<?php

namespace App\Model;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
    protected $dates = [
        'created_at',
        'updated_at',
        'start_date',
        'end_date'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class ,'discount_items','discount_id','product_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class ,'discount_items','discount_id','category_id');
    }

    public function scopeDiscountItem($query)
    {
        return $query->with(['products' => function($q){
            return $q->select('products.id' , 'products.name');
        } ,'categories']);
    }

}
