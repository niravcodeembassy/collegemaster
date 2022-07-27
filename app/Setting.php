<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'response'];

    public function getResponseAttribute($value)
    {
        return json_decode($value);
    }

    public function getLogoAttribute()
    {
        $imageExist  =  \Storage::exists($this->response->logo);
        if ($imageExist && $this->response->logo != NULL && $this->response->logo != "") {
            return asset('storage/' . $this->response->logo);
        }
        return asset('storage/default/default.png');
    }


    public function getFaviconAttribute()
    {
        $imageExist  =  \Storage::exists($this->response->favicon);
        if ($imageExist && $this->response->favicon != NULL && $this->response->favicon != "") {
            return asset('storage/' . $this->response->favicon);
        }
        return asset('storage/default/default.png');
    }

    public static function generalSettings()
    {
        return self::where('name', 'general_settings');
    }
}
