<?php

namespace App\Http\Controllers\Front;

use Mail;
use Helper;  
use App\Setting;
use App\Model\Order;
use App\Model\State;
use App\Model\Country;
use App\Model\CartImage;
use App\Model\Productvariant;
use App\Model\OrderItem;
use PHPUnit\TextUI\Help;
use App\Gateway\Razorpay;
use App\Mail\OrderPlaced;
use App\Model\PaymentLog;
use Illuminate\Http\Request;
use App\Model\PaymentSetting;
use App\Model\UserShippingAddress;
use App\Repository\Contracts\Cart;
use Illuminate\Support\Facades\URL;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Stevebauman\Location\Facades\Location;
use Twilio\Rest\Client;

class CheckOutController extends Controller
{
  //

  protected $shoppingcart;

  public function __construct(Cart $cart)
  {
    $this->shoppingcart = $cart;
  }

  public function index(Request $request)
  {
    $carts = $this->shoppingcart->mapCart();

    $this->generateInvoiceNumber();
    if ($carts['cart']->count() == 0) {
      return redirect('/');
    }

    $user                          = Auth::user();
    $this->data['title']           = 'Check Out';
    $this->data['user']            = $user;
    $this->data['shippingAddress'] = UserShippingAddress::where('user_id', $user->id)->first();
    $this->data['carts']           = $carts;
    $this->data['payment_setting'] = PaymentSetting::first();

    if ($request->isMethod('post')) {
      $this->request = $request;
      $this->user = $user;
      $this->address = $this->saveShippingAndBillingAddress();
      return redirect()->route('checkout', ['discount_code' => $request->get('discount_code')]);
    }

    // $ip = request()->ip();
    // // $localIp = "77.111.246.21";
    // $currentLocation = Location::get($ip);
    // $country = $currentLocation->countryName;

    // if (strtolower($country) == "india") {
    //     return $this->view('frontend.checkout.rozarpay');
    // } else {
    return $this->view('frontend.checkout.index');
    // }
  }

  public function checkout(Request $request)
  {

    // try {

    $this->cart = $this->shoppingcart->mapCart();

    if (Session::has('coupon_error')) {
      return back()->with('error', 'Coupon code is invalid');
    }

    if ($this->cart['cart']->count() == 0) {
      return redirect('/')->with('error', 'You have no product in your cart');
    }

    if (Session::has('order_cart') ||  Session::has('checkout_request')) {
      session()->forget('order_cart');
      session()->forget('checkout_request');
    }


    session()->put('order_cart', $this->cart);

    $this->request = $request;
    session()->put('checkout_request', $this->request->all());

    $this->user = Auth::user();

    // $this->address = $this->saveShippingAndBillingAddress();
    // $this->order = $this->saveOrder();
    // $this->order_items = $this->saveOrderItem();

    $order_id = Order::orderBy('id', 'desc')->first();
    $order_id = $order_id->id + 1;
    if ($this->request->payment_method == "cash") {

      $this->address = $this->saveShippingAndBillingAddress();
      $this->order = $this->saveOrder();
      $this->order_items = $this->saveOrderItem();

      $this->clearCart();

      $body = 'Dear ' . ucwords($this->order->user->name) . ', We would like to inform you that you order has been placed, Order No.#' . $this->order->order_no . ' and Total Amount is $' . $this->order->total;

      try {
        $this->sendMessage($this->user->phone, $body);
      } catch (\Exception $e) {
        dump($e);
      }


      //whatsapp message
      try {
        $mail = Setting::where('name', 'mail')->first();

        Mail::to($this->user->email)
          ->bcc(explode(',', $mail->response->mail_bcc))
          ->send(new OrderPlaced($this->order));
      } catch (\Exception $th) {
      }



      // return redirect()->route('payment.thankyou', encrypt($this->order->id))->with('order', $this->order);
      return Response::json(['status' => 'success', 'payment_method' => 'cash', 'order_id' => encrypt($this->order->id), 'order' => $this->order, 'url' => route('payment.thankyou', encrypt($this->order->id))], 200);
    }

    if ($this->request->payment_method == "stripe") {
      // return redirect(URL::temporarySignedRoute('payment.razorpay', now()->addMinutes(10), ['id' => encrypt($this->order->id)]));
      return Response::json(['status' => 'success', 'order_id' => $order_id], 200);
    }

    return back();
    // } catch (\Exception $e) {
    //     return Response::json(['status' => 'error'], 200);
    // }
  }

