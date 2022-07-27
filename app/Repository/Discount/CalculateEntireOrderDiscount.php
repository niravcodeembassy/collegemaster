<?php

namespace App\Repository\Discount;

use App\Repository\Contracts\DiscountApplyTo;
use App\Repository\Contracts\AbstractDicountClass;
use App\Helpers\Helper;


class CalculateEntireOrderDiscount extends AbstractDicountClass implements DiscountApplyTo
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
        if ($this->product->count() > 0) {
            $sum = $this->getDicountProductSum($this->product);
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

        $productvariant = $this->product;

        if ($productvariant->count() > 0) {

            $sum = $this->getDicountProductSum($productvariant);
            $self = $this;
            $perTax = (100 * $this->code->discount) / $sum;

            $productvariant->map(function ($item, $index) use ($perTax, $self) {

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

        // $this->error[] = 'Applicable products are' . $this->code->products->pluck('name')->join(',');
        $this->error[] = 'Apply coupon not eligible';

        return $this;
    }

    protected function calPer()
    {

        $productvariant = $this->product;

        if ($productvariant->count() > 0) {

            // $sum = $hasProduct->sum('taxable_price');
            $sum = $this->getDicountProductSum($productvariant);

            $discount = $this->code->discount;

            $perTax = (100 * $this->code->discount) / $sum;

            $self = $this;


            $productvariant->map(function ($item, $index) use ($sum, $discount, $self) {

                $amount = $self->getTaxablePrice($item);
                // $perTax = ($amount * $discount) / $sum  ;
                $perTax = $discount;
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

        // $this->error[] = 'Applicable products are' . $this->code->products->pluck('name')->join(',');
        $this->error[] = 'Apply coupon not eligible';

        return $this;
    }

    public function mapCart()
    {
        return $this->minimumRequirement()->discounttype()->getTotalTaxDiscount();
    }
}
