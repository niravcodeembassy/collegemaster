<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Productvariant;
use App\Model\OrderItem;
use Illuminate\Support\Facades\DB;
use App\User as Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

  public function sizeChart(Request $request)
  {
    $startDate = $request->startDate ?? date('Y-m-01');
    $endDate = $request->endDate ?? date('Y-m-t');
    $today = $startDate == $endDate;

    $best_selling_size = OrderItem::select(
      DB::raw("json_extract(order_items.attribute, '$[0].size') as size"),
      'order_items.name',
      'order_items.id',
      'order_items.raw_data',
      'order_items.attribute',
      'order_items.qty',
    )
      ->selectRaw('SUM(order_items.qty) AS quantity_sold')
      ->when($today && isset($startDate), function ($q) use ($startDate) {
        return $q->whereDate('created_at', $startDate);
      })->when(!$today && isset($startDate), function ($q) use ($startDate, $endDate) {
        return  $q->whereBetween('created_at', [$startDate, $endDate]);
      })
      ->groupBy('size')
      ->orderByDesc('quantity_sold')
      ->get();

    $item = $best_selling_size->map(function ($item, $key) {
      $record = [
        'size' => str_replace(['"', "'"], "", $item->size),
        'quantity_sold' => str_replace('.00', '', $item->quantity_sold),
        'color' =>  '#' . dechex(rand(0x000000, 0xFFFFFF))
      ];
      return $record;
    });

    $json_data = array(
      "quantity_sold" => $item->pluck('quantity_sold'),
      "labels" => $item->pluck('size'),
      "color" => $item->pluck('color'),
    );

    return response()->json($json_data);
  }

  public function variantChart(Request $request)
  {
    $startDate = $request->startDate ?? date('Y-m-01');
    $endDate = $request->endDate ?? date('Y-m-t');
    $today = $startDate == $endDate;

    $best_selling_variant = OrderItem::select(
      DB::raw("json_extract(order_items.attribute, '$[0]') as attribute"),
      'order_items.name',
      'order_items.id',
      'order_items.raw_data',
      'order_items.attribute',
      'order_items.qty',
    )
      ->selectRaw('SUM(order_items.qty) AS quantity_sold')
      ->when($today && isset($startDate), function ($q) use ($startDate) {
        return $q->whereDate('created_at', $startDate);
      })->when(!$today && isset($startDate), function ($q) use ($startDate, $endDate) {
        return  $q->whereBetween('created_at', [$startDate, $endDate]);
      })
      ->groupBy('attribute')
      ->orderByDesc('quantity_sold')
      ->take(10)
      ->get();

    $item = $best_selling_variant->map(function ($item, $key) {
      $record = [
        'attribute' => $item->attribute,
        'quantity_sold' => str_replace('.00', '', $item->quantity_sold),
        'color' =>  '#' . dechex(rand(0x000000, 0xFFFFFF))
      ];
      return $record;
    });

    $json_data = array(
      "quantity_sold" => $item->pluck('quantity_sold'),
      "labels" => $item->pluck('attribute'),
      "color" => $item->pluck('color'),
    );

    return response()->json($json_data);
  }

  public function materialChart(Request $request)
  {
    $startDate = $request->startDate ?? date('Y-m-01');
    $endDate = $request->endDate ?? date('Y-m-t');
    $today = $startDate == $endDate;

    $opt = '$[0]."printing options"';

    $best_selling_material = OrderItem::select(
      DB::raw("json_extract(order_items.attribute, '$opt') as material"),
      'order_items.name',
      'order_items.id',
      'order_items.raw_data',
      'order_items.attribute',
      'order_items.qty',
    )
      ->selectRaw('SUM(order_items.qty) AS quantity_sold')
      ->when($today && isset($startDate), function ($q) use ($startDate) {
        return $q->whereDate('created_at', $startDate);
      })->when(!$today && isset($startDate), function ($q) use ($startDate, $endDate) {
        return  $q->whereBetween('created_at', [$startDate, $endDate]);
      })
      ->groupBy('material')
      ->orderByDesc('quantity_sold')
      ->get();

    $item = $best_selling_material->map(function ($item, $key) {
      $record = [
        'material' => str_replace(['"', "'"], "", $item->material),
        'quantity_sold' => str_replace('.00', '', $item->quantity_sold),
        'color' =>  '#' . dechex(rand(0x000000, 0xFFFFFF))
      ];
      return $record;
    });

    $json_data = array(
      "quantity_sold" => $item->pluck('quantity_sold'),
      "labels" => $item->pluck('material'),
      "color" => $item->pluck('color'),
    );

    return response()->json($json_data);
  }

  public function countryChart(Request $request)
  {
    // $country = $request->country;
    // $order = Order::whereJsonContains('address->shipping_address->country', $country);

    $opt = '$[0]."shipping_address"."country"';
    $country_wise_sales =  Order::select(
      DB::raw("json_extract(orders.address, '$opt') as country"),
      'orders.*'
    )->selectRaw('count(orders.user_id) AS count_total')
      ->groupBy('country')
      ->orderByDesc('count_total')
      ->get();

    $item = $country_wise_sales->map(function ($item, $key) {
      $record = [
        'country' => str_replace(['"', "'"], "", $item->country),
        'count' => $item->count_total,
        'color' =>  '#' . dechex(rand(0x000000, 0xFFFFFF))
      ];
      return $record;
    });

    $json_data = array(
      "count" => $item->pluck('count'),
      "labels" => $item->pluck('country'),
      "color" => $item->pluck('color'),
    );

    return response()->json($json_data);
  }
}