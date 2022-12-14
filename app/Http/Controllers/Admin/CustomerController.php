<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\DatatableTrait;

class CustomerController extends Controller
{
  //
  use DatatableTrait;


  public function index()
  {
    $this->data['title'] = 'Customers';
    $this->data['total_user'] = User::where('is_admin', 0)->count();
    return view('admin.customer.index', $this->data);
  }

  public function dataListing(Request $request)
  {

    // Listing colomns to show
    $columns = array('name', 'email', 'phone', 'country_id', 'created_at', 'created_at', 'orders_count', 'wishlist_count', 'action');

    $totalData = User::where('is_admin', 0)->count(); // datata table count

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $search = $request->input('search.value');

    // dd($request);

    // DB::enableQueryLog();
    // genrate a query
    $customcollections = User::where('is_admin', 0)->withCount('orders', 'wishlist')->when($search, function ($query, $search) {
      return $query->where('name', 'LIKE', "%{$search}%")->orWhere('email', 'LIKE', "%{$search}%")->orWhere('phone', 'LIKE', "%{$search}%");
    });

    // dd($totalData);

    $totalFiltered = $customcollections->count();

    $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

    $data = [];

    // dd($customcollections);
    foreach ($customcollections as $key => $item) {
      $country = isset($item->country) ? '<span class = "badge badge-secondary p-2">' . $item->country->name . '</span>' : 'N/A';
      // dd(route('admin.brand.edit', $item->id));
      $row['name']   = $item->name;
      $row['email']  = $item->email;
      $row['phone']  = $item->phone;
      $row['country']  = $country;
      $row['created_at']  = date("d-m-Y", strtotime($item->created_at));
      $row['time']  = date("H:i:s", strtotime($item->created_at));
      $row['order_status'] =  '<i class="fa fa-truck f-18 px-2"></i>' . $item->orders_count;
      $row['wishlist'] =  '<i class="fa fa-heart f-18 px-2"></i>' . $item->wishlist_count;
      $row['status'] = $this->status($item->is_active, $item->id, route('admin.customer.status'));
      $row['action'] = $this->action([
        collect([
          'text' => 'View',
          'icon' => 'fa fa-eye',
          'id' => $item->id, 'action' => route('admin.customer.show', $item->id),
          'permission' => true
        ]),
      ]);

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

  public function show(Request $request, $id)
  {
    $this->data['title'] = 'Customer';
    $this->data['customer'] = User::with(['orders' => function ($q) {
      $q->orderBy('id', 'DESC');
    }], 'wishlist.variant')->findOrfail($id);
    // dd($this->data);
    // $this->data['order'] = User::with(['orders' => function ($q) {
    //   $q->orderBy('id', 'DESC');
    // }])->paginate('5');

    // $this->data['wishlist'] = User::with('wishlist')->paginate('5');

    return view('admin.customer.view', $this->data);
  }

  public function changeStatus(Request $request)
  {

    $statuscode = 400;
    $slider = User::findOrFail($request->id);
    $slider->is_active  =  $request->status == 'true' ? null :  date('Y-m-d H:i:s');

    if ($slider->save()) {
      $statuscode = 200;
    }
    $status = $request->status == 'true' ? 'active' : 'deactivate';
    $message = 'Customer ' . $status . ' successfully.';

    return response()->json([
      'success' => true,
      'message' => $message
    ], $statuscode);
  }

  public function getCustomerList(Request $request)
  {
    $search = $request->get('search');
    $id = $request->get('id');
    $data = User::where('email', 'like', '%' . $search . '%')->orWhere('name', 'like', '%' . $search . '%')->whereNull('is_active')->get();
    return response()->json($data->toArray());
  }
}
