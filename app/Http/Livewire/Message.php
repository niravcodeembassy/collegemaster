<?php

namespace App\Http\Livewire;

use App\User;
use App\Model\Order;
use Aj\FileUploader\FileUploader;
use App\Model\Message as Chat;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Message extends Component
{
  use WithFileUploads;

  public $message = '';
  public $users;
  public $orders;
  public $clicked_user;
  public $messages;
  public $file;
  public $admin;
  public $search;
  public $show = true;
  public $hasAdmin = false;
  public $not_seen;

  public function render()
  {
    $hasAdmin = Auth::guard('admin')->check();

    $this->hasAdmin = $hasAdmin;
    $search = $this->search;

    $orders = Order::select('id', 'user_id', 'order_no')->with('user')
      ->when($search, function ($query, $search) {
        return $query->whereLike(['order_no', 'user.name'], "%{$search}%");
      })->get();


    // $this->users = $users;
    $this->orders = $orders;

    return view('livewire.message', [
      'admin' => $this->admin,
      'admin_user' => $hasAdmin,
      'orders' => $this->orders,
    ]);
  }

  public function mount()
  {
    $this->show = Auth::guard('admin')->check() ? false : true;
    $this->mountComponent();
    $this->emit('message_seen');
  }

  public function mountComponent()
  {
    $admin_user = User::where('is_admin', true)->first();
    if ($this->clicked_user) {
      $this->messages = Chat::where('order_id', $this->clicked_user->id)
        ->orderBy('id', 'Asc')
        ->get();

      $not_seen = Chat::where('order_id', $this->clicked_user->id)->where('user_id', $this->clicked_user->user_id);
      $not_seen->update(['is_seen' => true]);
      $this->emit('message_seen');
    } else {
      $this->messages = Chat::where('user_id', auth()->id())
        ->orWhere('receiver', auth()->id())
        ->orderBy('id', 'Asc')
        ->get();
    }
    $this->admin = $admin_user;
  }

  public function SendMessage()
  {
    $admin_user = User::where('is_admin', true)->first();
    $new_message = new Chat();
    $new_message->message = $this->message;
    $new_message->user_id = $admin_user->id;
    $new_message->order_id = $this->clicked_user->id;
    $user_id = $this->clicked_user->user_id;
    $new_message->receiver = $user_id;

    // Deal with the file if uploaded
    if ($this->file) {
      $file = $this->file->store('public/files');
      $path = url(Storage::url($file));
      $new_message->file = $path;
      $new_message->file_name = $this->file->getClientOriginalName();
    }
    $new_message->save();
    // Clear the message after it's sent
    $this->reset(['message']);
    $this->file = '';
    $this->emit('message_seen');

    $this->dispatchBrowserEvent('send-message');
  }

  public function getUser($order_id)
  {

    $this->clicked_user = Order::where('id', $order_id)->with('user')->first();
    $this->show = true;

    $this->mountComponent();
    $this->reset(['message']);
    $this->resetFile();

    $this->dispatchBrowserEvent('get-user', ['id' => $order_id]);
  }

  public function resetFile()
  {
    $this->reset('file');
  }
}