  public function checkoutRozarpay(Request $request)
  {

    // try {

    $this->cart = $this->shoppingcart->mapCart();

    if (Session::has('coupon_error')) {
      return back()->with('error', 'Coupon code is invalid');
    }

    if ($this->cart['cart']->count() == 0) {
      return redirect('/')->with('error', 'You have no product in your cart');
    }

    if (Session::has('order_cart') ||  Session::has('checkout_request')) {
      session()->forget('order_cart');
      session()->forget('checkout_request');
    }


    session()->put('order_cart', $this->cart);

    $this->request = $request;
    session()->put('checkout_request', $this->request->all());

    $this->user = Auth::user();

    // $this->address = $this->saveShippingAndBillingAddress();
    // $this->order = $this->saveOrder();
    // $this->order_items = $this->saveOrderItem();

    $order_id = Order::orderBy('id', 'desc')->first();
    if ($order_id != null) {
      $order_id = $order_id->id + 1;
    } else {
      $order_id = 1;
    }
    if ($this->request->payment_method == "cash") {

      $this->address = $this->saveShippingAndBillingAddress();
      $this->order = $this->saveOrder();
      $this->order_items = $this->saveOrderItem();

      $this->clearCart();

      try {
        $mail = Setting::where('name', 'mail')->first();
        Mail::to($this->user->email)
          ->bcc(explode(',', $mail->response->mail_bcc))
          ->send(new OrderPlaced($this->order));
      } catch (\Exception $th) {
      }

      // return redirect()->route('payment.thankyou', encrypt($this->order->id))->with('order', $this->order);
      return Response::json(['status' => 'success', 'payment_method' => 'cash', 'order_id' => encrypt($this->order->id), 'order' => $this->order, 'url' => route('payment.thankyou', encrypt($this->order->id))], 200);
    }

    if ($this->request->payment_method == "razorpay") {
      return redirect(URL::temporarySignedRoute('payment.razorpay', now()->addMinutes(10), ['id' => encrypt($order_id)]));
    }

    return back();
    // } catch (\Exception $e) {
    //     return Response::json(['status' => 'error'], 200);
    // }
  }

  public function saveOrder()
  {
    $subtotal        = $this->cart['sub_total'];
    $shipping_charge = $this->cart['shipping_charge'];
    $total           = $this->cart['total'];
    $discount        = $this->cart['discount'];
    $tax        = $this->cart['tax'];

    $orderNumbers = Helper::orderNumber();

    $order = new Order();
    $order->user_id         = $this->user->id;
    $order->order_number    = $orderNumbers['order_number'];
    $order->order_no        = $orderNumbers['order_no'];
    $order->payment_type    = $this->request->payment_method;
    $order->payment_status  = 'pending';
    $order->address         = json_encode($this->address);
    $order->subtotal        = $subtotal;
    $order->shipping_charge = $shipping_charge;
    $order->total           = $total;
    $order->tax             = $tax;
    $order->response        = null;
    $order->invoice_number  = null;
    $order->transaction_id  = null;
    $order->discount        = $discount;
    $order->discount_code   = $this->request->discount_code;
    $order->save();

    return $order;
  }

