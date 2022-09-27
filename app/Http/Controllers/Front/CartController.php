<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Model\CartImage;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\ShoppingCart;
use App\Repository\Contracts\Cart;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CartController extends Controller
{

  protected $shoppingcart;

  public function __construct(Cart $cart)
  {
    $this->shoppingcart = $cart;
  }

  public function add(Request $request)
  {

    try {
      $this->shoppingcart->add();
      $cartList = $this->shoppingcart->get();
      $html = view('frontend.cart.cart_overlay')->render();
      return response()->json([
        'message' => 'Item remove successfully',
        'html' => $html,
        'count' => $this->shoppingcart->count(),
        'back' => route('cart.view')
      ], 200);
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  public function gift(Request $request)
  {
    $cart_ids = $request->gift_content[0];
    $enable_gift = $request->gift_content[1];
    $gift_message = $request->gift_content[2];

    $record = array_map(function ($ids, $enable, $messages) {
      return  ['cart_id' => $ids, 'enable_gift' => $enable, 'gift_message' => $messages];
    }, $cart_ids, $enable_gift, $gift_message);

    foreach ($record as $key => $list) {
      ShoppingCart::where('id', $list['cart_id'])
        ->update(
          ['order_has_gift' => $list['gift_message'] == null ? 'No' : 'Yes', 'gift_message' => $list['gift_message']]
        );
    }
    return response()->json([
      'message' => 'Item gift message added successfully',
      'back' => route('checkout')
    ], 200);
  }

  public function remove(Request $request)
  {

    try {
      $this->shoppingcart->remove();
      $html = view('frontend.cart.cart_overlay')->render();
      return response()->json([
        'message' => 'Item remove successfully',
        'html' => $html,
        'count' => $this->shoppingcart->count()
      ], 200);
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  public function update(Request $request)
  {
    try {
      $this->shoppingcart->update();
      return response()->json(['message' => 'Item updated successfully'], 200);
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  public function get(Request $request)
  {
    try {
      $cartList = $this->shoppingcart->get();
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  public function viewcart(Request $request)
  {
    $this->data['title'] = 'Cart';
    return $this->view('frontend.cart.view');
  }

  public function updatecartView(Request $request)
  {

    $this->shoppingcart->add();

    $html = view('frontend.cart.tbody')->render();

    return response()->json([
      'message' => 'Item updated successfully',
      'html' => $html,
      'count' => $this->shoppingcart->count()
    ], 200);
  }

  public function removecartView(Request $request)
  {

    try {
      $this->shoppingcart->remove();
      $html = view('frontend.cart.tbody')->render();
      return response()->json([
        'message' => 'Item remove successfully',
        'html' => $html,
        'count' => $this->shoppingcart->count()
      ], 200);
    } catch (exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }



  // Image Image PopUp

  public function loadImagePopUp(Request $request)
  {
    $cartId = $request->cart;
    $cart = ShoppingCart::with('product', 'cartimage')->where('id', $cartId)->first();
    $product = $cart->product;

    $html = view('frontend.cart.imagepopup', [
      "mockup" => $this->getProductImage($cart->cartimage),
      "cart" => $cart,
      "attachment" => $product->attachment ?? 0,
      "product" => $product
    ])->render();
    return response()->json([
      'html' => $html
    ], 200);
  }

  public function loadImagePopUpOrdered(Request $request)
  {
    $cartId = $request->item;
    $cart = OrderItem::with('order', 'images')->where('id', $cartId)->first();
    $product = $cart->order;
    $html = view('frontend.cart.imagepopup_ordered', [
      "mockup" => $this->getProductImage($cart->images),
      "cart" => $cart,
      "attachment" => 0,
      "order" => $product
    ])->render();
    return response()->json([
      'html' => $html
    ], 200);
  }

  public function getProductImage($image)
  {
    $image = $image->map(function ($item, $i) {
      // dump($item->image_url);
      return [
        'image' => asset('storage/' . $item->path),
        'dataURL' => asset('storage/' . $item->path),
        'is_delelt' => true,
        'progress' => 1000,
        'size' => Storage::exists($item->path) ? Storage::size($item->path)  : 0,
        'name' => $item->name,
        'id' => $item->id,
        'removeUrl' => route('cart.productimage.remove', ['id' =>  $item->id]),
        'upload' => [
          'uuid' => hash('md5', $item->id),
        ],
        'accepted' => true,
        'width' => 255
      ];
    });
    return $image;
  }

  public function imageStore(Request $request)
  {

    try {

      DB::beginTransaction();

      $uploadedFile = [];
      $uploadedFilePath = null;

      if ($request->order && $request->item) {
        $uploadedFilePath = $this->itemDirExist($request);
      }

      if ($request->hasFile('images')) {

        foreach ($request->file('images', []) as $key => $value) {

          $product = new CartImage();
          $product->cart_id = $request->cart;
          $product->user_id = Auth::user()->id;
          $uploadfile =  $this->uploadFile($value, $request->cart, $uploadedFilePath);
          $product->path =  $uploadfile['path'];
          $product->name =  $uploadfile['name'];
          $product->order_id = $request->order ?? null;
          $product->item_id = $request->item ?? null;
          $product->save();

          $uploadedFile[] = [
            'image_id' => $product->id,
            'uuid' => $request->input('uuid.' . $key, null)
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
      dd($e);
      report($e);
      DB::rollback();
      return redirect()->back()->with('error', 'Something went wrong please try again.');
    }
  }

  public function itemDirExist($request)
  {
    $uploadedFilePath = CartImage::where('order_id', $request->order)->where('item_id', $request->item)->first();
    if (!$uploadedFilePath) {
      $uploadedFilePath = Order::with(['singleItem' => function ($q) use ($request) {
        $q->where('id', $request->item);
      }])->where('id', $request->order)->first();

      $singleItem = $uploadedFilePath->singleItem;

      $folderName = collect(json_decode($singleItem->attribute, true))->map(function ($item, $key) {
        return $key . '-' . $item;
      })->join('-');

      $folderName = 'cart_image/' . 'order-' . $uploadedFilePath->id . '/' . $singleItem->name . '-' . $singleItem->id . '-' . $folderName;
      $folderName = str_replace(' ', '-', $folderName);
      $root = 'cart_image/' . $singleItem->id . '/';

      if (Storage::exists($root)) {
        Storage::rename($root, $folderName);
      } else {
        Storage::makeDirectory($folderName);
        $uploadedFilePath  = $folderName;
      }
    } else {
      $uploadedFilePath = Str::before($uploadedFilePath->path, $uploadedFilePath->name);
    }
    return $uploadedFilePath;
  }

  public function uploadFile($value, $cartId, $path = null)
  {
    $file = $value;
    $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
    $fileName = str_replace(' ', '_', $fileName);
    $path = $path ?? 'cart_image/' . $cartId;
    $uploadfile =  $file->storeAs($path, $fileName);
    return [
      'path' => $uploadfile,
      'name' => $fileName
    ];
  }

  public function productImageRemove(Request $request)
  {
    try {

      $isdelete = CartImage::findOrfail($request->id);

      Storage::delete($isdelete->path);

      if (!$isdelete->delete()) {

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
}