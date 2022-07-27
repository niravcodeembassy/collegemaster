<?php

namespace App\Helpers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Helper
{

    public static function isActive($routePattern = null, $class = 'active', $prfix = 'admin.')
    {
        // Convert to array
        $name = Route::currentRouteName();

        if (!is_array($routePattern) && $routePattern != null) {
            $routePattern = explode(' ', $routePattern);
        }

        foreach ((array) $routePattern as $i) {
            if (Str::is($prfix . $i, $name)) {
                return $class;
            }
        }

        foreach ((array) $routePattern as $i) {
            if (Str::is($i, $name)) {
                return $class;
            }
        }
    }

    public static function calcTaxAmount($price, $taxRate, $priceIncludeTax = false, $taxPrice = false, $round = true)
    {
        $taxRate = $taxRate / 100;

        if ($priceIncludeTax) {
            $amount = $price * (1 - 1 / (1 + $taxRate));
            $amount = $price - $amount;

            if ($taxPrice) {

                $amount = $price * (1 - 1 / (1 + $taxRate));
            }
        } else {
            $amount = $price * $taxRate;
            $amount = $price + $amount;

            if ($taxPrice) {

                $amount = $price * $taxRate;
            }
        }

        if ($round) {
            $amount = round($amount, 2);
        }

        return $amount;
    }

    public static function productPrice($product)
    {
        if ($product->offer_price) {
            $discount = (100 * $product->offer_price) /  $product->mrp_price;
            $discount = 100 - round($discount, 2);
        }
        return (object) [
            'price' =>  Helper::priceFormate($product->offer_price ?? $product->mrp_price),
            'offer_price' => Helper::priceFormate($product->offer_price ? $product->mrp_price : null),
            'dicount' => $discount ?? null
        ];
    }

    public static function priceFormate($price)
    {
        if (is_null($price)) {
            return $price;
        }
        return '$ ' . $price;
    }

    public static function showPrice($price)
    {
        return static::priceFormate(number_format($price, 2));
    }

    public static function orderNumber()
    {
        $setting = Setting::first()->response;
        $orderNum = \DB::table('orders')->select('order_no')->orderBy('id', 'DESC')->first();
        $incrementOrderNum = (!empty($orderNum)) ? $orderNum->order_no + 1 : 1000;

        return [
            'order_number' => ($setting->order_prefix ?? '') . str_pad($incrementOrderNum,  4 , "0", STR_PAD_LEFT) . ($setting->order_suffix ?? ''),
            'order_no' => $incrementOrderNum
        ];
    }

    public static function percentage($per, $total, $formate = false)
    {
        $total = str_replace(',', '', $total);
        $amout = ($per / 100) * $total;

        if ($formate) {
            return number_format($amout, 2, '.', '');
        }
        return $amout;
    }
}
