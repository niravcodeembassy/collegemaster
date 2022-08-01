<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrequentAskQuestion extends Model
{
  protected $guarded = [];
  use SoftDeletes;
  public function parent()
  {
    return $this->belongsTo(FrequentAskQuestion::class, 'parent_id');
  }

  public function children()
  {
    return $this->hasMany(FrequentAskQuestion::class, 'parent_id');
  }
}