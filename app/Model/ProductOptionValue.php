<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    //
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id', 'id');
    }

   
}
