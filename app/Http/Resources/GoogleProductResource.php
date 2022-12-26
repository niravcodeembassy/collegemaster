<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GoogleProductResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $varint = json_decode($this->variants);
    $array = get_object_vars($varint);
    return [
      "batchId" => $this->id,
      "merchantId" => 592418806,
      "method" => 'insert',
      'product' => [
        'offerId' => $this->id,
        'itemGroupId' => $this->product->id,
        'title' => $this->product->name,
        'description' => $this->product->content,
        // 'link' => route('product.view', $this->product->slug),
        'link' => 'https://www.collagemaster.com/product/personalized-1st-birthday-wall-art-gift-for-baby-girlboy',
        // 'imageLink' => 'https://www.collegemaster.com/storage/' . $this->image->image_url,
        'imageLink' => 'https://www.collagemaster.com/storage/product_image/1/Personalized_1st_Birthday_Wall_Art_Gift_For_Baby_Girl/Boy_Sample_Photo.jpg',
        'contentLanguage' => 'en',
        'targetCountry' => 'IN',
        'brand' => 'CollageMaster',
        'channel' => 'online',
        'availability' => 'in stock',
        'condition' => 'new',
        "price" => [
          'value' => $this->mrp_price,
          'currency' => 'USD'
        ],
        "salePrice" => [
          'value' => $this->offer_price,
          'currency' => 'USD'
        ],
        "material" => $array['printing options'],
        "sizes" => [
          $varint->size
        ]
      ],
    ];
  }
}