  public function saveOrderItem()
  {

    $orderId = $this->order->id;
    $order_number = $this->order->order_number;
    $cart    = $this->cart['cart'];
    $orderItem = $cart->map(function ($value) use ($orderId, $order_number) {

      $value = (array) $value;
      $orderItem            = new OrderItem();
      $orderItem->order_id  = $orderId;
      $orderItem->name      = $value['name'];
      $orderItem->qty       = $value['qty'];
      $orderItem->price     = $value['final_price'];
      $orderItem->attribute = $value['attribute'];
      $orderItem->raw_data  = json_encode($value);
      $orderItem->save();

      $Productvariant = Productvariant::find($value['variant_id']);
      $inventory_quantity = $Productvariant->inventory_quantity - $value['qty'];
      $Productvariant->update(['inventory_quantity' => $inventory_quantity]);

      // $folderName = collect(json_decode($value['attribute'], true))->map(function ($item, $key) {
      //     return $key . '-' . $item;
      // })->join('-');

      $cartImages = CartImage::where('cart_id', $value['id'])->update([
        'item_id' => $orderItem->id,
        'user_id' =>  Auth::user()->id
      ]);

      // if ($cartImages->count()) {
      // $folderName = 'cart_image/' . 'order-' . $orderId . '/' . $value['name'] . '-' . $value['id'] . '-' . $folderName;
      // $folderName = str_replace(' ', '-', $folderName);
      // $root = 'cart_image/' . $value['id'] . '/';

      // if (Storage::exists($root)) {
      //     Storage::rename($root, $folderName . '/');
      // } else {
      //     Storage::makeDirectory($folderName . '/');
      // }

      // Update item image folder path
      // foreach ($cartImages as $cart_image_key => $image) {
      //     $image->item_id = $orderItem->id;
      //     $image->user_id = Auth::user()->id;
      //     $image->path = $folderName . '/' . $image->name;
      //     $image->save();
      // }
      // }

      return $orderItem;
    });

    return $orderItem;
  }

  public function saveShippingAndBillingAddress()
  {
    $state = State::find($this->request->state);
    $country = Country::find($this->request->country);

    $shippingAddress = UserShippingAddress::updateOrCreate([
      'user_id' => $this->user->id,
    ], [
      'first_name'  => $this->request->first_name,
      'last_name'   => $this->request->last_name,
      'email'       => $this->request->email,
      'mobile'      => $this->request->mobile,
      'address_one' => $this->request->address_one,
      'address_two' => $this->request->address_two,
      'country'     => $country->name,
      'state'       => $state->name,
      'city'        => $this->request->city,
      'postal_code' => $this->request->postal_code,
      'user_id'     => $this->user->id,
    ]);
    $address['shipping_address'] = $shippingAddress;
    // if billing address is different then set in session
    if ($this->request->different_billing_address == 'on') {

      $state = State::find($this->request->billing_state);
      $country = Country::find($this->request->billing_country);

      $this->request->session()->put(
        'different_billing_address',
        [
          'billing_first_name'  => $this->request->billing_first_name,
          'billing_last_name'   => $this->request->billing_last_name,
          'billing_email'       => $this->request->billing_email,
          'billing_mobile'      => $this->request->billing_mobile,
          'billing_address_one' => $this->request->billing_address_one,
          'billing_address_two' => $this->request->billing_address_two,
          'billing_country'     => $country->name,
          'billing_state'       => $state->name,
          'billing_city'        => $this->request->billing_city,
          'billing_postal_code' => $this->request->billing_postal_code,
        ]
      );
    } else {
      $this->request->session()->forget('different_billing_address');
    }

    $address['shipping_address'] = $shippingAddress;
    $address['billing_address']  = $this->request->session()->get('different_billing_address', []);

    return $address;
  }

  public function saveOrderViaStripe($cart, $address, $payment_method)
  {
    $subtotal        = $cart['sub_total'];
    $shipping_charge = $cart['shipping_charge'];
    $total           = $cart['total'];
    $discount        = $cart['discount'];
    $tax        = $cart['tax'];

    $orderNumbers = Helper::orderNumber();

    $order = new Order();
    $order->user_id         = Auth::user()->id;
    $order->order_number    = $orderNumbers['order_number'];
    $order->order_no        = $orderNumbers['order_no'];
    $order->payment_type    = $payment_method;
    $order->payment_status  = 'pending';
    $order->address         = json_encode($address);
    $order->subtotal        = $subtotal;
    $order->shipping_charge = $shipping_charge;
    $order->total           = $total;
    $order->tax             = $tax;
    $order->response        = null;
    $order->invoice_number  = null;
    $order->transaction_id  = null;
    $order->discount        = $discount;
    // $order->discount_code   = $this->request->discount_code;
    $order->discount_code   = "";

    $order->save();

    return $order;
  }

