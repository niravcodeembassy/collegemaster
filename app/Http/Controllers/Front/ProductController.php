<?php

namespace App\Http\Controllers\Front;

use App\Category;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\ProductReview;
use App\Model\Productvariant;
use App\Model\ShoppingCart;
use App\Model\SubCategory;
use App\Model\WishList;
use Illuminate\Http\Request;
use Auth;
use Str;
use Illuminate\Support\Facades\Session;
use Psy\Exception\BreakException;

class ProductController extends Controller
{
  public function categoryProductList(Request $request, $slug)
  {
    // dump($request->query());
    if ($slug !== "all") {
      $category = Category::with('subCategory')->where('slug', $slug)->select('id', 'image', 'slug', 'name', 'description')->firstOrFail();
    } else {
      $category = Category::where('slug', $slug)->select('id', 'slug', 'image', 'name', 'description')->firstOrFail();
    }
    $categoryList = Category::whereNull('is_active')->with(['subCategory' => function ($q) {
      $q->whereNull('is_active');
    }])->whereNull('is_active')->get();

    $product =  $this->getProductQuery($request, $slug, $category);

    $this->data['product'] = $product;
    $this->data['title'] = $category->name;
    $this->data['categoryList'] = $categoryList;
    $this->data['category'] = $category;
    $this->data['min'] = Productvariant::min('mrp_price');
    $this->data['max'] = Productvariant::max('mrp_price');
    // dd($this);
    return $this->view('frontend.product.productlist');
  }
  public function getProductQuery(Request $request, $slug, $category = null, $sub_category_id = null)
  {
    return Product::productList()->when($slug !== 'all' && isset($category), function ($q) use ($category) {
      return $q->where('category_id', $category->id);
    })
      ->when($sub_category_id, function ($q) use ($sub_category_id) {
        return $q->where('sub_category_id', $sub_category_id->id);
      })
      ->when($request->range, function ($q) use ($request) {
        $ex = explode(';', $request->range);
        return $q->having('sort_price', '<=', $ex[1])->having('sort_price', '>=', $ex[0]);
      })
      ->when($request->sort == null, function ($q) use ($request) {
        return $q->orderBy('products.id', 'asc');
      })
      ->when($request->sort == 'low', function ($q) use ($request) {
        return $q->orderBy('v.taxable_price', 'asc');
      })
      ->when($request->sort == 'high', function ($q) use ($request) {
        return $q->orderBy('v.taxable_price', 'asc');
      })
      ->when($request->search, function ($q) use ($request) {
        return $q->where('products.name', 'like', "%$request->search%");
      })
      ->paginate(12);
  }
  public function subcategoryProductList(Request $request, $id, $slug)
  {
    $subCategory = SubCategory::where('id', $id)->select('id', 'slug', 'name', 'category_id')->firstOrFail();
    $category = Category::findOrFail($subCategory->category_id);
    $this->data['category'] = $category;

    $this->data['subCategory'] = $subCategory;


    // $product = Product::productList()->where('sub_category_id', $subCategory->id)->paginate(12);;
    $product =  $this->getProductQuery($request, $slug, $category, $subCategory);


    $categoryList = Category::whereNull('is_active')->with(['subCategory' => function ($q) {
      $q->whereNull('is_active');
    }])->get();
    $this->data['categoryList'] = $categoryList;
    $this->data['product'] = $product;
    $this->data['min'] = Productvariant::min('mrp_price');
    $this->data['max'] = Productvariant::max('mrp_price');
    $this->data['title'] = $subCategory->name;

    // $this->data['category'] = $category;
    // dd($this);
    return $this->view('frontend.product.subproductlist');
  }

  public function productDetails(Request $request, $slug)
  {
    // dd($request->all());
    $product = Product::where('slug', $slug)->firstOrFail();
    $this->session_id = Session::get('cart_session');

    $variant = Productvariant::when($request->variant, function ($q, $variant) use ($request) {
      return $q->findOrfail($variant);
    }, function ($q) use ($product) {
      return $q->where('product_id', $product->id)->where('type', 'variant')->first();
    });

    if (Auth::check()) {
      $this->data['wishList'] = WishList::where('user_id', Auth::user()->id)->where('variant_id', $variant->id)->first();
      $this->data['cart_product'] = ShoppingCart::where('user_id', Auth::user()->id)->where('variant_id', $variant->id)->first();
    } else {
      $this->data['cart_product'] = ShoppingCart::where('session_id', $this->session_id)->where('variant_id', $variant->id)->first();
    }

    $product = Product::with([
      'productvariants',
      'images:id,product_id,image_name,image_alt',
      'category:id,name,slug'
    ])->where('is_active', 'Yes')->findOrfail($variant->product_id);

    $variantCombination = [];

    if ($product->productvariants->count() > 0) {
      $variantCombination =  $product->productvariants->map(function ($item, $index) {
        $variant = json_decode($item->variants, true);
        $variant['inventory_quantity'] = $item->inventory_quantity;
        $variant['variant_id'] = $item->id;
        return $variant;
      });
    }

    $review = ProductReview::where('product_id', $product->id)->inRandomOrder()->orderBy('id', 'DESC')->limit(3)->get();

    $this->data['product'] = $product;
    $this->data['variantCombination'] = $variantCombination;
    $this->data['productVarinat'] = $variant;
    $this->data['review'] = $review;
    return $this->view('frontend.product.product_details');
  }

