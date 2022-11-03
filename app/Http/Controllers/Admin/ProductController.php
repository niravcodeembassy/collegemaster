<?php

namespace App\Http\Controllers\Admin;

use App\Model\Product;
use App\Model\ShoppingCart;
use App\Model\Productvariant;
use DB;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\HsCode;
use App\Traits\DatatableTrait;
use Exception;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  use DatatableTrait;

  public function __construct(Request $request)
  {
    $this->request = $request;
  }


  public function dataListing(Request $request)
  {

    // Listing colomns to show
    $columns = array(
      'products.id',
      'category_name',
      'subcategory_name',
    );

    $totalData = Product::count(); // datata table count


    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $search = $request->input('search.value');

    if (isset($request->category_id) || isset($request->sub_category_id)) {
      $category_id = $request->category_id;
      $sub_category_id = $request->sub_category_id;
    } else {
      $category_id = 0;
      $sub_category_id = 0;
    }

    // dd($request);

    // DB::enableQueryLog();
    // genrate a query
    // 'categories.name as category_name',

    if (isset($request->category_id) || isset($request->sub_category_id)) {
      $customcollections = Product::select('products.id', 'products.sku', 'products.tax', 'productvariants.taxable_price', 'productvariants.offer_price', 'productvariants.mrp_price', 'categories.name as category_name', 'sub_categories.name as subcategory_name', 'products.product_type', 'products.name as title', 'products.category_id', 'products.sub_category_id', 'products.slug', 'product_images.image_name', 'image_url', 'products.is_active')
        ->leftJoin('categories', function ($join) {
          return $join->on('products.category_id', '=', 'categories.id');
        })
        ->where('has_box', 'No')
        ->where('products.category_id', $category_id)
        ->when($request->sub_category_id, function ($query) use ($sub_category_id) {
          $query->where('products.sub_category_id', $sub_category_id);
        })
        ->leftJoin('sub_categories', function ($join) {
          return $join->on('products.sub_category_id', '=', 'sub_categories.id');
        })
        ->leftJoin('product_images', function ($join) {
          return $join->on('products.id', '=', 'product_images.product_id')->where('product_images.position', '=', 0);
        })
        ->leftJoin('productvariants', function ($join) {
          return $join->on('products.id', '=', 'productvariants.product_id')->where('productvariants.type', '=', 'single');
        });
    } else {
      $customcollections = Product::select('products.id', 'products.sku', 'products.tax', 'productvariants.taxable_price', 'productvariants.offer_price', 'productvariants.mrp_price', 'categories.name as category_name', 'sub_categories.name as subcategory_name', 'products.product_type', 'products.name as title', 'products.category_id', 'products.sub_category_id', 'products.slug', 'product_images.image_name', 'image_url', 'products.is_active')
        ->leftJoin('categories', function ($join) {
          return $join->on('products.category_id', '=', 'categories.id');
        })
        ->where('has_box', 'No')
        ->leftJoin('sub_categories', function ($join) {
          return $join->on('products.sub_category_id', '=', 'sub_categories.id');
        })
        ->leftJoin('product_images', function ($join) {
          return $join->on('products.id', '=', 'product_images.product_id')->where('product_images.position', '=', 0);
        })
        ->leftJoin('productvariants', function ($join) {
          return $join->on('products.id', '=', 'productvariants.product_id')->where('productvariants.type', '=', 'single');
        });
    }
    $totalData = $customcollections->count();

    $customcollections = $customcollections->when($search, function ($query, $search) {
      return $query->where('products.name', 'LIKE', "%{$search}%")->orWhere('products.sku', 'LIKE', "%{$search}%");
    });

    $totalFiltered = $customcollections->count();
    $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();
    // dump($customcollections);
    $data = [];

    // dd($customcollections);
    foreach ($customcollections as $key => $item) {
      $row['id'] = $item->id;

      $offerPrice = null;
      if ($item->offer_price) {
        $offerPrice = ' <br><small class="font-weight-lighter">
                    <strong><span>Offer Price :  ' . $item->offer_price . ' </span></strong>
                </small>';
      }
      if ($item->sku) {
        $offerPrice .= '<br> <small class="font-weight-lighter">
            <strong><span>Sku :  ' . $item->sku . ' </span></strong>
        </small>';
      }

      $row['title'] = '
                <div class="feeds-widget p-0">
                    <div class="feed-item border-0 p-0">
                        <a href="' . route('admin.product.edit', $item->id) . '" class="d-flex align-items-start" >
                            <div class="feeds-left d-inline-block " style="width:20%;">
                                ' . $this->image('product_image', $item->image_url, '80%') . '
                            </div>
                            <div class="feeds-body">
                                <h5 class="font-weight-normal f-18 text-primary mb-0">' . $item->title . '</h5>
                                <small class="font-weight-lighter">
                                    <strong><span>MRP :  ' . $item->mrp_price . ' </span></strong>
                                </small>
                               ' . $offerPrice . '
                            </div>
                        </a>
                    </div>
                </div>
            ';
      $row['category'] = '<div class="text-center" ><span class="badge badge-pill badge-secondary mb-1">' . $item->category_name . '</span></div>';
      $row['subcategory'] = '<div class="text-center" ><span class="badge badge-pill badge-secondary mb-1">' . $item->subcategory_name . '</span></div>';
      $row['status'] = $this->status($item->is_active == 'Yes' ? null :  $item->is_active, $item->id, route('admin.product.status'));
      $row['option'] = $this->action([
        collect([
          'text' => 'View',
          'action' => route('product.view', ['slug' => $item->slug ?? '']),
          'id' => $item->id,
          'icon' => 'fa fa-eye',
          'page_target' => '_blank',
          'permission' => false
        ]),
        collect([
          'text' => 'Edit',
          'action' => route('admin.product.edit', $item->id),
          'id' => $item->id,
          'icon' => 'fa fa-pen',
          'permission' => true
        ]),
        collect([
          'text' => 'Clone',
          'action' => route('admin.product.clone', $item->id),
          'id' => $item->id,
          'icon' => 'fa fa-clone',
          'permission' => true
        ]),
        collect([
          'text' => 'Delete',
          'action' => route('admin.product.destroy', $item->id),
          'id' => $item->id,
          'class' => 'delete-confirmation',
          'icon' => 'fa fa-trash',
          'permission' => true
        ]),
        ($item->product_type == 'variant' ? collect([
          'text' => 'Variant',
          'action' => route('admin.variation.variation_edit', $item->id),
          'id' => $item->id,
          'icon' => 'fa fa-shopping-cart',
          'permission' => true
        ]) : []),
        // 'view_target' => route('product.detail', ['slug' => $item->handle]),
      ]);
      //Log::info('product slug', ['slug', route('product.view', ['slug' => $item->slug ?? '']), $item->id]);
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
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->data['title'] = 'Product';
    return view('admin.product.index', $this->data);
  }


  public function show(Request $request, $id)
  {


    $product = Product::findOrFail($id);
    $this->data['product'] = $product;

    $productvariant = Product::with('option')->findOrfail($id);
    $this->data['productvariant'] = $productvariant;

    return view('admin.product.view', $this->data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
    $this->data['title'] = 'Create - Product';
    return view('admin.product.create', $this->data);
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

    try {

      DB::beginTransaction();

      $hsncode = HsCode::find($request->taxable_percentage);

      $product = new Product();

      $product->name = $request->title;

      $product->content = $request->input('content');
      $product->short_content = $request->input('short_content');
      $product->additional_description = $request->input('additional_description');
      $product->attachment = $request->attachment ?? 0;

      $product->slug = $request->meta_slug;

      $product->category_id = $request->category;
      $product->sub_category_id = $request->sub_category;
      $product->brand_id = $request->brands;

      $product->meta_slug = $request->meta_slug;
      $product->meta_description = $request->meta_description;
      $product->meta_title = $request->meta_title;

      $product->hs_id = $request->taxable_percentage ?? null;
      $product->tax = floatval($hsncode->percentage ?? 0);
      $product->sku = $request->sku;

      // dd( $product ,$request);
      $product->tax_type = $request->tax_type;
      $product->meta_keywords = $request->meta_keywords;

      $product->product_type = 'single';
      // $product->vendor = $request->vendor;
      $product->save();
      $this->addVariant($product);

      $product->buytogetherproducts()->sync($request->buy_to_together);


      FacadesDB::commit();

      if ($request->save == "exit") {
        return redirect()->route('admin.product.index')->with('success', "Product save successfully");
      }
      // return redirect()->route('admin.image.index',['id' => $product->id])->with('success', __('product.add_product'));
      return redirect()->route('admin.image.index', $product->id);
    } catch (Exception $e) {

      report($e);

      DB::rollback();

      return redirect()->back()->with('error', __('product.error'));
    }
  }

  public function addVariant($productid)
  {
    $price  =  $this->request->offer_price ?? $this->request->mrp_amount;
    $amount = Helper::calcTaxAmount($price, $productid->tax ?? 0, $productid->tax_type == '1' ? true : false);

    $productvariant = Productvariant::UpdateOrCreate(
      ['id' => $productid->productdefaultvariant->id ?? 0],
      [
        'product_id' => $productid->id,
        'mrp_price' => $this->request->mrp_amount,
        'offer_price' => $this->request->offer_price,
        'taxable_price' => $amount,
        'type' => 'single',
        'inventory_quantity' => $this->request->input('quantity', 0),
        'requires_shipping' => 1
      ]
    );
    return $productvariant->id;
  }



  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  // public function edit(Product $product)
  public function edit(Request $request, $id)
  {
    $this->data['title'] = 'Edit - Product';
    $product =  Product::product()->findOrfail($id);
    $this->data['product'] = $product;
    return view('admin.product.edit', $this->data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {

    // dd('f');


    try {

      DB::beginTransaction();

      $hsncode = HsCode::find($request->taxable_percentage);
      // dd($hsncode);
      $product = Product::findOrfail($id);


      $product->name = $request->title;


      $product->content = $request->input('content');
      $product->short_content = $request->input('short_content');
      $product->additional_description = $request->input('additional_description');
      $product->slug = $request->meta_slug;
      $product->attachment = $request->attachment;

      $product->category_id = $request->category;
      $product->sub_category_id = $request->sub_category;
      $product->brand_id = $request->brands;

      $product->meta_slug = $request->meta_slug;
      $product->meta_description = $request->meta_description;
      $product->meta_title = $request->meta_title;
      $product->meta_keywords = $request->meta_keywords;

      $product->hs_id = $request->taxable_percentage ?? null;
      $product->tax = floatval($hsncode->percentage ?? 0);
      $product->sku = $request->sku;

      // $product->tax = floatval($request->taxable_percentage);
      // dd( $product ,$request);
      $product->tax_type = $request->tax_type;

      $product->product_type = $product->product_type;
      // $product->vendor = $request->vendor;
      $product->save();
      // dd( $product);
      $this->addVariant($product);

      if ($product->productvariants->count() > 0) {
        foreach ($product->productvariants as $key_a => $value) {
          $price  = $value->offer_price ?? $value->mrp_price;
          $amount = Helper::calcTaxAmount($price, $product->tax ?? 0, $product->tax_type ?? false);
          // dump($amount);
          $value->taxable_price = $amount;
          $value->save();
        }
      }
      // dd('f');
      $product->buytogetherproducts()->sync($request->buy_to_together);
      // $product->similarproducts()->sync($request->box);
      \DB::commit();

      // event(new ProductChange($product));
      if ($request->save == "exit") {
        return redirect()->route('admin.product.index')->with('success', "Product save successfully");
      }

      return redirect()->route('admin.image.index', ['product_id' => $product->id]);
    } catch (Exception $e) {

      report($e);

      DB::rollback();

      return redirect()->back()->with('error', __('product.error'));
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function destroy(Product $product)
  {
    //
    try {

      // $banner = $product->offerbanners()->update([
      //     'is_active' => 'No'
      // ]);

      $inShoppingCart = ShoppingCart::where('product_id', $product->id)->delete();
      // $product->delete();
      $p = Product::find($product->id)->delete();

      return response()->json([
        'success' => true,
        'message' => 'Product deleted successfully'
      ], 200);
    } catch (\Exception $e) {

      return response()->json([
        'success' => false,
        'message' => 'Product associate with user cart !'
      ], 406);
    }
  }

  public function slugExists(Request $request)
  {
    // dd($request);
    $slug = $request->get('meta_slug');
    $id = $request->get('id');
    $is_exist = Product::where('slug', '=', $slug)->when($id, function ($query, $id) {
      return $query->where('id', '!=', $id);
    })->get();

    if ($is_exist->count() > 0) {
      return 'false';
    }
    return 'true';
  }

  public function changeStatus(Request $request)
  {
    $statuscode = 400;
    $slider = Product::findOrFail($request->id);
    $slider->is_active  = $request->status == 'true' ? 'Yes' : 'No';

    if ($slider->save()) {
      $statuscode = 200;
    }

    $status = $request->status == 'true' ? 'active' : 'deactivate';
    $message = 'Product ' . $status . ' successfully.';

    return response()->json([
      'success' => true,
      'message' => $message
    ], $statuscode);
  }

  public function cloneProduct(Request $request, $id)
  {

    $product = Product::with('productdefaultvariant', 'productvariants.variantCombination', 'productoptionvalue')->where('id', $id)->first();

    $newProduct = $product->replicate();
    $newProduct->name = 'product-clone-title-' . time();
    $newProduct->content = null;
    $newProduct->short_content = null;
    $newProduct->slug = 'product_clone_slug_' . time();
    $newProduct->sku = null;
    $newProduct->meta_slug = 'product_clone_slug_' . time();
    $newProduct->meta_description = null;
    $newProduct->meta_title = null;
    $newProduct->is_active = 'No';
    $newProduct->meta_keywords = null;
    $newProduct->push(); // save Product
    foreach ($product->getRelations() as $relation => $items) {
      if ($items instanceof \Illuminate\Support\Collection) {
        foreach ($items as $item) {
          if ($relation === 'productvariants') {
            continue;
          }
          unset($item->id);
          $newProduct->{$relation}()->create($item->toArray());
        }
      } else { // single relationship data
        unset($items->id);
        $newProduct->{$relation}()->create($items->toArray());
      }
    }

    foreach ($product->productvariants as $key => $item) {
      $newVariant = $item->replicate();
      $newVariant->product_id = $newProduct->id;
      $newVariant->productimage_id = null;
      $newVariant->save(); //save vairnat
      if ($item->variantCombination->count() > 0) {
        foreach ($item->variantCombination as $item_key => $value) {
          $newCombination = $value->replicate();
          $newCombination->product_id = $newProduct->id;
          $newCombination->variant_id = $newVariant->id;
          $newCombination->save();
        }
      }
    }

    return redirect()->route('admin.product.edit', $newProduct->id);
    // clodne Defualt varint
    // $productVariant = clone $product->productdefaultvariant;
  }
}