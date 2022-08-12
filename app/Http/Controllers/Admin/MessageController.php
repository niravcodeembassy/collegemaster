<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Message;
use App\User;
use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    
    $orders = Order::select('id', 'user_id', 'order_number')->with('user')->get();

    $this->data['title'] = 'Chat';
    $this->data['orders'] = $orders;
    $this->data['messages'] = $messages ?? null;
    return $this->view('admin.chat.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Model\Message  $message
   * @return \Illuminate\Http\Response
   */
  public function show(Message $message)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Model\Message  $message
   * @return \Illuminate\Http\Response
   */
  public function edit(Message $message)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Model\Message  $message
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Message $message)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Model\Message  $message
   * @return \Illuminate\Http\Response
   */
  public function destroy(Message $message)
  {
    //
  }
}