  public function varient(Request $request)
  {

    $product_id = $request->product_id;
    $option = $request->option;
    $optionVal = $request->optionValue;
    $objectLength = $request->objectLength;
    $selectBoxval = $request->selectBoxval;
    $product = Product::where('id', $product_id)->firstOrFail();

    if ($product->product_type == 'variant') {
      $variatoinList = $product->load('optoinvalue')->optoinvalue->groupBy('option_id');
    }



    $size_new_option = array();
    $size_price = array();

    $printing_new_option = array();
    $printing_price = array();

    $new_option = array();
    $price = array();
    $var_ids = array();
    $productvariants = ProductVariant::whereProductId($product->id)->get();

    if (isset($variatoinList)) {
      // foreach ($variatoinList as $key => $variatoins) {
      // $options = \App\Model\Option::find($key);

      if ($objectLength == 1) {
        if ($option == "size") {
          foreach ($productvariants as $productvariant) {
            if ($productvariant->type == 'variant') {
              $varint = json_decode($productvariant->variants);
              $array = get_object_vars($varint);
              $properties = array_keys($array);

              // dd(in_array('size',$properties));
              if (in_array('size', $properties)) {
                if ($array['size'] == $optionVal) {
                  if (!in_array($array['printing options'], $new_option)) {
                    array_push($new_option, $array['printing options']);
                    array_push($price, $productvariant->offer_price);
                  }
                }
                // dd($properties);
              }
            }
          }
        } elseif ($option == "printing options") {
          foreach ($productvariants as $productvariant) {
            if ($productvariant->type == 'variant') {
              $varint = json_decode($productvariant->variants);
              $array = get_object_vars($varint);
              $properties = array_keys($array);

              // dd(in_array('size',$properties));
              if (in_array('printing options', $properties)) {
                if ($array['printing options'] == $optionVal) {
                  if (!in_array($array['size'], $new_option)) {
                    array_push($new_option, $array['size']);
                    array_push($price, $productvariant->offer_price);
                  }
                }
                // dd($properties);
              }
            }
          }
        }
      } else {

        // $selectBoxval_array = get_object_vars($selectBoxval);
        // $selectBoxval_properties = array_keys($selectBoxval_array);

        $new_price = "";
        $mrp_price = "";

        foreach ($productvariants as $key => $productvariant) {
          if ($productvariant->type == 'variant') {
            $varint = json_decode($productvariant->variants);
            $array = get_object_vars($varint);
            $properties = array_keys($array);

            if (in_array('size', $properties) && in_array('printing options', $properties)) {
              if (($array['size'] == $selectBoxval['size']) && ($array['printing options'] == $selectBoxval['printing options'])) {
                $new_price = $productvariant->offer_price;
                $mrp_price = $productvariant->mrp_price;
              }
            }
            if (in_array('printing options', $properties)) {
              if ($array['printing options'] == $selectBoxval['printing options']) {
                if (!in_array($array['size'], $size_new_option)) {
                  array_push($size_new_option, $array['size']);
                  array_push($size_price, $productvariant->offer_price);
                }
              }
              // dd($properties);
            }

            if (in_array('size', $properties)) {
              if ($array['size'] == $selectBoxval['size']) {
                if (!in_array($array['printing options'], $printing_new_option)) {
                  array_push($printing_new_option, $array['printing options']);
                  array_push($printing_price, $productvariant->offer_price);
                }
              }
              // dd($properties);
            }
          }
        }


        return view('frontend.product.partial.both-varient', compact('size_new_option', 'size_price', 'printing_new_option', 'printing_price', 'new_price', 'mrp_price', 'selectBoxval', 'product_id'));

        // return view('frontend.product.partial.variant',compact('option','optionVal','new_option','price'));
      }
    }

    // dd($new_option);
    $new_option_lable = $option;
    return view('frontend.product.partial.variant', compact('new_option_lable', 'optionVal', 'new_option', 'price', 'variatoinList', 'product_id'));
  }
}