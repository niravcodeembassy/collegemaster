<?php

namespace App\Repository\Contracts;

use App\Helpers\Helper;
use Illuminate\Support\Arr;

class AbstractDicountClass
{

  public $cart;
  public $product = [];

  public function getDicountProductSum($discountCategoryProduct, $withoutTaxable = false)
  {

    $self = $this;
    return $discountCategoryProduct->sum(function ($item) use ($self, $withoutTaxable) {
      return $self->getTaxablePrice($item, $withoutTaxable);
    });
  }

  public function getTaxablePrice($item, $withoutTaxable = false)
  {

    // $tax = $item->taxable_price * $item->qty ;
    $tax = $item->taxable_price;
    $price  = $item->final_price;

    if ($item->tax_type == 0 && $item->tax_percentage != 0) {
      // $price = $price * $item->qty ;
      $taxPrice  = Helper::percentage($item->tax_percentage,  $price);
      if ($withoutTaxable == false && $item->tax_type == 0) {
        $tax = $price;
      } else {
        if ($withoutTaxable) {
          $tax = $price;
        } else {
          $tax = $price - $taxPrice;
        }
      }
      // $tax = $price - $taxPrice ;
    }

    return $tax;
  }

  protected function getPrice($item)
  {
    return  $item->productvariant->offer_price ?? $item->productvariant->mrp_price;
  }

  public function getTotalTaxDiscount()
  {

    $sum =  $this->product->sum(function ($item) {


      $amount = $price = $this->getTaxablePrice($item, true);
      if (property_exists($item, 'discount_amount')) {
        $amount = $amount -  $item->discount_amount;
        $tax = Helper::calcTaxAmount($amount, $item->tax_percentage ?? 0, false, true);
      } else {
        $amount = $item->final_price;
        $tax = Helper::calcTaxAmount($amount, $item->tax_percentage ?? 0, $item->tax_type ?? false, true);
      }
      $normalDiscount = Helper::percentage($item->discount_per, $item->final_price_total);
      // // $this->cart[] = (object) [

      $this->cart[] = (object)  [
        'id' => $item->product_id,
        'name' => $item->name,
        'product_id' => $item->product_id,
        'tax_type' => $item->tax_type,
        'variant_id' => $item->variant_id,
        'image_id' => $item->image_id,
        'price' => $item->price,
        'qty_price' => $item->qty_price,
        'final_price_total' => $item->final_price_total - $normalDiscount ?? 0,
        'total' => $price,
        'final_price' => $amount,
        'qty' => $item->qty,
        'attribute' => $item->attribute,
        'discount_amount' => $item->discount_amount ?? 0,
        'discount_in_percentage' => $item->discount_per ?? 0,
        'tax_percentage' => $item->tax_percentage,
        'taxable_price' => $amount,
        'discount' => $normalDiscount,
        'hsn_cod' => $item->hsn_cod,
        'tax' =>   $tax,
        'notes' => $item->notes
      ];

      return  $tax;
    });

    return  $sum;
  }

  public function getTotalDiscount()
  {
    return collect($this->cart)->sum('discount_amount');
  }

  public function getSubTotal()
  {
    $getTotalDiscount = $this->getTotalDiscount();
    $subtotal = collect($this->cart)->sum('total');
    return $subtotal;
  }

  public function getSubTotalWithoutDiscount()
  {
    $getTotalDiscount = $this->getTotalDiscount();
    $subtotal = collect($this->cart)->sum('total');
    return $subtotal;
  }
}