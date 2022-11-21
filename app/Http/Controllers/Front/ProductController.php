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
use App\Model\FrequentAskQuestion;
use Auth;
use Helper;
use Str;
use Illuminate\Support\Facades\Session;
use Share;

class ProductController extends Controller
{
  public function categoryProductList(Request $request, $slug)
  {
    // dump($request->query());
    // if ($slug !== "all") {
    //  $category = Category::with('subCategory')->where('slug', $slug)->select('id', 'image', 'slug', 'name', 'description')->firstOrFail();
    // } else {
    //   $category = Category::where('slug', $slug)->select('id', 'slug', 'image', 'name', 'description')->firstOrFail();
    // }

    // $is_product = Product::where('name', $request->term)->first();
    // if (isset($is_product) && $is_product !== null) {
    //   if ($is_product->sub_category_id !== null) {
    //     return $this->productDetails($request, $is_product->category->slug, $is_product->subCategory->slug, $is_product->slug);
    //   } else {
    //     return $this->productDetails($request, $is_product->category->slug, $is_product->slug);
    //   }
    // }

    $category = Category::with('subCategory')->where('slug', $slug)->select('id', 'image', 'slug', 'name', 'description', 'meta_title', 'meta_description', 'meta_keywords')->firstOrFail();

    $category_rating = Category::groupBy('categories.id')
      ->select('categories.id', 'categories.slug', 'product_reviews.rating as rating')
      ->join('products', function ($join) use ($slug) {
        $join->on('categories.id', '=', 'products.category_id')
          ->where('categories.slug', $slug);
      })->join('product_reviews', function ($join) use ($slug) {
        $join->on('products.id', '=', 'product_reviews.product_id');
      })->selectRaw("avg(rating) as avg_rating,sum(rating) as total_rating")->first();


    $categoryList = Category::whereNull('is_active')
      ->withCount(['products' => function ($q) {
        $q->where('is_active', 'Yes');
      }])->with(['subCategory' => function ($q) {
        $q->whereNull('is_active');
      }])->whereNull('is_active')->get();

    $global_review_avg = ProductReview::whereNull('is_active')->avg('rating');
    $global_review_count = ProductReview::whereNull('is_active')->count();

    $this->data['global_review_avg'] = $global_review_avg;
    $this->data['global_review_count'] = $global_review_count;



    $product =  $this->getProductQuery($request, $slug, $category);
    if ($product->count() > 0) {
      $first_product = $product->first();
      $variant = $first_product->productvariant;
      $this->data['first_product'] = $first_product;
      $this->data['productVarinat'] = $variant;
      $this->data['category_rating'] = isset($category_rating) ? $category_rating : null;
    }

    $this->data['product'] = $product;
    $this->data['title'] = $category->name;
    $this->data['categoryList'] = $categoryList;
    $this->data['category'] = $category;
    $this->data['min'] = Productvariant::min('mrp_price');
    $this->data['max'] = Productvariant::max('mrp_price');
    $this->data['category_list_view'] = '';
    if (isset($categoryList) && $categoryList->count() > 0) {
      $this->data['category_list_view'] = view('frontend.product.partial.category-list', [
        'AllProductCount' => Product::where('is_active', 'Yes')->count(),
        'categoryList' => $categoryList,
        'category' => $category
      ])->render();
    }
    // dd($this);
    return $this->view('frontend.product.productlist');
  }
  public function getProductQuery(Request $request, $slug, $category = null, $sub_category_id = null)
  {
    // $result = '';
    // if ($request->term) {
    //   $cate = Category::when($request->term, function ($query) use ($request) {
    //     return $query->select('id', 'name', 'slug')->where('name', $request->term);
    //   });
    //   $sub_cate = SubCategory::when($request->term, function ($query) use ($request) {
    //     return $query->select('id', 'name', 'slug')->where('name', $request->term);
    //   });
    //   $result = $cate->union($sub_cate)->first();
    // }
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
        return $q->Where('products.name', 'like', "%$request->search%")
          ->orWhere('products.meta_keywords', 'like', "%$request->search%");
      })
      ->when($request->term, function ($q) use ($request) {
        return $q->Where('products.name', 'like', "%$request->term%")
          ->orWhere('products.meta_keywords', 'like', "%$request->term%");
      })
      //$term . '_%' "%$request->term%"
      // $q->Where('products.name', 'like', $request->search . '_%')
      //->when($request->term, function ($q) use ($request, $result) {
      //   $q->when($result !== null, function ($query) use ($request) {
      //     return $query->Join('categories', function ($join) use ($request) {
      //       return $join->on('products.category_id', '=', 'categories.id');
      //     })->Join('sub_categories', function ($join) use ($request) {
      //       return $join->on('products.sub_category_id', '=', 'sub_categories.id');
      //     })->where('categories.name', $request->term)->orWhere('sub_categories.name', $request->term);
      //   }, function ($query) use ($request) {
      //     $query->Where('products.name', 'like', $request->term . '_%');
      //   });
      // })
      ->with('category', 'subcategory')
      ->paginate(12);
  }
  public function subcategoryProductList(Request $request, $cat_slug, $slug)
  {
    $subCategory = SubCategory::where('slug', $slug)->select('id', 'slug', 'name', 'image', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'category_id')->firstOrFail();

    $subcategory_rating = SubCategory::groupBy('sub_categories.id')
      ->select('sub_categories.id', 'sub_categories.slug', 'product_reviews.rating as rating')
      ->join('products', function ($join) use ($slug) {
        $join->on('sub_categories.id', '=', 'products.sub_category_id')
          ->where('sub_categories.slug', $slug);
      })->join('product_reviews', function ($join) use ($slug) {
        $join->on('products.id', '=', 'product_reviews.product_id');
      })->selectRaw("avg(rating) as avg_rating, sum(rating) as total_rating")->first();

    $category = Category::findOrFail($subCategory->category_id);



    $this->data['category'] = $category;

    $this->data['subCategory'] = $subCategory;


    // $product = Product::productList()->where('sub_category_id', $subCategory->id)->paginate(12);;
    $product =  $this->getProductQuery($request, $slug, $category, $subCategory);

    // $categoryList = Category::whereNull('is_active')->with(['subCategory' => function ($q) {
    //   $q->whereNull('is_active');
    // }])->get();

    $categoryList = Category::whereNull('is_active')
      ->withCount(['products' => function ($q) {
        $q->where('is_active', 'Yes');
      }])->with(['subCategory' => function ($q) {
        $q->whereNull('is_active');
      }])->whereNull('is_active')->get();

    $global_review_avg = ProductReview::whereNull('is_active')->avg('rating');
    $global_review_count = ProductReview::whereNull('is_active')->count();

    $this->data['global_review_avg'] = $global_review_avg;
    $this->data['global_review_count'] = $global_review_count;
    if ($product->count() > 0) {
      $first_product = $product->first();
      $variant = $first_product->productvariant;
      $this->data['first_product'] = $first_product;
      $this->data['productVarinat'] = $variant;
      $this->data['subcategory_rating'] = isset($subcategory_rating) ? $subcategory_rating : null;
    }
    $this->data['categoryList'] = $categoryList;
    $this->data['product'] = $product;
    $this->data['min'] = Productvariant::min('mrp_price');
    $this->data['max'] = Productvariant::max('mrp_price');
    $this->data['title'] = $subCategory->name;

    $this->data['category_list_view'] = '';
    if (isset($categoryList) && $categoryList->count() > 0) {
      $this->data['category_list_view'] = view('frontend.product.partial.category-list', [
        'AllProductCount' => Product::count(),
        'categoryList' => $categoryList,
        'category' => $category,
        'subCategory' => $subCategory
      ])->render();
    }

    // $this->data['category'] = $category;
    // dd($this);
    return $this->view('frontend.product.subproductlist');
  }

  public function productDetails(Request $request, $cat_slug, $productAndSubcategorySlug, $slug = null)
  {
    $product = Product::where('slug', $productAndSubcategorySlug)->first();

    $subCategory = SubCategory::with('category')->where('slug', $productAndSubcategorySlug)->first();

    if ($product === null && $subCategory !== null && $subCategory->category && $slug == null) {
      return $this->subcategoryProductList($request, $cat_slug, $productAndSubcategorySlug);
    }

    return  abort(404, 'Invalid Url');
  }

  public function productView(Request $request, $slug)
  {

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

    $faq = FrequentAskQuestion::with('children')->where('type', 'product')->whereNull('parent_id')->get();
    $routeParameter = Helper::productRouteParameter($product);
    $social_link =  Share::page(route('product.view', $product->slug))->facebook()->twitter()->linkedin()->whatsapp()->pinterest()->getRawLinks();

    $product = Product::with([
      'productvariants',
      'images:id,product_id,image_name,image_alt,image_url,position',
      'category:id,name,slug',
      'subcategory:id,name,slug',
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


    $global_review_avg = ProductReview::whereNull('is_active')->avg('rating');
    $global_review_count = ProductReview::whereNull('is_active')->count();
    $review = ProductReview::where('product_id', $product->id)->whereNull('is_active')->with('user')->orderBy('created_at', 'DESC')->paginate(2);
    $product_review = $product->product_review->whereNull('is_active');
    $review_rating = round($product_review->pluck('rating')->avg(), 1);
    $this->data['product_review'] = $product_review;
    $this->data['review_rating'] = $review_rating;
    $this->data['product'] = $product;
    $this->data['variantCombination'] = $variantCombination;
    $this->data['productVarinat'] = $variant;
    $this->data['review'] = $review;
    $this->data['social_link'] = $social_link;
    $this->data['faqList'] = $faq;
    $this->data['global_review_avg'] = $global_review_avg;
    $this->data['global_review_count'] = $global_review_count;

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
        $discount  = "";



        foreach ($productvariants as $key => $productvariant) {
          if ($productvariant->type == 'variant') {
            $varint = json_decode($productvariant->variants);
            $array = get_object_vars($varint);
            $properties = array_keys($array);

            if (in_array('size', $properties) && in_array('printing options', $properties)) {
              if (($array['size'] == $selectBoxval['size']) && ($array['printing options'] == $selectBoxval['printing options'])) {
                $new_price = $productvariant->offer_price;
                $mrp_price = $productvariant->mrp_price;
                if ($productvariant->offer_price) {
                  $discount = (100 * $productvariant->offer_price) /  $productvariant->mrp_price;
                  $discount = 100 - round($discount, 2);
                }
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


        return view('frontend.product.partial.both-varient', compact('size_new_option', 'size_price', 'printing_new_option', 'printing_price', 'new_price', 'mrp_price', 'selectBoxval', 'product_id', 'discount'));

        // return view('frontend.product.partial.variant',compact('option','optionVal','new_option','price'));
      }
    }


    // dd($new_option);
    $new_option_lable = $option;
    return view('frontend.product.partial.variant', compact('new_option_lable', 'optionVal', 'new_option', 'price', 'variatoinList', 'product_id'));
  }
}
