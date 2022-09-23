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
          'twilio_whatsapp_form'  => $setting->twilio_whatsapp_form,
          'twilio_sms_form' => $setting->twilio_sms_form
        );
        \Config::set('app.twilio', $twilio);
      }

      if (isset($payment)) {
        $stripe = array(
          'stripe_key' => $payment->stripe_key,
          'stripe_secret'  => $payment->stripe_secrete,
          'stripe_enable'  => $payment->stripe_enable
        );
        \Config::set('app.stripe', $stripe);
      }

      if (isset($setting->recaptcha_site_key)) {
        # code...
        $config_captcha = array(
          'secret' => $setting->recaptcha_secret_key,
          'sitekey' => $setting->recaptcha_site_key,
          'options' => [
            'timeout' => 30,
          ],
        );
        \Config::set('captcha', $config_captcha);
      }
    }
  }
}