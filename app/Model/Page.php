<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    protected $guarded = [];

    public function getPageImageAttribute()
    {
        $imageExist  =  \Storage::disk('public')->exists($this->slider_image);
        if($imageExist) {
            return asset('storage/'.$this->slider_image )  ;
        }
        return asset('storage/default/default.png');

    }
}
