<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Homepagebanner extends Model
{
    //
    public function getSliderImageAttribute()
    {
        
        $imageExist  =  \Storage::exists($this->slider_img);
        
        if($imageExist && $this->slider_img != NULL && $this->slider_img != "" ) {
            return asset('storage/'.$this->slider_img )  ;
        }

        return asset('storage/default/default.png');

    }
}
