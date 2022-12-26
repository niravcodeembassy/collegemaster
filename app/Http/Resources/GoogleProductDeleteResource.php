<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GoogleProductDeleteResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      "batchId" => $this->id,
      "merchantId" => 592418806,
      "method" => 'delete',
      "productId" => sprintf(
        '%s:%s:%s:%s',
        'online',
        'en',
        'IN',
        $this->id
      )
    ];
  }
}
