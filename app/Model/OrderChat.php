<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderChat extends Model
{
    protected $fillable = ['id','customer_id','order_id','msg','type','is_seen'];
}
