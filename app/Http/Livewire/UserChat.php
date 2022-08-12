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

class UserChat extends Component
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
  public $order_id;

  public function render()
  {
    $search = $this->search;
    $orders = Order::select('id', 'user_id', 'order_no')->where('user_id', auth()->id())->with('user')
      ->when($search, function ($query, $search) {
        return $query->whereLike(['order_no', 'user.name'], "%{$search}%");
      })->orderBy('id', 'DESC')->get();

    $this->orders = $orders;

    return view('livewire.user-chat', [
      'orders' => $this->orders,
      'admin' => $this->admin,
    ]);
  }

  public function mount()
  {
    $this->show = Auth::guard('web')->check() ? false : true;
    $this->mountComponent();
    $this->emit('message_seen');
  }

  public function mountComponent()
  {
    $admin_user = User::where('is_admin', true)->first();
    if ($this->clicked_user) {
      $this->messages = Chat::where('order_id', $this->clicked_user->id)
        ->orderBy('id', 'desc')
        ->get();
      $not_seen = Chat::where('order_id', $this->clicked_user->id)->where('user_id', $admin_user->id);
      $not_seen->update(['is_seen' => true]);
    }

    $this->admin = $admin_user;
  }

  public function SendMessage()
  {
    $admin_user = User::where('is_admin', true)->first();
    $new_message = new Chat();
    $new_message->message = $this->message;
    $new_message->user_id =  auth()->id();
    // $new_message->is_seen = 1;
    $new_message->order_id = $this->clicked_user->id;
    $new_message->receiver = $admin_user->id;

    // Deal with the file if uploaded
    if ($this->file) {
      $file = $this->file->store('public/files');
      $path = url(Storage::url($file));
      $new_message->file = $path;
      $new_message->file_name = $this->file->getClientOriginalName();
    }
    $new_message->save();
    $this->mountComponent();
    // Clear the message after it's sent
    $this->reset(['message']);
    $this->file = '';
    $this->emit('message_seen');

    $this->dispatchBrowserEvent('send-message');
  }

  public function getUser($order_id)
  {
    $this->order_id = $order_id;
    $this->clicked_user = Order::where('id', $order_id)->where('user_id', auth()->id())->with('user')->first();
    $this->show = true;
    $this->mountComponent();



    $this->reset(['message']);
    $this->resetFile();


    $this->emit('message_seen');

    $this->dispatchBrowserEvent('get-user', ['id' => $order_id]);
  }

  public function resetFile()
  {
    $this->reset('file');
  }
}