<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Model\Message;
use App\User;
use App\Model\Order;

class ChatCounter extends Component
{
  protected $listeners = ['message_seen' => 'render'];

  public $chat;
  public function render()
  {
    $user = User::where('is_admin', true)->first();
    $this->chat = Message::where('is_seen', false)->where('user_id', '!=', $user->id)->get() ?? null;
    return view('livewire.chat-counter', ['chat' => $this->chat]);
  }

  public function mountComponent()
  {
    $user = User::where('is_admin', true)->first();
    $this->chat = Message::where('is_seen', false)->where('user_id', '!=', $user->id)->get() ?? null;
    return $this->chat;
  }
}