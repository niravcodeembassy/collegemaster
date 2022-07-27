<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Order extends Model
{

    protected  $guarded = [];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function itemslists()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function getDeliveryStatusAttribute()
    {
        if ($this->order_status == 'order_placed') {
            return 'order placed';
        }
        return $this->order_status;
    }

    public function singleItem()
    {
        return $this->hasOne(OrderItem::class, 'order_id');
    }
}
