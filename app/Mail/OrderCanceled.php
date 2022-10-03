<?php

namespace App\Mail;

use App\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCanceled extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order  = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->order->load('itemslists' ,'user');
        $this->data['setting']  = Setting::findOrfail(1);
        $this->data['shipping'] =  $this->order->address;
        $this->data['order'] = $this->order;

        return $this->view('mail.canceled' , $this->data);
    }


}