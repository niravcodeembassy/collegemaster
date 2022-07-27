<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HsCode extends Model
{
    //
    // public $timestamps = false;

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public function optionvalues()
    {
        return $this->hasMany(OptionValue::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('is_active')->get();
    }

}
