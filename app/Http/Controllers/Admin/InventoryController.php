<?php

namespace App\Http\Controllers\Admin;

use App\Inventory;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Productvariant;
use App\Model\Option;
use App\Model\OptionValue;
use App\Model\ProductOptionValue;
use App\Model\ProductVariantCombination;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Traits\DatatableTrait;

class InventoryController extends Controller
{
  use DatatableTrait;

  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    $this->data['title'] =  'Inventory';
    return view('admin.inventory.index', $this->data);
  }



  public function dataListing(Request $request)
  {

    // Listing colomns to show
    $columns = array(
      0 => 'products.id',
      1 => 'products.name',
      2 => 'category_name',
      3 => 'productvariants.inventory_quantity',
    );

    $totalData = Product::count(); // datata table count

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $search = $request->input('search.value');

    // dd($request);

    // DB::enableQueryLog();
    // genrate a query

    $customcollections = Product::select(
      'products.id',
      'productvariants.type',
      'productvariants.id as variant_id',
      'productvariants.inventory_quantity',
      'products.tax',
      'productvariants.taxable_price',
      'productvariants.offer_price',
      'productvariants.mrp_price',
      'products.name as title',
      'products.category_id',
      'products.slug',
      'product_images.image_name',
      'categories.name as category_name',
      'image_url',
      'products.is_active'
    )
      ->join('productvariants', function ($join) {
        return $join->on('products.id', '=', 'productvariants.product_id')
          ->on('productvariants.type', '=', 'products.product_type');
      })
      ->leftJoin('categories', function ($join) {
        return $join->on('products.category_id', '=', 'categories.id');
      })
      ->leftJoin('product_images', function ($join) {
        return $join->on('productvariants.productimage_id', '=', 'product_images.id');
      })
      ->when($request->category, function ($query) use ($request) {
        $query->where('products.category_id',  $request->category);
        return $query;
      });

    // dd($totalData);

    $totalData = $customcollections->count();

    $customcollections = $customcollections->when($search, function ($query, $search) {
      return $query->where('products.name', 'LIKE', "%{$search}%");
    });

    $totalFiltered = $customcollections->count();

    $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();
    $data = [];

    foreach ($customcollections as $key => $item) {
      $varinatOption  = ProductVariantCombination::select('id', 'option_value_id')->with('optionvalue:id,name')->where('variant_id', $item->variant_id)->get()->pluck('optionvalue.name')->join(' | ');


      $inventory_quantity =  $item->inventory_quantity ?? 'N/A';

      $row['chckbox'] = $this->checkBox($item->variant_id);


      // if($item->type == 'single' && $item->image_name == null ) {
      //     dump($item->defaultimage);
      //     $imagename = $item->defaultimage->image_name;
      // }else{
      //     $imagename =  $item->image_name;
      // }

      $row['id'] = $item->id;

      $row['title'] = '
                <div class="feeds-widget p-0">
                    <div class="feed-item border-0 p-0">
                        <a href="' . route('admin.product.edit', $item->id) . '" class="d-flex align-items-start">
                            <div class="feeds-left d-inline-block " style="width:20%;">
                                ' . $this->image('product_image', $item->image_url, '80%') . '
                            </div>
                            <div class="feeds-body">
                                <h6 class="font-weight-normal f-18 text-primary">' . $item->title . '</h6>
                                <small>
                                    <strong><span> ' .  $varinatOption . ' </span></strong>
                                </small>

                            </div>
                        </a>
                    </div>
                </div>
            ';

      $row['category'] = '<span class="badge badge-pill badge-secondary mb-1">' . $item->category_name . '</span>';

      $row['status'] = $inventory_quantity;

      $row['option'] = view('component.inventorybtn', ['item' => (object) $item])->render();

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


  public function changeQty(Request $request)
  {
    $id = $request->id;

    $message = ['status' => 400, 'message' => __('product.error')];

    if ($request->qty || ($request->qty == 0)) {

      $variant = Productvariant::findOrFail($id);

      if ($request->type == 'add') {
        $variant->inventory_quantity = $variant->inventory_quantity + $request->qty;
      } else {
        $variant->inventory_quantity = $request->qty;
      }

      $variant->save();

      $message['message'] = __('product.update_inventory');

      $message['status'] = 200;

      return response()->json($message, $message['status']);
    }

    return response()->json($message, $message['status']);
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
    $this->data['title'] =  'Inventory';
    if (isset($request->ids)) {
      $productvariant = Productvariant::with('product:id,name', 'variantCombination.option:id,name', 'variantCombination.optionvalue:id,name')
        ->whereIn('id', $request->ids)
        ->get();

      $this->data['productvariant'] = $productvariant;
      return view('admin.inventory.edit', $this->data);
    }

    $product_variants = $request->input('product_variants', []);
    $arr = [];
    foreach ($product_variants as $key => $item) {
      $option = Option::where('id', $item['option_name'])->select('id', 'name')->first();
      $optionValue = OptionValue::where('id', $item['variants_name'])->select('id', 'name')->first();
      $arr[] = [
        'key' => $option->name,
        'value' => $optionValue->name
      ];
    }

    $option = collect($arr);
    $jsonData = $option->chunk(2);

    $product_combination = $jsonData->map(function ($item) {
      return $item->pluck('key')->combine($item->pluck('value'));
    });
    $this->data['combination'] = $product_combination->first();

    return view('admin.inventory.price', $this->data);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Inventory  $inventory
   * @return \Illuminate\Http\Response
   */
  public function show(Inventory $inventory)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Inventory  $inventory
   * @return \Illuminate\Http\Response
   */
  // public function edit(Inventory $inventory)
  public function edit(Request $request, $id)
  {
    $this->data['title'] =  'Inventory';
    return view('admin.inventory.edit', $this->data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Inventory  $inventory
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Inventory $inventory)
  {
    //
  }

  public function updateBulk(Request $request)
  {
    $option_variants = json_decode($request->option, true);
    $mrp_price = $request->mrp_price;
    $offer_price = $request->offer_price;
    $inventory_quantity = $request->inventory_quantity;

    $price  = $offer_price ?? $mrp_price;

    $query =  ProductVariantCombination::join('productvariants', 'productvariants.id', '=', 'product_variant_combinations.variant_id')
      ->join('products', 'products.id', '=', 'productvariants.product_id')
      ->select('product_variant_combinations.*', 'productvariants.*', 'products.id', 'products.tax', 'products.tax_type')
      ->groupBy('productvariants.id')
      ->whereJsonContains('product_variant_combinations.variants', $option_variants);

    foreach ($query->cursor() as $key => $item) {
      $amount = Helper::calcTaxAmount($price, $item->tax ?? 0, $item->tax_type ?? false);
      Productvariant::where('id', $item->variant_id)->update([
        'mrp_price' => $mrp_price,
        'offer_price' => $offer_price,
        'taxable_price' => $amount,
        'inventory_quantity' => $inventory_quantity
      ]);
    }

    return redirect()->route('admin.inventory.index')->with('success', __('product.update_inventory'));
  }

  public function updateAll(Request $request)
  {

    $ids = $request->variant_id;


    $variants = Productvariant::with('product')->orderBy('id', 'DESC')->findOrfail($ids);

    foreach ($ids as $key => $value) {

      $product = $variants->where('id', $value)->first();

      $price  = $request->input('offer_price.' . $key) ?? $request->input('mrp_price.' . $key);
      $amount = Helper::calcTaxAmount($price, $product->product->tax ?? 0, $product->product->tax_type ?? false);


      $product->mrp_price = $request->input('mrp_price.' . $key);
      $product->offer_price = $request->input('offer_price.' . $key);
      $product->taxable_price = $amount;

      $product->inventory_quantity = $request->input('inventory_quantity.' . $key);

      $product->save();
    }

    return redirect()->route('admin.inventory.index')->with('success', __('product.update_inventory'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Inventory  $inventory
   * @return \Illuminate\Http\Response
   */
  public function destroy(Inventory $inventory)
  {
    //

  }
}