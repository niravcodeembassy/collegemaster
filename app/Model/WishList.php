<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    //
    public function variant()
    {
        return $this->hasMany(Productvariant::class);
    }
}
