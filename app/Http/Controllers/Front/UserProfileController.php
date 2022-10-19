<?php

namespace App\Http\Controllers\Front;

use Hash;
use Session;
use App\User;
use App\Model\Order;
use App\Model\Setting;
use App\Model\OrderChat;
use Illuminate\Http\Request;
use App\Setting as AppSetting;
use App\Model\OrderChatAttachment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $this->data['title'] = 'Profile';
    $this->data['user'] = \Auth::user();
    $this->data['customer'] = User::with(['orders' => function ($q) {
      $q->orderBy('id', 'DESC');
    }])->findOrfail(\Auth::id());
    return view('frontend.dashboard.profile', $this->data);
  }
  
  public function orderList()
  {
    $this->data['title'] = 'Order';
    $this->data['user'] = \Auth::user();
    $this->data['customer'] = User::with(['orders' => function ($q) {
      $q->orderBy('id', 'DESC');
    }])->findOrfail(\Auth::id());
    return view('frontend.dashboard.orderlist', $this->data);
  }

  public function ordersShow(Request $request, $id)
  {
    $order = Order::with('itemslists')->where('user_id', \Auth::id())->findOrfail($id);
    $orderMsg = OrderChat::where('order_id', $id)->get();
    $html = view('frontend.dashboard.orders_details', ['order' => $order, 'title' => 'order', 'orderMsg' => $orderMsg]);
    return $html;
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
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $userid = Auth::guard()->user()->id;

    $data = $request->validate([
      'first_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,' . $userid,
      'phone' => 'required',
      'address1' => 'required|string',
      'country' => 'required|string',
      'state' => 'nullable',
      'city' => 'required|string',
      'postcode' => 'required|string',
    ]);

    $mobile = $request->country_code . "" . $request->phone;
    User::where('id', $userid)->update([
      'name' => $request->first_name . ' ' . $request->last_name,
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' => $request->email,
      'phone' => $mobile,
      'country_code' => $request->country_code,
      'address1' => $request->address1,
      'address2' => $request->address2,
      'country_id' => $request->country,
      'state_id' => $request->state,
      'city_id' => $request->city,
      'postal_code' => $request->postcode,
    ]);

    return redirect()->back()->with('success', 'Profile update successfully');
  }


  public function changeProfilImage(Request $request, $id)
  {
    $status = 400;

    $user = User::findorfail($id);

    $oldImage = $user->profile_image;

    $file_data = $request->input('image');

    $file_name = 'image_' . time() . '.png'; //generating unique file name;


    $url = 'profile/' . $file_name; //generating unique file name;


    @list($type, $file_data) = explode(';', $file_data);

    @list(, $file_data) = explode(',', $file_data);

    if ($file_data != "") { // storing image in storage/app/public Folder
      $isUploda = \Storage::disk('public')->put($url, base64_decode($file_data));
      if ($isUploda) {
        \Storage::disk('public')->delete($oldImage);
      }
      $user->profile_image = $url;
      $user->save();

      $status = 200;
    }
    // return redirect()->route('profile.index');
    return response()->json([
      'success' => true,
      'image_url' => $user->profile_src,
    ], $status);
  }

  public function changePasswordGet(Request $request)
  {
    $this->data['title'] = 'Change Password';
    $this->data['user'] = \Auth::user();
    return view('frontend.dashboard.changePassword', $this->data);
  }

  public function changePassword(Request $request)
  {
    $this->validate($request, [
      'old_password' => 'required|min:6',
      'new_password' => 'required|min:6',
      'comfirm_password' => 'required|same:new_password'
    ]);

    $current_password = $request->old_password;
    $password = $request->new_password;

    $user = auth()->user();

    if (!Hash::check($current_password, $user->password)) {
      return redirect()->back();
    }
    $user->password = Hash::make($password);
    if ($user->save()) {
      return redirect()->back()->with('success', 'Password change successfully');
    } else {
      return redirect()->back();
    }
  }

  public function checkOldPassword(Request $request)
  {

    $current_password = $request->old_password;

    if ($request->id) {
      $user = User::findOrfail($request->id);
    }

    if (!Hash::check($current_password, $user->password)) {
      return 'false';
    }
    return 'true';
  }

  public function checkEmail(Request $request)
  {

    $email = User::when($request->id, function ($query, $id) {

      $query->where('id', '!=', $id);
    })->where('email', '=', $request->get('email'))->first();

    if (is_null($email)) {

      return 'true';
    }
    return 'false';
  }

  public function orderMsg(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'attachment.*' => 'nullable|mimes:jpg,png'
    ]);

    if ($validator->fails()) {
      return Response::json(array('status' => 'error', 'message' => $validator->getMessageBag()->toArray()));
    }

    $params = array();
    $params['customer_id'] = Auth::user()->id;
    $params['order_id'] = $request->id;
    $params['msg'] = $request->message;
    $params['type'] = 'customer';
    $params['is_seed'] = 0;

    $OrderChat = OrderChat::create($params);

    if ($request->attachment) {
      if (count($request->attachment) > 0) {
        $params = array();
        $params['customer_id'] = Auth::user()->id;
        $params['order_id'] = $request->id;
        $params['msg'] = $request->message;
        $params['type'] = 'custImg';
        $params['is_seed'] = 0;
        $OrderChat = OrderChat::create($params);

        foreach ($request->attachment as $key => $val) {
          $uploadfile =  $this->uploadFile($val);
          $OrderChatAttachment = new OrderChatAttachment();
          $OrderChatAttachment->chat_id = $OrderChat->id;
          $OrderChatAttachment->attachment = $uploadfile;

          $OrderChatAttachment->save();
        }
      }
    }

    $orderMsg = OrderChat::where('order_id', $request->id)->get();
    $html = (string)View::make('frontend.chat.order-chats', compact('orderMsg'));
    return Response::json(array('status' => 'success', 'message' => 'Message Successfully send.', 'html' => $html), 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  public function orderInvoice(Request $request, $id)
  {
    $order = Order::with('items')->where('id', $id)->first();
    $setting = AppSetting::generalSettings()->first()->response;

    $address = json_decode($order->address);
    $billing_address = $address->shipping_address;
    if ($address->billing_address) {
      $billing_address = (object) [
        "first_name" => $address->billing_address->billing_first_name,
        "last_name" => $address->billing_address->billing_last_name,
        "email" =>  $address->billing_address->billing_email,
        "mobile" => $address->billing_address->billing_mobile,
        "address_one" => $address->billing_address->billing_address_one,
        "address_two" => $address->billing_address->billing_address_two,
        "country" => $address->billing_address->billing_country,
        "state" => $address->billing_address->billing_state,
        "city" => $address->billing_address->billing_city,
        "postal_code" => $address->billing_address->billing_postal_code
      ];
    }

    $shippingState = $address->shipping_address->state;
    $billingState = $setting->state;
    $type = 'gst';
    if (strtolower(trim($billingState)) != strtolower(trim($shippingState))) {
      $type = 'igst';
    }
    $this->data['order'] = $order;
    $this->data['setting'] = $setting;
    $this->data['shipping_address'] = $address->shipping_address;
    $this->data['belling_address'] = $billing_address;
    $this->data['title'] = 'Invoice';
    // dd($this);
    return $this->view('frontend.invoice_' . $type);
  }

  public function uploadFile($value)
  {
    $file = $value;
    $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
    $fileName = str_replace(' ', '_', $fileName);
    $uploadfile =  $file->storeAs('chat_img', $fileName);
    return $uploadfile;
  }
}
