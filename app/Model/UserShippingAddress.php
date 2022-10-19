<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserShippingAddress extends Model
{
  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  public function getAddressOneAttribute($value)
  {
    return strtoupper($value);
  }

  public function getAddressTwoAttribute($value)
  {
    return strtoupper($value);
  }
}