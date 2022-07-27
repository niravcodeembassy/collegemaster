<?php

namespace App\Http\Controllers\Front;

use Mail;
use Helper;
use App\Setting;
use App\Model\Order;
use App\Model\State;
use App\Model\Country;
use App\Model\CartImage;
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
        // dd($this->data);
        if ($request->isMethod('post')) {
            $this->request = $request;
            $this->user = $user;
            $this->address = $this->saveShippingAndBillingAddress();
            return redirect()->route('checkout', ['discount_code' => $request->get('discount_code')]);
        }

        return $this->view('frontend.checkout.index');
    }

    public function checkout(Request $request)
    {
        // dd($request->all());
        try {

            $this->cart = $this->shoppingcart->mapCart();

            if (Session::has('coupon_error')) {
                return back()->with('error', 'Coupon code is invalid');
            }

            if ($this->cart['cart']->count() == 0) {
                return redirect('/')->with('error', 'You have no product in your cart');
            }


            $this->request = $request;

            $this->user = Auth::user();

            $this->address = $this->saveShippingAndBillingAddress();

            $this->order = $this->saveOrder();

            $this->order_items = $this->saveOrderItem();

            if ($this->request->payment_method == "cash") {

                $this->clearCart();

                try {
                    $mail = Setting::where('name', 'mail')->first();
                    Mail::to($this->user->email)
                        ->bcc(explode(',', $mail->response->mail_bcc))
                        ->send(new OrderPlaced($this->order));
                } catch (\Exception $th) {
                }

                // return redirect()->route('payment.thankyou', encrypt($this->order->id))->with('order', $this->order);
                return Response::json(['status' => 'success','payment_method'=>'cash','order_id' => encrypt($this->order->id),'order'=>$this->order,'url'=>route('payment.thankyou', encrypt($this->order->id))],200);

            }

            if ($this->request->payment_method == "stripe") {
                // return redirect(URL::temporarySignedRoute('payment.razorpay', now()->addMinutes(10), ['id' => encrypt($this->order->id)]));
                return Response::json(['status' => 'success', 'order_id' => $this->order->id], 200);
            }

            return back();
        } catch (\Exception $e) {
            return Response::json(['status' => 'error'], 200);
        }
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
            $id = decrypt($id);
            $order = Order::findOrfail($id);
            $payment = new Razorpay($request);
            $payment->onCharge(['total' => $order->total]);
            return $payment->redirectTo()->with('order', $order);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404, 'Token expire');
        }
    }



    public function paymentSuccess(Request $request, $id)
    {


        $checkout_session = session('checkout_session');

        $order = Order::where('id', $id)->where('payment_status', 'pending')->first();
        $this->order = $order;
        $this->user = Auth::user();


        try {

            $id = encrypt($id);

            if (!$order) {
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

                $order->transaction_id = $checkout_session;
                $order->payment_at = date('Y-m-d H:i:s');
                $order->response = json_encode($request->all());
                $order->payment_status = 'completed';
                $order->invoice_number = $this->generateInvoiceNumber();
                $order->save();

                $this->clearCart();
                session()->forget(['checkout_session']);

                try {
                    Mail::to($this->user->email)->send(new OrderPlaced($order));
                } catch (\Exception $th) {
                }


                return redirect()->route('payment.thankyou', encrypt($order->id))->with('order', $this->order);
            }

            // else fail is default
            $stripe_data = $this->stripe_data($checkout_session);
            $paymentLog = new PaymentLog();
            $paymentLog->response = json_encode($stripe_data);
            $paymentLog->user_id = Auth::id();
            $paymentLog->type = "fail";
            $paymentLog->save();
            
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
            env('STRIPE_SECRET')
        );
        $stripe_data = $stripe->checkout->sessions->retrieve(
            $checkout_session,
            []
        );
    }
}
