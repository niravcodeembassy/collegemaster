<?php

namespace App\Http\Controllers\Front;

use Stripe\Charge;
use Stripe\Stripe;
use App\Model\Order;
use App\Model\OrderItem;
use Stripe\StripeClient;
use App\Model\PaymentLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class StripeController extends Controller
{
  // private $test_public_key = env('STRIPE_KEY');
  // private $test_secret_key =  env('STRIPE_SECRET');

  public function index()
  {
    redirect()->back();
  }

  public function stripe(Request $request)
  {

    Stripe::setApiKey(config('app.stripe.stripe_secret'));
    header('Content-Type: application/json');

    $url = request()->segment(1) == null ? url('/') : url(app()->getlocale());
    $order_item = session('order_cart');
    $product_name = $order_item['cart'][0]['name'];
    $order_id = Order::orderBy('id', 'desc')->first();

    $checkout_session = \Stripe\Checkout\Session::create([
      'payment_method_types' => ['card'],
      'customer_email' => Auth::user()->email,
      'line_items' => [[
        'price_data' => [
          'currency' => 'usd',
          'unit_amount' => round($order_item['total'] * 100),
          'product_data' => [
            'name' => $product_name,
          ],
        ],
        'quantity' => 1,
      ]],
      'mode' => 'payment',
      'success_url' => $url . '/payment/stripe/success/' . $order_id->id,
      'cancel_url' => $url . '/transaction-fail',
    ]);


    session(['checkout_session' => $checkout_session->id]);

    $stripe_data = $this->stripe_data($checkout_session->id);
    $paymentLog = new PaymentLog();
    $paymentLog->response = json_encode($stripe_data);
    $paymentLog->user_id = Auth::id();
    $paymentLog->type = "pending";
    $paymentLog->save();

    return Response::json(array('id' => $checkout_session->id), 200);
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
}