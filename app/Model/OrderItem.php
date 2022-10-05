<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
  //
  // use SoftDeletes;

  public function items()
  {
    return $this->belongsTo(Order::class);
  }

  public function images()
  {
    return $this->hasMany(CartImage::class, 'item_id', 'id')->where('sequence', 2);
  }

  public function order()
  {
    return $this->belongsTo(Order::class);
  }
}