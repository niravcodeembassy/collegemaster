<?php

namespace App\Repository;

use App\Model\ShoppingCart;
use App\Repository\Contracts\Cart;
use App\Repository\Discount\CalculateEntireOrderDiscount;
use App\Repository\Discount\CalculateProductDiscount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Helpers\Helper;
use App\Model\Discount;
use App\Setting;
use Illuminate\Support\Facades\Storage;

use function GuzzleHttp\json_decode;

class DbCart implements Cart
{

  protected $shoppingCart;

  function __construct(ShoppingCart $shoppingCart, Request $request)
  {
    $this->cart = $shoppingCart;
    $this->request = $request;
  }

  public function add()
  {
    //Add to cart item
    if (!Auth::check() && !Session::has('cart_session')) {
      Session::put('cart_session', Session::getId());
    }


    $this->session_id = Session::get('cart_session');

    $userId = Auth::check() ? Auth::user()->id : null;

    try {
      $product = $this->cart->updateOrCreate(
        [
          'product_id' => $this->request->product_id,
          'variant_id' => $this->request->variant_id,
          'session_id' => $this->session_id,
          'user_id' => $userId
        ],
        [
          'image_id' => $this->request->image_id,
          'user_id' => $userId,
          'product_id' => $this->request->product_id,
          'variant_id' => $this->request->variant_id,
          'session_id' => $this->session_id,
          'notes' =>  $this->request->cartnotes
        ]
      );

      if ($this->request->get('update')) { // call from update
        $product->qty = $this->request->qty;
        $product->save();
      } else {
        $product->increment('qty', $this->request->qty);
      }

      return $product;
    } catch (Exception $e) {
      throw new Exception("Error Processing Request", 2);
    }
  }

  public function update()
  {
    try {
      // dd($this->request->input('user_id'));
      $this->cart->where('id', $this->request->id)->update([
        'qty' => $this->request->qty
      ]);
      return $this->cart;
    } catch (Exception $e) {
      throw new Exception("Error Processing Request", 1);
    }
  }

  public function remove()
  {

    $this->session_id = Session::get('cart_session');

    $sessionId = $this->session_id;

    try {
      // dd($this->request->input('user_id'));
      $cart = $this->cart->with('cartimage')->where('id', $this->request->id)->when(Auth::check(), function ($query) {
        $query->where('user_id', Auth::user()->id);
      }, function ($query) use ($sessionId) {
        $query->where('session_id', $sessionId);
      })->first();

      Storage::deleteDirectory('cart_image/' . $cart->id);

      $cart->delete();
    } catch (Exception $e) {
      throw new Exception("Error Processing Request", 3);
    }
  }

  public function get()
  {
    try {

      $sessionId = Session::get('cart_session');

      $cartItem = $this->cart->with('product:id,name,slug,hs_id,category_id,sub_category_id,attachment,tax_type,tax', 'productvariant', 'image',)
        ->when(Auth::check(), function ($query) {
          $query->where('user_id', Auth::user()->id);
        }, function ($query) use ($sessionId) {
          $query->where('session_id', $sessionId)->where('user_id', null);
        })->get();

      return  $cartItem;
    } catch (\Exception $e) {
      throw new Exception("Error Processing Request", 4);
    }
  }

  public function count()
  {

    try {

      $sessionId = Session::get('cart_session');

      $count = $this->cart->when(Auth::check(), function ($query) {
        $query->where('user_id', Auth::user()->id);
      }, function ($query) use ($sessionId) {
        $query->where('session_id', $sessionId)->where('user_id', null);
      })->count();

      return  $count;
    } catch (\Exception $e) {
      throw new Exception("Error Processing Request", 4);
    }
  }

  public function mapCart()
  {

    $cart = $this->get();
    $setting = Setting::where('name', 'general_settings')->first()->response;

    $cart = $cart->map(function ($cart) {
      // dd($cart)
      $priceData = Helper::productPrice($cart->productvariant);
      $cartSubTotal = $cart->qty * ($cart->productvariant->final_price);
      $variant = json_decode($cart->productvariant->variants);

      $variant = collect($variant)->map(function ($key, $item) {
        return '<span class="product-variation">' . ucfirst($item) . ': ' . ucfirst($key) . '</span>';
      })->join('<br />');

      $taxAblePrice = $cart->productvariant->taxable_price * $cart->qty;
      $tax = ($cart->productvariant->final_price * $cart->qty) - $taxAblePrice;

      return [
        'id'  => $cart->id,
        'name'  => $cart->product->name,
        'qty'  => $cart->qty,
        'price' => (float) $cart->productvariant->final_price,
        'qty_price' => (float) $cart->productvariant->final_price  * $cart->qty,
        'total'  => $taxAblePrice,
        'final_price_total'  => (float) $cart->productvariant->final_price * $cart->qty,
        'final_price'  => (float) $cart->productvariant->final_price * $cart->qty,
        'product_id'  => $cart->product_id,
        'variant_id' => $cart->productvariant->id,
        'image_id' => $cart->productvariant->productimage_id,
        'attribute'  => $cart->productvariant->variants,
        'tax_type'  => $cart->product->tax_type,
        'tax_percentage'  => $cart->product->tax,
        'tax'  => $tax,
        'taxable_price'  =>  $taxAblePrice,
        'discount_amount' => 0,
        'hsn_cod' => $cart->product->hasncode->name,
        'notes' => $cart->notes,
        'order_has_gift' => $cart->order_has_gift,
        'gift_message' => $cart->gift_message,
      ];
    });

    Session::forget('coupon_error');

    if (request('discount_code', null) && request()->discount_code != null && request()->discount_code != "") {
      $newCart = $this->applyDiscount($cart);
      if (is_array($newCart)) {
        $cart = collect($newCart);
      }
    }
    $shippingCharge = 0;
    $discount = $cart->sum('discount_amount', 0);
    $normalDiscount = $cart->sum('discount', 0);
    $sub_total = $cart->sum('total', 0);
    $showSubTotal = $cart->sum('qty_price', 0);
    $tax = $cart->sum('tax', 0);
    $shippingSubTotal = $sub_total - $discount;

    if (($shippingSubTotal) < $setting->free_shipping) {
      $shippingCharge = (float) $setting->shipping_amount;
    }

    $data['cart'] = $cart;
    $data['sub_total'] = $showSubTotal;
    $data['show_sub_total'] = $showSubTotal;
    $data['shipping_charge'] = $shippingCharge;
    $data['tax'] = $tax;
    $data['discount'] = $normalDiscount;
    $data['total'] = $showSubTotal + $shippingCharge - $normalDiscount;
    $data['show_total'] = $showSubTotal + $shippingCharge - $normalDiscount;
    // dump($data);
    return $data;
  }


  public function applyDiscount($cart)
  {
    $cart = collect(json_decode(json_encode($cart)));

    $discount = Discount::with('products')->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->where('discount_code', request('discount_code'))->whereNull('is_active')->first();
    $this->coupon = $discount;
    if (!$discount) {
      Session::put('coupon_error', "Invalid coupon code");
      return;
    }

    switch ($this->coupon->applies_to) {
      case 'product':
        $discount = new CalculateProductDiscount($this->coupon, $cart);
        break;
      default:
        $discount = new CalculateEntireOrderDiscount($this->coupon, $cart);
        break;
    }

    $discount->mapCart();
    if (isset($discount->error) && count($discount->error) > 0) {
      Session::put('coupon_error', $discount->error[0]);
    }

    return $discount->cart;
  }
}