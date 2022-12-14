<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\Storage;

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

  public function getWhatsappStatusAttribute($value)
  {
    if ($value == null) {
      $data = [
        'order_placed' => false,
        'dispatched' => false,
        'delivered' => false,
        'cancelled' => false,
        'customer_approval' => false,
        'work_in_progress' => false,
        'pick_not_receive' => false,
        'correction' => false,
        'printing' => false,
        'refund' => false,
      ];
      return json_encode($data);
    }
    return $value;
  }

  public function getSmsStatusAttribute($value)
  {
    if ($value == null) {
      $data = [
        'order_placed' => false,
        'dispatched' => false,
        'delivered' => false,
        'cancelled' => false,
        'customer_approval' => false,
        'work_in_progress' => false,
        'pick_not_receive' => false,
        'correction' => false,
        'printing' => false,
        'refund' => false,
      ];
      return json_encode($data);
    }
    return $value;
  }

  public function singleItem()
  {
    return $this->hasOne(OrderItem::class, 'order_id');
  }

  public function message()
  {
    return $this->hasMany(Message::class);
  }

  public function getApprovalImageSrcAttribute()
  {
    if ($this->approval_image && Storage::exists($this->approval_image)) {
      return asset('storage/' . $this->approval_image);
    }
    return asset('storage/category/default.png');
  }
}
