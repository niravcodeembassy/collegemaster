<?php

namespace App\Http\Controllers\Admin;

use App\Model\Product;
use App\Model\ProductImage;
use App\Model\Productvariant;
use DB;
use Illuminate\Support\Str;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProductImageController extends Controller
{
  public function __construct(Request $request, Product $product)
  {
    $this->request = $request;
    $this->product = $product->with('images')->findOrfail($this->request->route('product_id'));
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request, $productid)
  {

    $this->data['title'] = 'Product';
    $this->data['productvariant'] = Productvariant::where('product_id', $productid)->count();
    $this->data['product'] =  $this->product;
    $this->data['mockup'] = $this->getProductImge();

    //dd($this->data);
    return view('admin.product.image.index', $this->data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
    $this->data['title'] = 'Crate - Product';
    return view('admin.product.create', $this->data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, $productid)
  {
    //

    try {

      DB::beginTransaction();

      $uploadedFile = [];

      if ($request->hasFile('images')) {

        foreach ($request->file('images', []) as $key => $value) {

          $imagepos = ProductImage::where('product_id', $productid)->max('position');
          $product = new ProductImage();
          $product->product_id = $productid;
          $uploadfile =  $this->uploadFile($value);
          $product->position =  $imagepos === NULL ? 0 : $imagepos + 1;
          $product->image_url =  $uploadfile;
          $product->image_name =  Str::after($uploadfile, 'product_image/');

          $altIndex = collect($this->request->file_id)->search(function ($file) use ($key) {
            return $file == $this->request->input('uuid.' . $key, null);
          });

          $product->image_alt =  $this->request->input('alt.' . $altIndex, null);

          $product->size =   $value->getSize();
          $product->save();
          $uploadedFile[] = [
            'image_id' => $product->id,
            'uuid' => $this->request->input('uuid.' . $key, null)
          ];
        }
      }


      DB::commit();

      return response()->json([
        'message' => 'Upload successfully',
        'success' => true,
        'files' => $uploadedFile
      ], 200);
    } catch (Exception $e) {

      report($e);

      DB::rollback();

      return redirect()->back()->with('error', 'Something went wrong please try again.');
    }
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
      'message' => 'image remove succefully.',
      'success' => true
    ]);
  }

  public function removeImage(Request $request, $product_id)
  {

    try {
      $isdelete = ProductImage::findOrfail($request->id)->delete();

      if (!$isdelete) {
        return response()->json([
          'message' => 'Can\'t delete image.',
          'success' => true
        ], 409);
      }
      return response()->json([
        'message' => 'image remove succefully.',
        'success' => true
      ], 200);
    } catch (Exception $e) {

      report($e);

      return response()->json([
        'message' => 'Image does not remove because it is used.',
        'success' => true
      ], 406);
    }
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

  public function changeAlt(Request $request, $product_id)
  {

    try {

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
          'message' => 'something went wrong please try again.'
        ], 404);
      }

      return redirect()->back()->with('error', 'Something went wrong please try again.');
    }
  }
}
