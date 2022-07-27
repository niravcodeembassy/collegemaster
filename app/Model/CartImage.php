<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CartImage extends Model
{

    protected $guarded = [];


    public static function boot()
    {
        parent::boot();
        static::deleted(function ($image) {
            \Storage::delete($image->image_url);
        });
    }

    //
    // public $timestamps = false;

    public function getCartImageAttribute()
    {
        $imageExist  =  \Storage::disk('public')->exists($this->path);

        if ($imageExist && $this->path != NULL && $this->path != "") {
            return asset('storage/' . $this->path);
        }

        return asset('storage/default/default.png');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function item()
    {
        return $this->belongsTo(OrderItem::class, 'item_id');
    }
}
