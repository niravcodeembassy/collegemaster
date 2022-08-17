<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Setting;
use App\Model\PaymentSetting;

class ApiConfigServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {

    $payment = PaymentSetting::first();

    $setting = Setting::where('name', 'general_settings')->first();

    if (!is_null($setting) && $setting->response) {
      $setting = $setting->response;

      if (isset($setting->twilio_auth_token)) {
        # code...
        $twilio = array(
          'twilio_auth_sid' => $setting->twilio_auth_sid,
          'twilio_auth_token'  => $setting->twilio_auth_token,
          'twilio_whatsapp_form'  => $setting->twilio_whatsapp_form
        );
        \Config::set('app.twilio', $twilio);
      }

      if (isset($payment)) {
        $stripe = array(
          'stripe_key' => $payment->stripe_key,
          'stripe_secret'  => $payment->stripe_secrete,
          'stripe_enable'  => $payment->twilio_whatsapp_form
        );
        \Config::set('app.stripe', $stripe);
      }
    }
  }
}