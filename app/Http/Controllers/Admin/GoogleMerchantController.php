<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\GoogleProductDeleteResource;
use App\Http\Resources\GoogleProductResource;
use App\Model\Product;
use App\Model\Productvariant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use MOIREI\GoogleMerchantApi\Facades\ProductApi;
use GuzzleHttp\Client;

class GoogleMerchantController extends Controller
{
  public function index()
  {
    $this->data['title'] = 'Google Merchant Product';
    return $this->view('admin.google.index');
  }

  // public function create()
  // {
  //   $product_variation = Productvariant::with('product')->where('type', 'variant')->get();
  //   $i = 0;
  //   foreach ($product_variation as $variation) {
  //     if ($variation->product != null && $i < 1) {
  //       $i = 1;
  //       $attributes = [
  //         'id' => $variation->id,
  //         'itemGroupId' => $variation->product->id,
  //         'name' => $variation->product->name,
  //         'short_content' => $variation->product->content,
  //         // 'link' => route('product.view', $variation->product->slug),
  //         'link' => 'https://www.collagemaster.com/product/personalized-1st-birthday-wall-art-gift-for-baby-girlboy',
  //         // 'imageLink' => 'https://www.collegemaster.com/storage/' . $variation->image->image_url,
  //         'imageLink' => 'https://www.collagemaster.com/storage/product_image/1/Personalized_1st_Birthday_Wall_Art_Gift_For_Baby_Girl/Boy_Sample_Photo.jpg',
  //         // "customAttributes" => []
  //       ];
  //       ProductApi::insert(function ($product) use ($attributes, $variation) {
  //         $varint = json_decode($variation->variants);
  //         $array = get_object_vars($varint);
  //         $product->with($attributes)
  //           ->sizes($varint->size)
  //           ->price($variation->mrp_price)
  //           ->salePrice($variation->offer_price)
  //           ->material($array['printing options'])
  //           ->brand('CollageMaster');
  //         // ->customAttributes(["name" => 'printing', "value" => $array['printing options']]);
  //         // dd($product);
  //       })->then(function ($data) {
  //         echo 'Product inserted';
  //       })->otherwise(function () {
  //         echo 'Insert failed';
  //       })->catch(function ($e) {
  //         dump($e);
  //       });
  //     }
  //   }
  // }

  public function insertProduct()
  {
    $config = config("laravel-google-merchant-api.merchants.moirei");
    $app_name = data_get($config, 'app_name');
    $merchant_id = data_get($config, 'merchant_id');
    $client_credentials_path = data_get($config, 'client_credentials_path');
    $client_authorize = $this->initClient($app_name, $merchant_id, $client_credentials_path);
    // dd($client_authorize);

    // $product_variation = Productvariant::with('product')->has('product')->where('type', 'variant')->chunk(1000, function ($variations) use ($client_authorize) {
    //   $google_product = GoogleProductResource::collection($variations);
    //   try {
    //     $body_content = [
    //       "body" => json_encode(["entries" => $google_product])
    //     ];
    //     // dd($body_content);
    //     $response = $client_authorize->request(
    //       'post',
    //       'products/batch',
    //       $body_content
    //     );
    //     dump($response);
    //   } catch (\GuzzleHttp\Exception\ClientException $e) {
    //     dd($e);
    //   } catch (Exception $e) {
    //     dd($e);
    //   }
    // });
    $product_variation = Productvariant::with('product')->has('product')->where('type', 'variant')->take(180)->get();
    $google_product = GoogleProductResource::collection($product_variation);
    try {
      $body_content = [
        "body" => json_encode(["entries" => $google_product])
      ];
      // dd($body_content);
      $response = $client_authorize->request(
        'post',
        'products/batch',
        $body_content
      );
    } catch (\GuzzleHttp\Exception\ClientException $e) {
      dd($e);
    } catch (Exception $e) {
      dd($e);
    }
    return redirect()->back()->with('success', 'Product Saved Sucessfully');
  }

  public function deleteProduct()
  {
    $config = config("laravel-google-merchant-api.merchants.moirei");
    $app_name = data_get($config, 'app_name');
    $merchant_id = data_get($config, 'merchant_id');
    $client_credentials_path = data_get($config, 'client_credentials_path');
    $client_authorize = $this->initClient($app_name, $merchant_id, $client_credentials_path);

    $product_variation = Productvariant::with('product')->has('product')->where('type', 'variant')->take(180)->get();
    $google_product = GoogleProductDeleteResource::collection($product_variation);
    try {
      $body_content = [
        "body" => json_encode(["entries" => $google_product])
      ];
      $response = $client_authorize->request(
        'post',
        'products/batch',
        $body_content
      );
    } catch (\GuzzleHttp\Exception\ClientException $e) {
      dd($e);
    } catch (Exception $e) {
      dd($e);
    }
    return redirect()->back()->with('success', 'Product Saved Sucessfully');
  }
  public function initClient($app_name, $merchant_id, $client_credentials_path)
  {
    $version = config('laravel-google-merchant-api.version', 'v2');
    $client_config = collect(config('laravel-google-merchant-api.client_config'))->only([
      'timeout', 'headers', 'proxy',
      'allow_redirects', 'http_errors', 'decode_content', 'verify', 'cookies',
    ])->filter()->all();
    $client_config['base_uri'] = "https://www.googleapis.com/content/$version/";
    $client_config['headers'] = array_merge($client_config['headers'] ?? [], [
      'Accept' => 'application/json',
      'Content-Type' => 'application/json',
    ]);

    if ((strpos($client_credentials_path, '.json') !== false) && file_exists($client_credentials_path)) {
      $client = new \Google_Client();
      $client->setHttpClient(new Client($client_config));

      $client->setApplicationName($app_name);
      $client->setUseBatch(true);

      $client->setAuthConfig($client_credentials_path);
      $client->addScope('https://www.googleapis.com/auth/content');

      return $client->authorize();
    } else {
      return new Client($client_config);
    }
  }

  public function updateProduct(Request $request)
  {
    $product_id = $request->id;
    $product_variation = Productvariant::with('product')->where('product_id', $product_id)->where('type', 'variant');
    if ($product_variation->count() > 0) {
      $config = config("laravel-google-merchant-api.merchants.moirei");
      $app_name = data_get($config, 'app_name');
      $merchant_id = data_get($config, 'merchant_id');
      $client_credentials_path = data_get($config, 'client_credentials_path');
      $client_authorize = $this->initClient($app_name, $merchant_id, $client_credentials_path);

      $product_variation = $product_variation->get();
      $google_product = GoogleProductResource::collection($product_variation);
      try {
        $body_content = [
          "body" => json_encode(["entries" => $google_product])
        ];
        // dd($body_content);
        $response = $client_authorize->request(
          'post',
          'products/batch',
          $body_content
        );
        return response()->json(
          [
            'success' => true,
            'message' => 'Save successfully'
          ],
          200
        );
      } catch (\GuzzleHttp\Exception\ClientException $e) {
        return response()->json(
          [
            'success' => false,
            'message' => 'Smothing Wrong !'
          ],
          406
        );
      } catch (Exception $e) {
        return response()->json(
          [
            'success' => false,
            'message' => 'Smothing Wrong !'
          ],
          406
        );
      }
    }
  }
}
