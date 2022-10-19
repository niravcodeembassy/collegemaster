<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
  public function setNameAttribute($value)
  {
    $this->attributes['name'] = ucwords($value);
  }
}