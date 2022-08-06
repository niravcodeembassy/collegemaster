<?php

namespace App;

use App\Model\CartImage;
use App\Model\Order;
use App\Model\ShoppingCart;
use App\Model\UserShippingAddress;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];


  public function address()
  {
    return $this->hasOne(UserShippingAddress::class, 'user_id', 'id');
  }

  public function cartimage()
  {
    return $this->hasMany(CartImage::class);
  }

  public function shoppingcart()
  {
    return $this->hasMany(ShoppingCart::class);
  }

  public function orders()
  {
    return $this->hasMany(Order::class);
  }

  public function getProfileSrcAttribute()
  {
    $imageExist  =  Storage::disk('public')->exists($this->profile_image);

    if ($imageExist && $this->profile_image != NULL && $this->profile_image != "") {
      return asset('storage/' . $this->profile_image);
    }

    return asset('storage/default/default.png');
  }

  public function message()
  {
    return $this->hasMany(Message::class);
  }
}