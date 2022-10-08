<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Productvariant;
use App\User as Customer;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('admin.auth:admin');
  }

  /**
   * Show the Admin dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {

    $this->data['customer'] = Customer::where('is_admin', false)->count();
    $this->data['totalOrders'] = Order::count();
    $this->data['todayOrder'] = Order::whereDate('created_at', date('Y-m-d'))->count();
    $this->data['revenue'] = Order::where('payment_status', 'completed')->sum('total');

    $this->data['orders'] = Order::with('user')->whereDate('created_at', date('Y-m-d'))
      ->where(function ($q) {
        return $q->where('payment_status', '!=', 'failed')->orWhere('payment_status', '!=', 'pending')->where('payment_type', '!=', 'razorpay');
      })
      ->orderBy('id', 'DESC')->get();


    return view('admin.home', $this->data);
  }
  public function saveVariantImages(Request $request)
  {
    $collectData = collect($request->data)->whereNotNull('productimage_id');
    $collectData->map(function ($item) {
      $productVariant = Productvariant::findOrfail($item['id']);
      $productVariant->productimage_id = $item['productimage_id'];
      $productVariant->save();
    });
    return response()->json([
      'message' => 'Image uploaded successfully'
    ]);
  }
}