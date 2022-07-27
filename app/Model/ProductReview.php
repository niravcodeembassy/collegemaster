<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    //
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
