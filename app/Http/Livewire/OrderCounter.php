<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Model\Message;
use App\User;


class OrderCounter extends Component
{

  protected $listeners = ['message_seen' => 'render'];

  public $chat;
  public function render()
  {
    $user = auth()->user();
    $this->chat = Message::where('is_seen', false)->where('receiver', $user->id)->get() ?? null;
    return view('livewire.order-counter', ['chat' => $this->chat]);
  }

  public function mountComponent()
  {
    $user = auth()->user();
    $this->chat = Message::where('is_seen', false)->where('receiver', $user->id)->get() ?? null;
    return $this->chat;
  }
}