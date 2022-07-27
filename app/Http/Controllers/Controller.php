<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\HsnCodeResource;
use App\Http\Resources\OptionResource;
use App\Model\Country;
use App\Model\HsCode;
use App\Model\Option;
use App\Model\OptionValue;
use App\Model\Product;
use App\Model\SubCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  protected $data;


  protected function view($view)
  {
    return view($view, $this->data);
  }

  public function getOption(Request $request)
  {
    $option = Option::where('name', 'LIKE', "%$request->search%")->active();
    return OptionResource::collection($option);
  }

  public function getProduct(Request $request)
  {
    $product = Product::select('id', 'name')->where('name', 'LIKE', "%$request->search%")->where('is_active', 'Yes')->get();
    return response()->json([
      'data' => $product
    ]);
    return OptionResource::collection($product);
  }

  public function getSearchProduct(Request $request)
  {

    if ($request->ajax()) {

      $term = trim($request->search);
      $products =  Product::select('id', 'name')
        ->where('name', 'LIKE',  '%' . $term . '%')
        ->where('is_active', 'Yes')->orderBy('name', 'asc')->simplePaginate(10);

      $morePages = true;
      $pagination_obj = json_encode($products);
      if (empty($products->nextPageUrl())) {
        $morePages = false;
      }
      $results = array(
        "results" => $products->items(),
        "pagination" => array(
          "more" => $morePages
        )
      );
      return response()->json($results);
    }
  }

  public function getOptionValue(Request $request)
  {
    $option = OptionValue::whereNull('is_active')->when($request->get('search'), function ($q, $trem) {
      $q->where('name', 'LIKE', "%$trem%");
    })->where('option_id', $request->get('id'))
      ->get();
    return OptionResource::collection($option);
  }

  public function getCategory(Request $request)
  {
    $category = Category::where('name', 'LIKE', "%$request->search%")->whereNull('is_active')->get();
    return CategoryResource::collection($category);
  }

  public function getHsnCode(Request $request)
  {
    $hsnCode = HsCode::where('name', 'LIKE', "%$request->search%")->whereNull('is_active')->get();
    return HsnCodeResource::collection($hsnCode);
  }

  public function getCountry(Request $request)
  {

    $hsnCode = Country::where('name', 'LIKE', "%$request->search%")->whereNull('is_active')->get();
    return  CountryResource::collection($hsnCode);
  }

  public function getSubCategory(Request $request)
  {

    $category = SubCategory::where('name', 'LIKE', "%$request->search%")
      ->whereNull('is_active')
      ->where('category_id', $request->id)
      ->get();

    return CategoryResource::collection($category);
  }
}