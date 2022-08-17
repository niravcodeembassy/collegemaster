<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Model\PaymentSetting;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    $this->data['title'] = 'Payment';
    $this->data['mailsetup'] = PaymentSetting::find(1);
    return view('admin.settings.paymentsetting', $this->data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //

    $payment = PaymentSetting::updateOrCreate(
      ['id' => '1'],
      [

        'paypal_sandbox' => $request->paypal_sandbox ? 'live' : 'sandbox',
        'payumoney_sandbox' => $request->payumoney_sandbox ? 'live' : 'sandbox',
        'paypal' => $request->paypal ? 'Yes' : 'No',
        'paypal_client_id' => $request->paypal_client_id,
        'paypal_secret' => $request->paypal_secret,
        'payumoney' => $request->payumoney ? 'Yes' : 'No',
        'payu_key' => $request->payu_key,
        'payu_sult' => $request->payu_sult,

        'stripe' => $request->stripe ? 'Yes' : 'No',
        'stripe_key' => $request->stripe_key,
        'stripe_secrete' => $request->stripe_secrete,
        'cash' => $request->cash ? 'Yes' : 'No',
        'stripe_enable' => $request->stripe_enable ? 'Yes' : 'No',

        'razorpay' => $request->razorpay ? 'Yes' : 'No',
        'razorpay_key' => $request->razorpay_key,
        'razorpay_secrete' => $request->razorpay_secrete,
        'razorpay_enable' => $request->razorpay_enable ? 'Yes' : 'No',

        'twilio' => $request->twilio ? 'Yes' : 'No',
        'twilio_auth_sid' => $request->twilio_auth_sid,
        'twilio_auth_token' => $request->twilio_auth_token,
        'twilio_whatsapp_form' => $request->twilio_whatsapp_form,
        'twilio_enable' => $request->twilio_enable ? 'Yes' : 'No',

      ]
    );

    $env_update = $this->changeEnv([
      'STRIPE_KEY' => $request->stripe_key,
      'STRIPE_SECRET' => $request->stripe_secrete,
      'STRIPE_ENABLE' => $request->cash ? 'Yes' : 'No'
    ]);


    return redirect()->back()->with('success', 'Payment setting updated successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Model\Payment  $payment
   * @return \Illuminate\Http\Response
   */
  public function show(Payment $payment)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Model\Payment  $payment
   * @return \Illuminate\Http\Response
   */
  public function edit(Payment $payment)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Model\Payment  $payment
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Payment $payment)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Model\Payment  $payment
   * @return \Illuminate\Http\Response
   */
  public function destroy(Payment $payment)
  {
    //
  }

  protected function changeEnv($data = array())
  {
    if (count($data) > 0) {

      // Read .env-file
      $env = file_get_contents(base_path() . '/.env');

      // Split string on every " " and write into array
      $env = preg_split('/\s+/', $env);;

      // Loop through given data
      foreach ((array)$data as $key => $value) {
        // Loop through .env-data
        foreach ($env as $env_key => $env_value) {
          // Turn the value into an array and stop after the first split
          // So it's not possible to split e.g. the App-Key by accident
          $entry = explode("=", $env_value, 2);

          // Check, if new key fits the actual .env-key
          if ($entry[0] == $key) {
            // If yes, overwrite it with the new one
            $env[$env_key] = $key . "=" . $value;
          } else {
            // If not, keep the old one
            $env[$env_key] = $env_value;
          }
        }
      }

      // Turn the array back to an String
      $env = implode("\n\n", $env);

      // And overwrite the .env with the new data
      file_put_contents(base_path() . '/.env', $env);

      return true;
    } else {

      return false;
    }
  }
}