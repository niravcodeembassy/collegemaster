<?php

namespace App\Http\Controllers\Admin;

use Helper;
use ZipArchive;
use App\Setting;
use Carbon\Carbon;
use App\Model\Order;
use App\Model\CartImage;
use App\Model\OrderChat;
use App\Mail\OrderCanceled;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\OrderDispatched;
use App\Traits\DatatableTrait;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use App\Model\OrderChatAttachment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf as Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Twilio\Rest\Client;

class OrderController extends Controller
{
  use DatatableTrait;

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $this->data['title'] =  'Order';
    $this->data['type'] = $request->get('type', 'online');
    return view('admin.order.index', $this->data);
  }

  public function dataListing(Request $request, $delivery_status = 'all')
  {

    // Listing colomns to show
    $columns = array(
      0 => 'id',
      1 => 'created_at',
      2 => 'user_id',
      3 => 'id',
      4 => 'payment_status',
      5 => 'order_status',
      6 => 'total',
      7 => 'option',
    );

    $totalData = Order::count(); // datata table count
    // dd($totalData);
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $search = $request->input('search.value');
    // DB::enableQueryLog();
    // genrate a query
    $orders = Order::with('user', 'itemslists:id,order_id,qty')
      ->when($search, function ($query, $search) {
        return $query->whereLike(['order_number', 'user.name'], "%{$search}%");
      })
      ->when($request->to_date, function ($query) use ($request) {
        return $query->where('created_at', '>=', date('Y-m-d', strtotime($request->to_date)));
      })
      ->when($request->from_date, function ($query) use ($request) {
        return $query->where('created_at', '<=', date('Y-m-d', strtotime($request->from_date)));
      })
      ->when($request->get('type') == 'cod', function ($query) use ($request) {
        return $query->where('payment_type', 'cash');
      })
      ->when($request->get('type') == 'online', function ($query) use ($request) {
        return $query->whereIn('payment_type', ['stripe', 'razorpay'])->where('payment_status', '!=', 'failed')->where('payment_status', '!=', 'pending');
      })
      ->when($request->get('type') == 'pending', function ($query) use ($request) {
        return $query->whereIn('payment_type', ['stripe', 'razorpay'])->where(function ($q) {
          $q->where('payment_status', 'failed')->orWhere('payment_status', 'pending');
        });
      })
      ->orderBy($order, $dir);

    $totalFiltered = $orders->count();

    $data = [];

    $orders = $orders->offset($start)->limit($limit)->get();

    // dd(\DB::getQueryLog());
    // dd($orders);
    foreach ($orders as $key => $item) {

      $action_edit = [];
      // collect([
      //     'id' => $item->id,
      //     'text' => 'Order Status',
      //     'action' => route('admin.order.edit', $item->id),
      //     'target' => '#edit_hsncode_form_model',
      //     'class' => 'call-modal',
      //     'icon' => 'fa fa-edit',
      //     'permission' => true,
      // ])

      $row['orderId'] = $item->id;
      $row['orderNumber'] = '<a class="btn-link text-primary" target="_blank" href="' . route('admin.order.show', $item->id) . '">' . $item->order_number . '</a>';
      //$row['orderName'] = $item->name;
      $row['created_at'] = date("d-m-Y", strtotime($item->created_at));

      $username = ($item->user->name != '') ? ($item->user->name) : $item->user->email;
      $name = '<a class="btn-link" target="_blank" href="' . route('admin.customer.show', $item->user_id) . '">' . ucfirst($username) . '</a>';
      $row['customerName'] = $name;

      $row['qty'] = $item->itemslists->sum('qty');
      // dump($item->order_status);

      if ($item->order_status == "cancelled") {
        $row['deliveryStatus'] = '<span class = "badge badge-pill my-badge badge-danger m-auto mb-1">' . ucfirst(str_replace('_', ' ', $item->order_status)) . '</span>';
      } else if ($item->order_status == 'order_placed') {
        $row['deliveryStatus'] = '<span class="badge badge-pill my-badge badge-primary m-auto mb-1">Ordered</span>';
      } else if ($item->order_status == 'dispatched') {
        $row['deliveryStatus'] = '<span class="badge badge-pill my-badge badge-info m-auto mb-1">Shipped</span>';
      } else if ($item->order_status == 'delivered') {
        $row['deliveryStatus'] = '<span class="badge badge-pill my-badge badge-success m-auto mb-1">Delivered</span>';
      } else if ($item->order_status == 'customer_approval') {
        $row['deliveryStatus'] = '<span class="badge badge-pill my-badge badge-warning bg-maroon m-auto mb-1">Customer Approval </span>';
      } else if ($item->order_status == 'work_in_progress') {
        $row['deliveryStatus'] = '<span class="badge badge-pill my-badge badge-default bg-gray m-auto mb-1">Work In Progress </span>';
      }

      $statusPopup = '<a class="call-model call-modal"
            data-target-modal="#edit_hsncode_form_model"
            data-id="' . $item->id . '"
            data-url="' . route('admin.order.edit', $item->id) . '"
            href="' . route('admin.order.edit', $item->id) . '"
            data-toggle="modal"
            data-target="#edit_hsncode_form_model">
                ' . $row['deliveryStatus'] . '
            </a>';

      $row['deliveryStatus'] = $statusPopup;

      //$row['paymentSatatus'] = ucfirst($item->payment_status);
      if ($item->total) {
        $item->total = $item->total ?? 0;
      }

      $row['totalPrice'] = '<span class="text-right d-block" >' . Helper::showPrice($item->total, $item->currency) . '</span>';

      if ($item->payment_status == 'completed') {
        $row['paymentSatatus'] = '<span class = "badge badge-pill my-badge badge-success m-auto mb-1">Completed</span>';
      } else if ($item->payment_status == 'pending') {
        $row['paymentSatatus'] = '<span class = "badge badge-pill my-badge badge-primary m-auto mb-1">Pending</span>';

        if (($item->payment_type == "cash")) {
          $row['paymentSatatus'] = '<span class = "badge badge-pill my-badge badge-success m-auto mb-1">COD</span>';
        }
      } else {
        $row['paymentSatatus'] = '<span class = "badge badge-pill my-badge badge-danger badge-primary m-auto mb-1">Failed</span>';
      }

      // dd($request->has('d_from_date'));
      if ($item->order_status == 'cancelled') {
        unset($action_edit);
        $action_edit = [];
      }

      // if ($item->order_status == 'dispatched' ||  $item->order_status == 'delivered') {
      //     // $action_edit[] = collect([
      //     //     'text' => 'Invoice',
      //     //     'id' => $item->id,
      //     //     'action' => route('admin.invoice.show', $item->id),
      //     //     'action_name' => 'Genrate Invoice',
      //     //     'icon' => 'fa fa-list',
      //     //     'attrs' => [
      //     //         'target' => '_blank'
      //     //     ],
      //     //     'permission' => true,
      //     // ]);
      // }


      // collect([
      //     'text' => 'View',
      //     'id' => $item->id,
      //     'icon' => 'fa fa-eye',
      //     'action' => route('admin.order.show', $item->id),
      //     'permission' => false,
      // ]),
      $action = array_merge(
        [

          (\Storage::exists('cart_image/order-' . $item->id)  ? collect([
            'text' => 'Download Photos',
            'id' => $item->id,
            'icon' => 'fa fa-download',
            'action' => route('admin.order.download', $item->id),
            'permission' => true,
          ]) : null),
          (\Storage::exists('cart_image/order-' . $item->id) ? collect([
            'text' => 'Remove Photos',
            'id' => $item->id,
            'icon' => 'fa fa-trash',
            'action' => route('admin.order.removepic', $item->id),
            'permission' => true,
          ]) : null),
          collect([
            'text' => 'Invoice',
            'id' => $item->id,
            'icon' => 'fa fa fa-book-open',
            'action' => route('admin.order.inv', $item->id),
            'permission' => true,
          ]),
        ],

        $action_edit
      );

      $row['action'] = $this->action($action);

      $data[] = $row;
    }

    $json_data = array(
      "draw" => intval($request->input('draw')),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data" => $data,
    );

    return response()->json($json_data);
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
   * @param  \App\Model\order  $order
   * @return \Illuminate\Http\Response
   */
  public function show(Order $order)
  {
    //
    $this->data['title'] = "Order";
    $this->data['order'] = $order->load('items');
    return $this->view('admin.order.details');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Model\order  $order
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request, $id)
  {
    $order = Order::findOrfail($id);
    $view = view('admin.order.get-order', ['order' => $order])->render();
    return response()->json(['html' => $view], 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Model\order  $order
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //

    $order = Order::findorfail($id);
    $user = $order->user;

    $order->order_status = $request->delivery_status;

    if ($request->delivery_status == 'dispatched') {

      $datedata = explode('-', $request->shipping_date);
      $strDate = $request->shipping_date;
      $order->shipping_date = date('Y-m-d', strtotime($strDate));
      $order->order_status = 'dispatched';

      $date = date('F j, Y', strtotime($order->shipping_date));

      $body = 'Dear ' . ucwords($order->user->name) . ', We would like to inform you that you order has been Dispatched in ' . $date;

      $this->sendMessage($user->phone, $body);


      try {
        Mail::to($user->email)->send(new OrderDispatched($order));
      } catch (\Exception $th) {
      }
    }

    if ($request->delivery_status == 'delivered') {

      $datedata = explode('-', $request->deleverd_date);
      $strDate = $datedata[1] . '-' . $datedata[0] . '-' . $datedata[2];

      $strDate = $request->deleverd_date;
      $order->deleverd_date = date('Y-m-d H:i:s', strtotime($strDate));
      $order->deleverd_to_name = $request->user_name;
      $order->order_status = 'delivered';

      $date = date('F j, Y', strtotime($order->deleverd_date));
      $body = 'Dear ' . ucwords($order->user->name) . ', We would like to inform you that you order has been Delivered in ' . $date;
      $this->sendMessage($user->phone, $body);
    }

    if ($request->delivery_status == 'cancelled') {

      $order->cancel_at = date('Y-m-d');
      $order->cancel_reason = $request->cancel_remarks;
      $order->order_status = 'cancelled';
      $order->cancel_by_id = \Auth::guard('admin')->id();

      try {
        Mail::to($user->email)->send(new OrderCanceled($order));
      } catch (\Exception $th) {
      }
    }

    $order->payment_status = $request->payment_status;

    // if ($request->payment_status == 'completed') {
    //   $body = 'Dear ' . ucwords($order->user->name) . ', We would like to inform you that you Payment has been completed';
    //   $this->sendMessage($user->phone, $body);
    // }

    $order->save();


    return redirect()->back()->with('success', "Order updated successfully.");
  }

  /**
   * Remove the specified resource from storage.w
   *
   * @param  \App\Model\order  $order
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
  }


  public function changeStatus(Request $request)
  {
  }

  public function checkorderCode(Request $request)
  {
  }

  public function orderImageDownload(Request $request, $id)
  {

    $order = Order::where('id', $id)->first();

    Storage::makeDirectory('zips');

    $path = 'storage/cart_image/order-' . $order->id;

    // Get real path for our folder
    $rootPath = public_path($path . '/');
    $newRootPath = "http://collagemaster.com/" . $path;
    // Initialize archive object
    $zip = new ZipArchive();

    $zip->open('storage/zips/' . $order->order_number . '.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
    // Create recursive directory iterator
    /** @var SplFileInfo[] $files */
    // dd($newRootPath);
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($files as $name => $file) {
      // Skip directories (they would be added automatically)
      if (!$file->isDir()) {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();

        $relativePath = substr($filePath, strlen($rootPath) + 4);
        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
      }
    }

    $zip->close();


    return response()->download(public_path('storage/zips/' . $order->order_number . '.zip'));
  }

  public function orderRemovePic(Request $request, $id)
  {
    $order = Order::where('id', $id)->first();
    \Storage::delete(['zips/' . $order->order_number . '.zip']);
    \Storage::deleteDirectory('cart_image/' . $order->order_number);
    return back()->with('success', 'Attachment remove successfully');
  }


  public function orderInvoice(Request $request, $id)
  {
    $data =  $this->invoiceData($id);
    $this->data['order'] = $data['order'];
    $this->data['setting'] = $data['setting'];
    $this->data['shipping_address'] = $data['shipping_address'];
    $this->data['belling_address'] =  $data['belling_address'];
    $this->data['title'] = 'Invoice';

    return $this->view('admin.order.invoice_' . $data['type']);
  }

  public function orderMsg(Request $request)
  {
    $params = array();
    $params['customer_id'] = \Auth::guard('admin')->id();
    $params['order_id'] = $request->id;
    $params['msg'] = $request->message;
    $params['type'] = "admin";
    $params['is_seen'] = 0;

    $OrderChat = OrderChat::create($params);

    if ($request->attachment != null) {
      if (count($request->attachment) > 0) {

        $params = array();
        $params['customer_id'] = \Auth::guard('admin')->id();
        $params['order_id'] = $request->id;
        $params['msg'] = $request->message;
        $params['type'] = "adminImg";
        $params['is_seen'] = 0;

        $OrderChat = OrderChat::create($params);

        foreach ($request->attachment as $key => $val) {
          if ($request->hasFile('attachment')) {
            $uploadfile =  $this->uploadFile($val);
            $OrderChatAttachment = new OrderChatAttachment();
            $OrderChatAttachment->chat_id = $OrderChat->id;
            $OrderChatAttachment->attachment = $uploadfile;

            $OrderChatAttachment->save();
          }
        }
      }
    }

    $chat = OrderChat::where('order_id', $request->id)->get();

    $html =  (string)View::make('admin.chat.order-chats', compact('chat'));
    if ($OrderChat) {
      return Response::json(array('status' => 'success', 'message' => 'Message Successfully send.', 'html' => $html), 200);
    } else {
      return Response::json(array('status' => 'success', 'message' => 'Message can`t send.'), 200);
    }
  }

  public function orderMsgAttachment(Request $request)
  {
    if ($request->id) {
      $attachment = array();
      $img = OrderChatAttachment::where('chat_id', $request->id)->get();

      $attachment = array();
      $img = OrderChatAttachment::where('id', $request->id)->first();
      $path = public_path('storage/' . $img->attachment);

      return response()->download($path);

      foreach ($img as $key => $value) {
        if ($value->attachment != null) {
          $attach_img = explode('/', $value->attachment);
          array_push($attachment, $attach_img[1]);
        }
      }

      $id = $request->id;

      $zip = new ZipArchive;

      $fileName = 'order-' . $id . '-attachment.zip';

      if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
        $files = File::files(public_path('storage/chat_img'));

        foreach ($files as $key => $value) {
          if (in_array(basename($value), $attachment)) {
            $relativeNameInZipFile = basename($value);
            $zip->addFile($value, $relativeNameInZipFile);
          }
        }

        $zip->close();
      }

      return response()->download(public_path($fileName));
    }
  }

  public function uploadFile($value)
  {
    $file = $value;
    $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
    $fileName = str_replace(' ', '_', $fileName);
    $uploadfile =  $file->storeAs('chat_img', $fileName);
    return $uploadfile;
  }

  public function orderPdf($id)
  {
    $data =  $this->invoiceData($id);

    $html = view('admin.order.test', [
      'order' => $data['order'],
      'setting' => $data['setting'],
      'shipping_address' => $data['shipping_address'],
      'billing_address' => $data['belling_address'],
      'type' => $data['type'],
      'title' => 'invoice'
    ])->render();

    $dompdf = new Pdf();
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    return $dompdf->stream();
  }

  public function invoiceData($id)
  {
    $order = Order::with('items')->where('id', $id)->first();
    $setting = Setting::generalSettings()->first()->response;

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

    $invoice_arr = [
      'order' => $order,
      'setting' => $setting,
      'shipping_address' => $address->shipping_address,
      'belling_address' => $billing_address,
      'type' => $type
    ];
    return $invoice_arr;
  }

  public function sendMessage($mobile, $body)
  {
    // $sid = env('TWILIO_AUTH_SID');
    // $token = env('TWILIO_AUTH_TOKEN');
    // $wa = env('TWILIO_WHATSAPP_FROM');

    $sid =  config("app.twilio.twilio_auth_sid");
    $token = config('app.twilio.twilio_auth_token');
    $wa = config("app.twilio.twilio_whatsapp_form");

    $client = new Client($sid, $token);

    $client->messages->create(
      // the number you'd like to send the message to
      "whatsapp:$mobile",
      [
        // A Twilio phone number you purchased at twilio.com/console
        'from' => "whatsapp:$wa",
        // the body of the text message you'd like to send
        'body' => $body,
        // 'mediaurl' => 'https://demo.twilio.com/owl.png'
      ]
    );
  }
}