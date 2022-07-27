<?php

namespace App\Repository\Discount;

use App\Helpers\Helper;
use App\Repository\Contracts\DiscountApplyTo;
use App\Repository\Contracts\AbstractDicountClass;

class CalculateProductDiscount extends AbstractDicountClass implements DiscountApplyTo
{

    public $code;
    public $product;
    public $error;

    public function __construct($code, $product)
    {
        $this->code = $code;
        $this->product = $product;
    }

    public function minimumRequirement()
    {


        if ($this->code->minimum_requirement == 'none') {
            return $this;
        }

        $product = $this->product->pluck('productvariant');
        $discountProduct = $this->code->products->pluck('id');
        $hasProduct = $this->product->whereIn('product_id', $discountProduct->toArray());

        if ($discountProduct->count() > 0 && $hasProduct->count() > 0) {
            // $sum = $hasProduct->sum('taxable_price');
            $sum = $this->getDicountProductSum($hasProduct);

            if ($this->code->min_amount > $sum) {
                $this->error[] = 'Product amount must be greater than $ ' . $this->code->min_amount;
            }
        }

        return $this;
    }

    public function discounttype()
    {
        if ($this->code->discount_type == 'amount') {
            $this->calAmout();
        } else {
            $this->calPer();
        }
        return $this;
    }

    protected function calAmout()
    {

        $discountProduct = $this->code->products->pluck('id');
        $hasProduct = $this->product->whereIn('product_id', $discountProduct->toArray());
        // $productKey =  $hasProduct->keys();
        // $product  = $this->product->pluck('product')->whereIn('id',$productKey->toArray()) ;

        if ($discountProduct->count() > 0 && $hasProduct->count() > 0) {

            // $sum = $hasProduct->sum('taxable_price');
            $sum = $this->getDicountProductSum($hasProduct);

            $perTax = (100 * $this->code->discount) / $sum;
            $self = $this;
            $hasProduct->map(function ($item, $index) use ($perTax, $self) {
                $amount = $self->getTaxablePrice($item);
                $discount = Helper::percentage($perTax, $amount);
                if ($discount < $amount) {
                    $item->discount_amount = Helper::percentage($perTax, $amount);
                    $item->discount_per = $perTax;
                } else {
                    $self->error[] = "Amount must be grater then discount amount ";
                }
                return $item;
            });

            return $this;
        }


        $this->error[] = 'Apply coupon not eligible this product';

        return $this;
    }

    protected function calPer()
    {
        $discountProduct = $this->code->products->pluck('id');
        $hasProduct = $this->product->whereIn('product_id', $discountProduct->toArray());

        if ($discountProduct->count() > 0 && $hasProduct->count() > 0) {

            // $sum = $hasProduct->sum('taxable_price');
            $sum = $this->getDicountProductSum($hasProduct);
            $discount = $this->code->discount;
            $self = $this;

            $hasProduct->map(function ($item, $index) use ($sum, $discount, $self) {
                $amount = $self->getTaxablePrice($item);
                $perTax = ($item->taxable_price * $discount) / $sum;
                $perTax = ($amount * $discount) / $sum;
                // $perTax = $discount;

                $discount = Helper::percentage($perTax, $amount);

                if ($discount < $amount) {
                    $item->discount_amount = Helper::percentage($perTax, $amount);
                    $item->discount_per = $perTax;
                } else {
                    $self->error[] = "Amount must be grater then discount amount ";
                }

                return $item;
            });

            return $this;
        }

        $this->error[] = 'Apply coupon not eligible this product';


        return $this;
    }

    public function mapCart()
    {
        return $this->minimumRequirement()->discounttype()->getTotalTaxDiscount();
    }
}
