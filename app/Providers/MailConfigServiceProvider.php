<?php

namespace App\Providers;

use App\Setting;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        $mail = Setting::where('name','mail')->first();

        if (!is_null($mail) && $mail->response ) {
            $mail =  $mail->response;
            $config = array(
                'driver'     => 'smtp',
                'host'       => $mail->mail_host,
                'port'       => $mail->mail_port,
                'from'       => array(
                    'address' => $mail->mail_from_email,
                    'name' => $mail->mail_from_name
                ),
                'username'   => $mail->mail_username,
                'password'   => $mail->mail_password,
                'encryption' => $mail->mail_encryption
            );
            \Config::set('mail', $config);

        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
