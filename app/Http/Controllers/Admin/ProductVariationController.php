<?php

namespace App\Http\Controllers\Admin;

use App\Model\Product;
use App\Model\Option;
use App\Model\ProductImage;
use App\Model\Productvariant;
use App\Model\ProductVariantCombination;
use App\Model\OptionValue;
use App\Helpers\Helper;
use App\Http\Requests\ProductVariationValidation;
use App\Http\Requests\VariantValidation;
use Str;
use DB;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ProductOptionValue;
use App\Model\ShoppingCart;
use Illuminate\Support\Facades\DB as FacadesDB;

class ProductVariationController extends Controller
{

  public function __construct(Request $request, Product $product)
  {
    $this->request = $request;
    $this->product = $product->findOrfail($this->request->route('product_id'));
  }



  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request, $productid)
  {
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request, $productid)
  {
    //
    $this->data['title'] = 'Create - Product';
    $this->data['product'] = Product::with('productdefaultvariant', 'images')->findOrfail($productid);
    // dd($this->data);
    return view('admin.product.variation.create', $this->data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, $productid)
  {

    // dd($request);

    try {

      DB::beginTransaction();

      $this->createProductOptionValue($productid);

      // create a variation
      $productWithOptionValue = Product::with('productoptionvalue', 'productdefaultvariant')->where('id', $productid)->first();



      if (count($request->variants_name) > 0) {
        foreach ($request->input('variants_name', []) as $key => $value) {

          $productvariant = new Productvariant();
          $productvariant->product_id = $productid;
          $productvariant->mrp_price = $request->input('variant_price.' . $key);
          $productvariant->offer_price = $request->input('variant_cmp_price.' . $key);

          $price  = $productvariant->offer_price ?? $productvariant->mrp_price;
          $amount = Helper::calcTaxAmount($price, $productWithOptionValue->tax ?? 0, $productWithOptionValue->tax_type ?? false);

          $productvariant->taxable_price = $amount;
          $productvariant->productimage_id = $request->input('image_id.' . $key);
          $productvariant->inventory_quantity = $request->input('variant_inventory.' . $key, NUll);
          $productvariant->requires_shipping = 1;
          $productvariant->type = 'variant';
          $productvariant->save();

          $variaton = explode(',', $request->input('variants_name.' . $key));

          $combinations  = $this->createCombinations($productvariant->id, $productWithOptionValue, $variaton);
          $productvariant->variants = $combinations;
          $productvariant->save();
        }
      }

      $productWithOptionValue->product_type = 'variant';
      $productWithOptionValue->save();

      DB::commit();

      return redirect()->route('admin.product.index')->with('success', __('product.add_variation'));
    } catch (Exception $e) {
      report($e);
      DB::rollback();
      return redirect()->back()->with('error', __('product.error'));
    }
  }

  public function createProductOptionValue($product_id)
  {
    foreach (request('product_variants', []) as $key => $value) {
      if (count($value['variants_name'])) {
        foreach ($value['variants_name'] as $key => $variants_name) {
          $productOpton = new ProductOptionValue();
          $productOpton->product_id = $product_id;
          $productOpton->option_id = $value['option_name'];
          $productOpton->option_value_id = $variants_name;
          $productOpton->save();
        }
      }
    }
  }

  public function createCombinations($variatonId, $productWithOptionValue, $variaton)
  {

    $this->combinations = [];
    if (count($variaton) < 1) {
      return $this;
    }

    foreach ($variaton as $key => $value) {
      $optionvalue =  $productWithOptionValue->productoptionvalue->where('option_value_id', $value)->first();
      $newVariation = new ProductVariantCombination();
      $newVariation->product_id = $optionvalue->product_id;
      $newVariation->option_id = $optionvalue->option_id;
      $newVariation->option_value_id = $optionvalue->option_value_id;
      $newVariation->variant_id = $variatonId;
      $newVariation->save();
      $this->combinations[] = $newVariation->id;
    }

    $json =  $this->createVariantJson($variatonId);

    return $json;
  }

  public function createVariantJson($variatonId)
  {
    $josnData = ProductVariantCombination::with('option', 'optionvalue')->where('variant_id', $variatonId)->get();

    $json = $josnData->pluck('option.name')->combine($josnData->pluck('optionvalue.name')->toArray());

    $data = ProductVariantCombination::where('variant_id', $variatonId)->update([
      'variants' => json_encode($json->toArray())
    ]);

    return $json;
  }

  public function saveVariation($option, $variaton, $productid)
  {
    $ids = [];

    foreach ($variaton as $key => $value) {

      $newVariatoin = new OptionValue();
      $newVariatoin->option_id = $option->id;
      $newVariatoin->product_id = $productid;
      $newVariatoin->name = $value;
      $newVariatoin->save();
      $ids[] = collect([
        'option_id' => $option->id,
        'variation_id' => $newVariatoin->id,
      ]);
    }
    return $ids;
  }

  public function uploadFile($value)
  {
    $file = $value;
    $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
    $fileName = str_replace(' ', '_', $fileName);
    $uploadfile =  $file->storeAs('product_image', $fileName);
    return $uploadfile;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function show(Product $product)
  {
    //
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
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, Product $product)
  {
  }

  public function positionImage(Request $request, $product_id)
  {

    $postion = $request->input('images_id', []);

    if ($postion) {

      $postionIndex = 0; // start index with 0 ;

      foreach ($postion as $key => $value) {

        if ($value == '' || is_null($value)) {
          continue;
        }

        $image = ProductImage::where('id', $value)->first();

        if ($image) {
          $image->position = $postionIndex;
          $image->save();
          $postionIndex++;
        }
      }
    }

    return response()->json([
      'message' => __('product.image_remove'),
      'success' => true
    ]);
  }

  public function removeImage(Request $request, $product_id)
  {

    ProductImage::findOrfail($request->id)->delete();

    return response()->json([
      'message' => __('product.image_remove'),
      'success' => true
    ]);
  }

  public function getProductImge()
  {
    $image = $this->product->images->map(function ($item, $i) {
      // dump($item->image_url);
      return [
        'alt' => $item->image_alt,
        'image' => asset('storage/' . $item->image_url),
        'dataURL' => asset('storage/' . $item->image_url),
        'is_delelt' => true,
        'position' => $item->position,
        'progress' => 100,
        'name' => $item->image_name,
        'size' => $item->size,
        'id' => $item->id,
        'removeUrl' => route('admin.product.image.remove', ['product_id' =>  $item->product_id]),
        'upload' => [
          'uuid' => hash('md5', $item->id),
        ],
        'accepted' => true,
        'width' => 255
      ];
    });
    return $image;
  }

  public function addVariantform(Request $request, $product_id)
  {

    // dd($request);

    $this->data['product'] = $this->product;

    $productvariant = Product::with('option')->findOrfail($product_id);

    $this->data['productvariant'] = $productvariant;

    // dd($this->data['productvariant']);

    $view = view('admin.product.variation.add_modal', $this->data)->render();

    return response()->json([
      'success' => true,
      'html' => $view
    ], 200);
  }

  public function addSaveVariantform(Request $request, $product_id)
  {



    try {

      // Create Option value
      if (count($request->option) > 0) {

        $optionValueName  = [];

        foreach ($request->option as $key => $value) {
          $optionValue = new ProductOptionValue();
          $optionValue->option_value_id = $request->input('variants_id.' . $key);
          $optionValue->product_id = $product_id;
          $optionValue->option_id = $value;
          $optionValue->save();
          $optionValueName[] = $request->input('variants_id.' . $key);
        }
      }

      $this->imagId = $request->input('image_id', null);

      $this->uploadVariantionImage($product_id);

      //Get defult variant
      $productWithOptionValue = Product::with('productoptionvalue', 'productdefaultvariant')->where('id', $product_id)->first();
      // save variant data
      $variant = new Productvariant();
      $variant->product_id = $product_id;
      $variant->mrp_price = $request->mrp_amount;
      $variant->offer_price = $request->offer_price;
      $variant->inventory_quantity = $request->inventory_quantity;
      $variant->productimage_id =  $this->imagId  ?? NULL;
      $variant->type =  'variant';

      $price  = $request->offer_price ?? $request->mrp_amount;
      $amount = Helper::calcTaxAmount($price, $productWithOptionValue->tax ?? 0, $productWithOptionValue->tax_type ?? false);
      $variant->taxable_price = $amount;
      $variant->save();

      // Create a combination
      $combinations  = $this->createCombinations($variant->id, $productWithOptionValue, $optionValueName);
      $variant->variants = $combinations;
      $variant->save();

      return back()->with('success', __('product.add_variant'));
      return response()->json([
        'success' => true,
        'message' =>  __('product.add_variant'),
        'html' =>  $view,
      ], 200);
    } catch (Exception $e) {

      report($e);

      DB::rollback();

      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ], 400);
    }
  }


  public function editVariant(Request $request, $product_id)
  {

    $this->data['title'] = 'Product-varinat';

    $productvariant = Productvariant::with('variantCombinationone.optionvalue:id,name', 'image')
      ->where('type', 'variant')
      ->where('product_id', $product_id)
      ->get();

    if ($request->get('variation')) {
      $this->data['productvariantcombination'] = ProductVariantCombination::where('variant_id', $request->get('variation'))->get();
      $this->data['variation'] = $productvariant->where('id', $request->get('variation'))->first();
    }
    // dd($this->data['variation']);
    $this->data['productvariant'] = $productvariant;
    $this->data['product'] = $this->product->load('onlyoption.option');

    return view('admin.product.variation.view', $this->data);
  }


  public function editVariantform(Request $request, $product_id, $id)
  {

    $this->data['product'] = $this->product;

    $productvariant = Productvariant::with('variantCombination.option:id,name', 'variantCombination.optionvalue:id,name', 'image')
      ->where('type', 'variant')
      ->where('product_id', $product_id)
      ->findOrfail($id);


    $this->data['productvariant'] = $productvariant;

    // dd($this->data['productvariant']);

    $view = view('admin.product.variation.edit_modal', $this->data)->render();

    return response()->json([
      'success' => true,
      'html' => $view
    ], 200);
  }


  public function updateVariantform(Request $request, $product_id, $id)
  {

    // dd($request);

    try {

      $variant = Productvariant::findOrfail($id);

      $this->imagId = $request->image_id;

      $this->uploadVariantionImage($product_id);

      // Change variaion
      foreach ($request->variants_id as $key => $value) {

        // change Product Option value_id if exist then update else cre
        $productOptionValue = ProductOptionValue::updateOrCreate([
          'product_id' => $product_id,
          'option_id' => $request->input('option.' . $key),
          'option_value_id' => $value
        ], [
          'product_id' => $product_id,
          'option_id' => $request->input('option.' . $key),
          'option_value_id' => $value,
        ]);

        //change combination option_value_id
        $combination = ProductVariantCombination::findOrfail($request->input('combination_id.' . $key));
        $combination->option_value_id = $value;
        $combination->save();
      }

      $productWithOptionValue = Product::with('productdefaultvariant')->where('id', $product_id)->first();

      // save variant data
      $variant->mrp_price = $request->mrp_amount;
      $variant->offer_price = $request->offer_price;
      $variant->inventory_quantity = $request->inventory_quantity;
      $variant->productimage_id =  $this->imagId  ?? NULL;

      $price  = $request->offer_price ?? $request->mrp_amount;
      $amount = Helper::calcTaxAmount($price, $productWithOptionValue->tax ?? 0, $productWithOptionValue->tax_type ?? false);
      $variant->taxable_price = $amount;
      $variant->type =  'variant';
      $variant->save();

      $this->createVariantJson($variant->id);

      $view = $this->getVariantChange($product_id, $variant->id);

      return redirect()->route('admin.variation.variation_edit', $product_id)->with('success', __('product.update_variant'));
    } catch (Exception $e) {
      report($e);
      return back()->with('error', $e->getMessage());
    }
  }

  public function changeAlt(Request $request, $product_id)
  {

    try {

      DB::beginTransaction();

      $productImage = ProductImage::findOrfail($request->alt_image_id);
      $productImage->image_alt = $request->alt_image;
      $productImage->save();

      DB::commit();
    } catch (Exception $e) {

      report($e);

      DB::rollback();

      if ($request->ajax()) {

        return response()->json([
          'success' => false,
          'message' => __('product.error')
        ], 404);
      }

      return redirect()->back()->with('error', __('product.error'));
    }
  }


  public function uploadVariantionImage($product_id)
  {
    // upload image and index image
    if ($this->request->hasFile('slider_image')) {

      $imagepos = ProductImage::where('product_id', $product_id)->max('position');

      $productImage = ProductImage::where('product_id', $product_id)->find($this->imagId);

      $uploadfile =  $this->uploadFile($this->request->file('slider_image'));

      if (!$productImage) {

        $productImage = new ProductImage();
        $productImage->product_id = $product_id;
        $productImage->position =  $imagepos === NULL ? 0 : $imagepos + 1;
        $productImage->image_url =  $uploadfile;
        $productImage->image_name =  Str::after($uploadfile, 'product_image/');
        $productImage->image_alt =  $this->request->input('alt', null);
        $productImage->size =    $this->request->file('slider_image')->getClientSize();
        $productImage->save();
        $this->imagId = $productImage->id;
      } else {

        \Storage::delete('product_image/' . $productImage->image_name);

        $productImage->image_url =  $uploadfile;
        $productImage->image_name =  Str::after($uploadfile, 'product_image/');
        $productImage->image_alt =  $this->request->input('alt', null);
        $productImage->size =    $this->request->file('slider_image')->getClientSize();
        $productImage->save();
        $this->imagId = $productImage->id;
      }
    }
  }

  public function getVariantChange($product_id, $id)
  {
    $productvariant = Productvariant::with('variantCombination.option:id,name', 'variantCombination.optionvalue:id,name', 'image')
      ->where('type', 'variant')
      ->where('product_id', $product_id)
      ->findOrfail($id);
    $this->data['item'] = $productvariant;
    $this->data['product'] = $this->product;
    return view('admin.product.variation.productvariant', $this->data)->render();
  }


  public function deletevariant(Request $request, $product_id, $id)
  {
    $productvariant = Productvariant::with('images', 'variantCombination')->findOrFail($id);
    // $productvariant->delete();
    // return redirect()->back()->with('success' ,__('product.delete_variant') ) ;
    $statuscode = 400;

    // finde variation and combination delete

    // finde variation and combination delete
    $productvariant->variantCombination()->delete();
    ShoppingCart::where('variant_id', $id)->delete();

    //remove  variant
    if ($productvariant->delete()) {
      $statuscode = 200;
    }
    // get count if 0 then remove all option value and option value
    $count = Productvariant::where('product_id', $product_id)->where('type', 'variant')->count();

    if ($count === 0) {
      //Get defult varinat
      $productWithOptionValue = Product::with('productdefaultvariant', 'option')->where('id', $product_id)->first();
      $productWithOptionValue->product_type = 'single';
      $productWithOptionValue->is_active = 'No';
      $productWithOptionValue->save();
      // $removeVal =  $productWithOptionValue->productoptionvalue()->delete();
      $productWithOptionValue->option()->delete();
      return redirect()->route('admin.product.index')->with('success', __('product.delete_variant'));
    }
    return redirect()->back()->with('success', __('product.delete_variant'));
  }
  public function saveVariantImages(Request $request)
  {
    dd($request);
  }
}
