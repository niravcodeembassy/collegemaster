<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingCountry extends Model
{
    //
    use SoftDeletes;

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