  public function saveOrderItemViaStripe($cart)
  {

    $orderId = $this->order->id;
    $order_number = $this->order->order_number;
    $cart    = $cart['cart'];

    $orderItem = $cart->map(function ($value) use ($orderId, $order_number) {

      $value = (array) $value;
      $orderItem            = new OrderItem();
      $orderItem->order_id  = $orderId;
      $orderItem->name      = $value['name'];
      $orderItem->qty       = $value['qty'];
      $orderItem->price     = $value['final_price'];
      $orderItem->attribute = $value['attribute'];
      $orderItem->raw_data  = json_encode($value);
      $orderItem->save();

      $Productvariant = Productvariant::find($value['variant_id']);
      $inventory_quantity = $Productvariant->inventory_quantity - $value['qty'];
      $Productvariant->update(['inventory_quantity' => $inventory_quantity]);

      // $folderName = collect(json_decode($value['attribute'], true))->map(function ($item, $key) {
      //     return $key . '-' . $item;
      // })->join('-');

      $cartImages = CartImage::where('cart_id', $value['id'])->update([
        'item_id' => $orderItem->id,
        'user_id' =>  Auth::user()->id
      ]);

      // if ($cartImages->count()) {
      // $folderName = 'cart_image/' . 'order-' . $orderId . '/' . $value['name'] . '-' . $value['id'] . '-' . $folderName;
      // $folderName = str_replace(' ', '-', $folderName);
      // $root = 'cart_image/' . $value['id'] . '/';

      // if (Storage::exists($root)) {
      //     Storage::rename($root, $folderName . '/');
      // } else {
      //     Storage::makeDirectory($folderName . '/');
      // }

      // Update item image folder path
      // foreach ($cartImages as $cart_image_key => $image) {
      //     $image->item_id = $orderItem->id;
      //     $image->user_id = Auth::user()->id;
      //     $image->path = $folderName . '/' . $image->name;
      //     $image->save();
      // }
      // }

      return $orderItem;
    });

    return $orderItem;
  }

  public function saveShippingAndBillingAddressViaStripe($orderaddress)
  {
    $state = State::find($orderaddress['state']);
    $country = Country::find($orderaddress['country']);

    $shippingAddress = UserShippingAddress::updateOrCreate([
      'user_id' => Auth::user()->id,
    ], [
      'first_name'  => $orderaddress['first_name'],
      'last_name'   => $orderaddress['last_name'],
      'email'       => $orderaddress['email'],
      'mobile'      => $orderaddress['mobile'],
      'address_one' => $orderaddress['address_one'],
      'address_two' => $orderaddress['address_two'],
      'country'     => $country->name,
      'state'       => $state->name,
      'city'        => $orderaddress['city'],
      'postal_code' => $orderaddress['postal_code'],
      'user_id'     => Auth::user()->id,
    ]);
    $address['shipping_address'] = $shippingAddress;
    // if billing address is different then set in session
    // if ($orderaddress['different_billing_address'] == 'on') {

    //     $state = State::find($orderaddress['billing_state']);
    //     $country = Country::find($orderaddress['billing_country']);

    //     session()->put(
    //         'different_billing_address',
    //         [
    //             'billing_first_name'  => $orderaddress['billing_first_name'],
    //             'billing_last_name'   => $orderaddress['billing_last_name'],
    //             'billing_email'       => $orderaddress['billing_email'],
    //             'billing_mobile'      => $orderaddress['billing_mobile'],
    //             'billing_address_one' => $orderaddress['billing_address_one'],
    //             'billing_address_two' => $orderaddress['billing_address_two'],
    //             'billing_country'     => $country->name,
    //             'billing_state'       => $state->name,
    //             'billing_city'        => $orderaddress['billing_city'],
    //             'billing_postal_code' => $orderaddress['billing_postal_code'],
    //         ]
    //     );
    // } else {
    //     session()->forget('different_billing_address');
    // }

    $address['shipping_address'] = $shippingAddress;
    $address['billing_address']  = session()->get('different_billing_address', []);

    return $address;
  }

