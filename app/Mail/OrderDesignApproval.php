<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Setting;
use Illuminate\Queue\SerializesModels;

class OrderDesignApproval extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($order, $image)
  {
    $this->order  = $order;
    $this->image  = $image;
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
    $this->data['image'] = $this->image;

    if ($this->order->approval_image == null) {
      return $this->view('mail.approval', $this->data);
    }

    return $this->view('mail.approval', $this->data)
      ->attachFromStorage($this->order->approval_image);
  }
}