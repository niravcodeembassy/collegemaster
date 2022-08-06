<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  protected $fillable = ['message', 'user_id', 'receiver', 'is_seen', 'file'];

  public function user()
  {
    return $this->belongsTo(\App\User::class);
  }

  public function order()
  {
    return $this->belongsTo(Order::class);
  }
}