  public function clearCart()
  {
    $this->cart =  $this->shoppingcart->mapCart();
    $cart    = $this->cart['cart'];
    $orderId = $this->order->id;

    $cart->map(function ($value) use ($orderId) {
      $value = (array) $value;
      $folderName = collect(json_decode($value['attribute'], true))->map(function ($item, $key) {
        return $key . '-' . $item;
      })->join('-');
      $cartImages = CartImage::where('cart_id', $value['id'])->get();
      if ($cartImages->count()) {
        $folderName = 'cart_image/' . 'order-' . $orderId . '/' . $value['name'] . '-' . $value['id'] . '-' . $folderName;
        $folderName = str_replace(' ', '-', $folderName);
        $root = 'cart_image/' . $value['id'] . '/';

        if (Storage::exists($root)) {
          Storage::rename($root, $folderName . '/');
        } else {
          Storage::makeDirectory($folderName . '/');
        }
        // Update item image folder path
        foreach ($cartImages as $cart_image_key => $image) {
          $image->path = $folderName . '/' . $image->name;
          $image->status   = 'order';
          $image->order_id = $orderId;
          $image->save();
        }
      }
      return $value;
    });

    Auth::user()->shoppingcart()->delete();

    request()->session()->forget('different_billing_address');
  }

  public function paymentRazorpay(Request $request, $id)
  {

    abort_if(!$request->hasValidSignature(), 404, "Token expire");

    try {
      $this->order = session('order_cart');

      $id = decrypt($id);
      $payment = new Razorpay($request);
      $payment->onCharge(['total' => $this->order['sub_total']]);
      return $payment->redirectTo()->with(['order' => $this->order, 'id' => $id]);
    } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
      abort(404, 'Token expire');
    }
  }

  public function paymentSuccess(Request $request, $id)
  {
    $this->address = $this->saveShippingAndBillingAddressViaStripe(session('checkout_request'));
    $this->order = $this->saveOrderViaStripe(session('order_cart'), $this->address, 'stripe');
    $this->order_items = $this->saveOrderItemViaStripe(session('order_cart'));


    $checkout_session = session('checkout_session');

    $this->user = Auth::user();


    try {

      $id = encrypt($id);

      if (!$this->order) {
        return redirect('/');
      }

      // if payment is success
      if ($checkout_session) {

        $stripe_data = $this->stripe_data($checkout_session);

        $paymentLog = new PaymentLog();
        $paymentLog->response = json_encode($stripe_data);
        $paymentLog->user_id = Auth::id();
        $paymentLog->type = "success";
        $paymentLog->save();

        $this->order->transaction_id = $checkout_session;
        $this->order->payment_at = date('Y-m-d H:i:s');
        $this->order->response = json_encode($request->all());
        $this->order->payment_status = 'completed';
        $this->order->invoice_number = $this->generateInvoiceNumber();
        $this->order->save();

        $this->clearCart();
        session()->forget(['checkout_session']);


        $body = 'Dear ' . ucwords($this->order->user->name) . ', We would like to inform you that you order has been placed, Order No.#' . $this->order->order_no . ' and Total Amount is $' . $this->order->total;

        try {
          $this->sendMessage($this->user->phone, $body);
        } catch (\Exception $e) {
          dump($e);
        }

        //whatsapp message
        try {
          Mail::to($this->user->email)->send(new OrderPlaced($this->order));
        } catch (\Exception $th) {
        }


        return redirect()->route('payment.thankyou', encrypt($this->order->id))->with('order', $this->order);
      }

      // else fail is default
      $stripe_data = $this->stripe_data($checkout_session);
      $paymentLog = new PaymentLog();
      $paymentLog->response = json_encode($stripe_data);
      $paymentLog->user_id = Auth::id();
      $paymentLog->type = "fail";
      $paymentLog->save();

      $this->order->payment_at = date('Y-m-d H:i:s');
      $this->order->response = json_encode($request->all());
      $this->order->payment_status = 'failed';
      $this->order->save();



      $this->clearCart();

      return redirect()->route('checkout')->with('error', 'Payment is failed');
    } catch (Illuminate\Contracts\Encryption\DecryptException $e) {

      return redirect()->route('checkout')->with('error', 'Payment is failed');
    }
  }

  public function rozarpayPaymentSuccess(Request $request, $id)
  {

    $payment = new Razorpay($request);
    $payment->addLog('pending');

    $this->address = $this->saveShippingAndBillingAddressViaStripe(session('checkout_request'));
    $this->order = $this->saveOrderViaStripe(session('order_cart'), $this->address, session('checkout_request')['payment_method']);
    $this->order_items = $this->saveOrderItemViaStripe(session('order_cart'));


    $order = $this->order;

    $this->user = Auth::user();


    try {

      $id = encrypt($id);

      if (!$order) {
        return redirect('/');
      }

      $hasSuccess = $payment->onSuccess($request);
      // if payment is success
      if ($hasSuccess) {

        $payment->addLog('success');
        $order->transaction_id = $hasSuccess['rzp_orderid'];
        $order->payment_at = date('Y-m-d H:i:s');
        $order->response = json_encode($request->all());
        $order->payment_status = 'completed';
        $order->invoice_number = $this->generateInvoiceNumber();
        $order->save();

        $this->clearCart();

        try {
          Mail::to($this->user->email)->send(new OrderPlaced($order));
        } catch (\Exception $th) {
        }


        return redirect()->route('payment.thankyou', encrypt($order->id))->with('order', $this->order);
      }

      // else fail is default
      $payment->addLog('fail');
      $order->payment_at = date('Y-m-d H:i:s');
      $order->response = json_encode($request->all());
      $order->payment_status = 'failed';
      $order->save();

      $this->clearCart();

      return redirect()->route('checkout')->with('error', 'Payment is failed');
    } catch (Illuminate\Contracts\Encryption\DecryptException $e) {

      return redirect()->route('checkout')->with('error', 'Payment is failed');
    }
  }

  public function thankYou(Request $request, $id)
  {
    $order = Order::findOrfail(decrypt($id));
    $name = Auth::user()->name;

    return redirect()->route('orders.list')->with('success', "Hi $name , Your Order Successfully Placed & Your Order No. is $order->order_number");
    // return view('frontend.payment.thankyou', ['order' => $order]);
  }


  public function generateInvoiceNumber()
  {

    $mainSetting = Setting::findOrfail(1);
    $setting = $mainSetting->response;
    $setting->last_number = $setting->last_number + 1;
    $mainSetting->response = json_encode($setting);
    $mainSetting->save();


    $inv = $setting->last_number;

    $inv = $my_val = str_pad($inv, 7, '0', STR_PAD_LEFT);

    $prefix = "";
    $prefix = $setting->invoice_prefix;

    $for = "";
    if ($setting->forment == 1) {
      $for = $prefix . $inv;
    } else if ($setting->forment == 2) {
      $for = $prefix . date('Y') . '/' . $inv;
    } else if ($setting->forment == 3) {
      $for = $prefix . $inv . '-' . date('y');
    } else if ($setting->forment == 4) {
      $for = $prefix . $inv . '/' . date('m') . '/' . date('y');
    }
    return $for;
  }

  public function country(Request $request)
  {
    $country_code = $request->country_code;
    if ($country_code) {
      $state_data = State::whereCountryId($country_code)->get();
      $length = count($state_data);

      $nav = array();
      $nav['stateData'] = $state_data;
      $nav['length'] = $length;

      return response()->json($nav);
    }
  }


  public function stripe_data($checkout_session)
  {
    $stripe = new \Stripe\StripeClient(
      config('app.stripe.stripe_secret')
    );
    $stripe_data = $stripe->checkout->sessions->retrieve(
      $checkout_session,
      []
    );
  }

  public function sendMessage($mobile, $body)
  {
    $sid =  config("app.twilio.twilio_auth_sid");
    $token = config('app.twilio.twilio_auth_token');
    $wa = config("app.twilio.twilio_whatsapp_form");

    $client = new Client($sid, $token);

    return   $client->messages->create(
      // the number you'd like to send the message to
      "whatsapp:$mobile",
      [
        // A Twilio phone number you purchased at twilio.com/console
        'from' => "whatsapp:$wa",
        // the body of the text message you'd like to send
        'body' => $body,
        // 'mediaurl' => 'https://demo.twilio.com/owl.png'
      ]
    );
  }
}