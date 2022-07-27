<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionValue extends Model
{
    //
    use SoftDeletes;
    
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
