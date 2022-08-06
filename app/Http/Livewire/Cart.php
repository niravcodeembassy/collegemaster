<?php

namespace App\Http\Livewire;

use App\Model\Discount;
use Livewire\Component;

class Cart extends Component
{
  public $carts = [];
  public $code = "";

  // private $shoppingCart;

  // public function __construct(Cart $shoppingCart) {
  //     $this->cart = $shoppingCart;
  // }

  public function mount($carts)
  {
    $this->carts = $carts;
  }

  public function render()
  {
    return view('livewire.cart');
  }

  // public function applycode()
  // {
  //     $couponCode = Discount::first();
  //     $this->shoppingCart->get()
  //     dd($this->code);
  // }

}