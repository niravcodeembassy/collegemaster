<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CommonBanner extends Model
{
    //
    public $timestamps = false;

    public function getBannerImageAttribute()
    {

        $imageExist  =  \Storage::exists($this->image);
        if ($imageExist && $this->image != NULL && $this->image != "") {
            return asset('storage/' . $this->image);
        }
        return asset('storage/default/default.png');
    }
}
