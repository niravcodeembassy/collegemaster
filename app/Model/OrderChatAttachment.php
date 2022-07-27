<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderChatAttachment extends Model
{
    protected $fillable = ['chat_id','attachment'];
}
