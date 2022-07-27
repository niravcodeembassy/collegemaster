<?php

namespace App\Model;

use App\Model\Product;
use Illuminate\Database\Eloquent\Model;

class DealOfDay extends Model
{
    protected $fillable = [
        'title',
        'btn_name',
        'btn_url',
        'product_id',
        'start_time',
        'end_time',
        'bg_img',
        'status'
    ];

    public  function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
