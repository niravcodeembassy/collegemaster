<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Productvariant;
use App\Model\OrderItem;
use Illuminate\Support\Facades\DB;
use App\User as Customer;
use Carbon\Carbon;
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
  public function index(Request $request)
  {


    if ($request->ajax()) {

      $startDate = $request->startDate;
      $endDate = $request->endDate;
      $today = $startDate == $endDate;

      $customer =  Customer::where('is_admin', false)->when($today && isset($startDate), function ($q) use ($startDate) {
        return $q->whereDate('created_at', $startDate);
      })->when(!$today && isset($startDate), function ($q) use ($startDate, $endDate) {
        return  $q->whereBetween('created_at', [$startDate, $endDate]);
      })->count();

      $orders = Order::when($today && isset($startDate), function ($q) use ($startDate) {
        return $q->whereDate('created_at', $startDate);
      })->when(!$today && isset($startDate), function ($q) use ($startDate, $endDate) {
        return  $q->whereBetween('created_at', [$startDate, $endDate]);
      })->get();

      $total_order = $orders->count();
      $revenue = $orders->sum('total');

      $json_data = array(
        "orders" => $total_order,
        "customers" => $customer,
        "revenue" => '$ ' . round($revenue, 2),
      );

      return response()->json($json_data);
    }

    $this->data['customer'] = Customer::where('is_admin', false)->count();
    $this->data['totalOrders'] = Order::count();
    $this->data['todayOrder'] = Order::whereDate('created_at', date('Y-m-d'))->count();
    $this->data['revenue'] = Order::sum('total');

    $this->data['orders'] = Order::with('user')->whereDate('created_at', date('Y-m-d'))
      ->orderBy('id', 'DESC')->get();

    // $this->data['revenue'] = Order::where('order_status', 'delivered')->sum('total');
    // $this->data['orders'] = Order::with('user')->whereDate('created_at', date('Y-m-d'))
    //   ->where(function ($q) {
    //     return $q->where('payment_status', '!=', 'failed')->orWhere('payment_status', '!=', 'pending')->where('payment_type', '!=', 'razorpay');
    //   })
    //   ->orderBy('id', 'DESC')->get();


    $opt = '$[0]."shipping_address"."country"';
    $countryWiseSale = Order::select(
      DB::raw("json_extract(orders.address, '$opt') as country"),
      'orders.*'
    )->selectRaw('COUNT(orders.id) AS total_order,COUNT(DISTINCT orders.user_id) as total_users, COUNT(orders.id)*100/(SELECT COUNT(*) FROM orders) as percentage')
      ->groupBy(['country'])
      ->get();

    $six_month_sale = $this->lastSixMonthSales();
    $six_month_revenue = $this->lastSixMonthRevenue();
    $day_wise_sale = $this->dayWiseSales();
    $day_wise_revenue = $this->dayWiseRevenue();
    $monthWiseSaleTable = $this->monthWiseSale();
    $dayWiseSaleTable = $this->dayWiseSaleTable();

    $this->data['sixMonthSale'] =  $six_month_sale;
    $this->data['sixMonthRevenue'] =  $six_month_revenue;
    $this->data['dayWiseSale'] =  $day_wise_sale;
    $this->data['dayWiseRevenue'] =  $day_wise_revenue;
    $this->data['monthWiseSaleTable'] =  $monthWiseSaleTable;
    $this->data['dayWiseSaleTable'] =  $dayWiseSaleTable;

    $this->data['countryWiseSale'] =  $countryWiseSale;
    return view('admin.home', $this->data);
  }

  public function dayWiseSaleTable()
  {
    $dayWiseSale = Order::select(
      DB::raw('year(created_at) as year'),
      DB::raw('month(created_at) as month'),
      DB::raw('day(created_at) as day'),
      DB::raw('sum(total) as price'),
      DB::raw('COUNT(orders.id) AS total_order'),
    )
      ->where(DB::raw('date(created_at)'), '>=', Carbon::now()->subDays(12))
      ->groupBy('year')
      ->groupBy('month')
      ->groupBy('day')
      ->get()
      ->toArray();
    $dayWiseSale = collect($dayWiseSale);

    $period = now()->subDays(11)->dayssUntil(now());
    $data = [];
    foreach ($period as $date) {
      if ($dayWiseSale->where('year', $date->year)->where('month', $date->month)->where('day', $date->day)->count() > 0) {
        $day_record = $dayWiseSale->where('year', $date->year)->where('month', $date->month)->where('day', $date->day)->first();
        $data[] = [
          "label" => $date->day . '-' . $date->shortMonthName . '-' . $date->year,
          "order" => $day_record['total_order'],
          "amount" => $day_record['price'],
        ];
      } else {
        $data[] = [
          "label" => $date->day . '-' . $date->shortMonthName . '-' . $date->year,
          "order" => 0,
          "amount" => 0.00,
        ];
      }
    }
    $data = array_reverse($data);
    return $data;
  }

  public function monthWiseSale()
  {
    $monthWiseSale = Order::select(
      DB::raw('year(created_at) as year'),
      DB::raw('month(created_at) as month'),
      DB::raw('sum(total) as price'),
      DB::raw('COUNT(orders.id) AS total_order'),
    )
      ->where(DB::raw('date(created_at)'), '>=', Carbon::now()->startOfMonth()->subMonth(12))
      ->groupBy('year')
      ->groupBy('month')
      ->get()
      ->toArray();
    $monthWiseSale = collect($monthWiseSale);

    $period = now()->subMonths(11)->monthsUntil(now());
    $data = [];
    foreach ($period as $date) {
      if ($monthWiseSale->where('year', $date->year)->where('month', $date->month)->count() > 0) {
        $month_record = $monthWiseSale->where('year', $date->year)->where('month', $date->month)->first();
        $data[] = [
          "label" => $date->shortMonthName . '-' . $date->year,
          "order" => $month_record['total_order'],
          "amount" => $month_record['price'],
        ];
      } else {
        $data[] = [
          "label" => $date->shortMonthName . '-' . $date->year,
          "order" => 0,
          "amount" => 0.00,
        ];
      }
    }
    $data = array_reverse($data);
    return $data;
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
    $startDate = $request->startDate;
    $endDate = $request->endDate;
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
        'color' => $this->adjustBrightness('#' . dechex(rand(0x000000, 0xFFFFFF)), 0.4)
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
    $startDate = $request->startDate;
    $endDate = $request->endDate;
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
      ->take(5)
      ->get();

    $item = $best_selling_variant->map(function ($item, $key) {
      $record = [
        'attribute' => $item->attribute,
        'quantity_sold' => str_replace('.00', '', $item->quantity_sold),
        'color' => $this->adjustBrightness('#' . dechex(rand(0x000000, 0xFFFFFF)), 0.4)
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
    $startDate = $request->startDate;
    $endDate = $request->endDate;
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
        'color' => $this->adjustBrightness('#' . dechex(rand(0x000000, 0xFFFFFF)), 0.4)
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

    $startDate = $request->startDate;
    $endDate = $request->endDate;
    $today = $startDate == $endDate;

    // $country = $request->country;
    // $order = Order::whereJsonContains('address->shipping_address->country', $country);

    $opt = '$[0]."shipping_address"."country"';

    $country_wise_revenue = Order::select(
      DB::raw("json_extract(orders.address, '$opt') as country"),
      'orders.*'
    )->selectRaw('SUM(orders.total) AS total')
      // ->where('orders.order_status', 'delivered')
      ->groupBy('country')
      ->when($today && isset($startDate), function ($q) use ($startDate) {
        return $q->whereDate('orders.created_at', $startDate);
      })->when(!$today && isset($startDate), function ($q) use ($startDate, $endDate) {
        return  $q->whereBetween('orders.created_at', [$startDate, $endDate]);
      })
      ->orderByDesc('total')
      ->get();

    $item = $country_wise_revenue->map(function ($item, $key) {
      $record = [
        'country' => str_replace(['"', "'"], "", $item->country),
        'count' => $item->total,
        'color' => $this->adjustBrightness('#' . dechex(rand(0x000000, 0xFFFFFF)), 0.4)
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

  public function lastSixMonthSales()
  {
    $last_six_month_sales = Order::select('orders.*', DB::raw('MONTH(created_at) month'))
      ->where("created_at", ">", Carbon::now()->subMonths(6))
      ->selectRaw('count(orders.id) AS month_sales')
      ->groupBy('month')
      ->get();

    $sales = $last_six_month_sales->map(function ($item) {
      return
        [
          'month' => date("F", mktime(0, 0, 0, $item->month, 10)),
          'month_sales' => $item->month_sales,
          'color' => $this->adjustBrightness('#' . dechex(rand(0x000000, 0xFFFFFF)), 0.4)
        ];
    });

    $data = array(
      "month" => $sales->pluck('month'),
      "month_sales" => $sales->pluck('month_sales'),
      "color" => $sales->pluck('color'),
    );
    return json_encode($data);
  }

  public function lastSixMonthRevenue()
  {
    $last_six_month_revenue = Order::select('orders.*', DB::raw('MONTH(created_at) month'))
      ->where("created_at", ">", Carbon::now()->subMonths(6))
      // ->where('orders.order_status', 'delivered')
      ->selectRaw('sum(orders.total) AS month_revenue')
      ->groupBy('month')
      ->get();

    $revenue = $last_six_month_revenue->map(function ($item) {
      return
        [
          'month' => date("F", mktime(0, 0, 0, $item->month, 10)),
          'month_revenue' => $item->month_revenue,
          'color' => $this->adjustBrightness('#' . dechex(rand(0x000000, 0xFFFFFF)), 0.4)
        ];
    });

    $data = array(
      "month" => $revenue->pluck('month'),
      "month_revenue" => $revenue->pluck('month_revenue'),
      "color" => $revenue->pluck('color'),
    );
    return json_encode($data);
  }

  public function dayWiseSales()
  {
    $day_wise_sales = Order::select('orders.*', DB::raw('DATE(created_at) date'))
      ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
      ->selectRaw('count(orders.id) AS day_sales')
      ->groupBy('date')
      ->get();

    $weekMap = collect([
      0 => 'Mon',
      1 => 'Tue',
      2 => 'Wed',
      3 => 'Thu',
      4 => 'Fri',
      5 => 'Sat',
      6 => 'Sun',
    ]);

    $sales = $day_wise_sales->map(function ($item, $index) use ($weekMap) {
      return
        [
          'day' => date("D", strtotime($item->date)),
          'day_sales' => $item->day_sales,
          'color' => $this->adjustBrightness('#' . dechex(rand(0x000000, 0xFFFFFF)), 0.4),
        ];
    });

    $collect = $weekMap->map(function ($item, $index) use ($sales) {
      $d = $sales->where('day', $item)->first();
      return
        [
          'day' => $item,
          'day_sales' => isset($d) ? $d['day_sales'] : 0,
          'color' => $this->adjustBrightness('#' . dechex(rand(0x000000, 0xFFFFFF)), 0.4)
        ];
    });

    $data = array(
      "day" => $collect->pluck('day'),
      "day_sales" => $collect->pluck('day_sales'),
      "color" => $collect->pluck('color'),
    );
    return json_encode($data);
  }

  public function dayWiseRevenue()
  {
    $day_wise_revenue = Order::select('orders.*', DB::raw('DATE(created_at) date'))
      ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
      // ->where('orders.order_status', 'delivered')
      ->selectRaw('sum(orders.total) AS day_revenue')
      ->groupBy('date')
      ->get();

    $revenue = $day_wise_revenue->map(function ($item) {
      return
        [
          'day' => date("D", strtotime($item->date)),
          'day_revenue' => $item->day_revenue,
          'color' => $this->adjustBrightness('#' . dechex(rand(0x000000, 0xFFFFFF)), 0.4)
        ];
    });


    $weekMap = collect([
      0 => 'Mon',
      1 => 'Tue',
      2 => 'Wed',
      3 => 'Thu',
      4 => 'Fri',
      5 => 'Sat',
      6 => 'Sun',
    ]);

    $collect = $weekMap->map(function ($item, $index) use ($revenue) {
      $d = $revenue->where('day', $item)->first();
      return
        [
          'day' => $item,
          'day_revenue' => isset($d) ? $d['day_revenue'] : 0,
          'color' => $this->adjustBrightness('#' . dechex(rand(0x000000, 0xFFFFFF)), 0.4)
        ];
    });

    $data = array(
      "day" => $collect->pluck('day'),
      "day_revenue" => $collect->pluck('day_revenue'),
      "color" => $collect->pluck('color'),
    );
    return json_encode($data);
  }

  function adjustBrightness($hexCode, $adjustPercent)
  {
    $hexCode = ltrim($hexCode, '#');

    if (strlen($hexCode) == 3) {
      $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
    }

    $hexCode = array_map('hexdec', str_split($hexCode, 2));

    foreach ($hexCode as &$color) {
      $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
      $adjustAmount = ceil($adjustableLimit * $adjustPercent);

      $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
    }

    return '#' . implode($hexCode);
  }
}
