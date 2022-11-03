<?php

namespace App;

use App\Model\CartImage;
use App\Model\Country;
use App\Model\Order;
use App\Notifications\Auth\ResetPassword;
use App\Notifications\Auth\VerifyEmail;
use App\Model\ShoppingCart;
use App\Model\UserShippingAddress;
use App\Model\WishList;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
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

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new ResetPassword($token));
  }

  public function sendEmailVerificationNotification()
  {
    $this->notify(new VerifyEmail);
  }

  public function address()
  {
    return $this->hasOne(UserShippingAddress::class, 'user_id', 'id');
  }

  public function country()
  {
    return $this->belongsTo(Country::class, 'country_id');
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

  public function wishlist()
  {
    return $this->hasMany(WishList::class, 'user_id');
  }

  public function getProfileSrcAttribute()
  {
    $imageExist  =  Storage::disk('public')->exists($this->profile_image);

    if ($imageExist && $this->profile_image != NULL && $this->profile_image != "") {
      return asset('storage/' . $this->profile_image);
    }

    return 'https://ui-avatars.com/api/?name=' . $this->name;
  }

  public function getFirstNameAttribute($value)
  {
    return ucwords($value);
  }

  public function getLastNameAttribute($value)
  {
    return ucwords($value);
  }

  public function getNameAttribute($value)
  {
    return ucwords($value);
  }

  public function message()
  {
    return $this->hasMany(Message::class);
  }

  public function getAddress1Attribute($value)
  {
    return strtoupper($value);
  }

  public function getAddress2Attribute($value)
  {
    return strtoupper($value);
  }
}
