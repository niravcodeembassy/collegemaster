<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use App\Setting;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends Notification
{
  public $token;

  public static $createUrlCallback;

  public static $toMailCallback;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($token)
  {
    $this->token = $token;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    if (static::$toMailCallback) {
      return call_user_func(static::$toMailCallback, $notifiable, $this->token);
    }

    if (static::$createUrlCallback) {
      $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
    } else {
      $url = url(route('password.reset', [
        'token' => $this->token,
        'email' => $notifiable->getEmailForPasswordReset(),
      ], false));
    }

    $setting = Setting::first()->response;

    return (new MailMessage)
      ->subject(Lang::get('Reset Password Notification'))
      ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
      ->action(Lang::get('Reset Password'), $url)
      ->view('notification.reset', ['url' => $url, 'setting' => $setting, 'user' => $notifiable]);
  }

  public static function createUrlUsing($callback)
  {
    static::$createUrlCallback = $callback;
  }

  public static function toMailUsing($callback)
  {
    static::$toMailCallback = $callback;
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    return [
      //
    ];
  }
}