<?php

namespace App;

use App\Model\Product;
use App\Model\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    //
    use SoftDeletes;

    public function subCategory()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImageSrcAttribute($value)
    {
        if($this->image && Storage::exists($this->image) ) {
            return asset('storage/'.$this->image);
        }
        return asset('storage/category/default.png');
    }
}
