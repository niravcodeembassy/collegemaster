<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Setting;
use Illuminate\Queue\SerializesModels;

class OrderDelivered extends Mailable
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
    $this->order->load('itemslists', 'user');
    $this->data['setting']  = Setting::findOrFail(1);
    $this->data['shipping'] =  $this->order->address;
    $this->data['order'] = $this->order;

    return $this->view('mail.delivered', $this->data);
  }
}