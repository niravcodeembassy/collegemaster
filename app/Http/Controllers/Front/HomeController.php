<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Model\CommonBanner;
use App\Model\Homepagebanner;
use App\Model\Newsletter;
use App\Model\Product;
use App\Blog;
use App\Model\ProductReview;
use App\Model\Testimonial;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\DB;
use App\Model\SubCategory;
use App\Setting;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */

  public function index()
  {

    // $product = Product::get();
    // foreach ($product as $key => $value) {
    //   $pattern = '/❤️️🖤❤️️️/i';
    //   $content =  preg_replace($pattern, '', $value->content);

    //   $product_data = Product::find($value->id);
    //   // dd($content,$value->id);
    //   $product_data->update(['content' => $content]);
    // }

    // $product = Product::productList()->inRandomOrder()->get();
    $this->data['banner'] = Homepagebanner::whereNull('is_active')->get();
    $this->data['commonBanner'] = CommonBanner::whereNull('is_active')->get();
    $this->data['testimonial'] = Testimonial::whereNull('is_active')->get();
    return view('welcome', $this->data);
  }

  public function newsletter(Request $request)
  {

    $newsletter  = new Newsletter();
    $newsletter->email = $request->email;
    $newsletter->save();
    return response()->json([
      'success' => true,
      'message' => 'Newsletter subscribe successfully'
    ], 200);
  }

  public function allBlog()
  {
    $blogs = Blog::whereNull('is_active')->orderBy('id', 'desc')->paginate(3);
    $this->data['title'] = 'Blog';
    $this->data['blogs'] = $blogs;
    return view('frontend.blog.index',  $this->data);
  }

  public function viewBlog($slug)
  {
    $blog = Blog::where('slug', $slug)->first();
    $social_link =  \Share::page(route('blog.show', $blog->slug))
      ->facebook()
      ->twitter()
      ->linkedin()
      ->whatsapp()
      ->pinterest()
      ->getRawLinks();

    $this->data['blog'] = $blog;
    $this->data['social_link'] = $social_link;
    return view('frontend.blog.view',  $this->data);
  }

  public function liveSearch(Request $request)
  {
    $term = $request->get('term');

    $category = Category::whereNull('is_active')->select('id', 'name')->where('name', 'like', "%$term%");
    $sub_category = SubCategory::whereNull('is_active')->select('id', 'name')->where('name', 'like', "%$term%");

    $product = Product::where('is_active', 'Yes')->select('id', 'name')->where('name', 'like', "%$term%");
    $filter_result = $category->union($sub_category)->union($product)->get();

    return response()->json($filter_result);
  }

  public function productReview(Request $request)
  {

    $filter = $request->get('filter');


    $order = array('latest', 'oldest');

    $category_filter = $request->get('category');
    $review_filter = $request->get('rating');
    $reviews = ProductReview::select('product_reviews.*')
      ->with(['product.defaultimage', 'product.category', 'user'])
      ->whereNull('product_reviews.is_active')
      ->when(in_array($filter, $order) && $filter == 'latest', function ($query) {
        return $query->orderBy('product_reviews.created_at', 'Desc');
      })
      ->when(in_array($filter, $order) && $filter == 'oldest', function ($query) {
        return $query->orderBy('product_reviews.created_at', 'Asc');
      })
      ->when($review_filter, function ($query) use ($review_filter) {
        return $query->whereIn('product_reviews.rating', explode(',', $review_filter));
      })->when($category_filter, function ($query) use ($category_filter) {
        return $query->join('products', function ($join) {
          $join->on('products.id', '=', 'product_reviews.product_id');
        })->join('categories', function ($join) use ($category_filter) {
          $join->on('categories.id', '=', 'products.category_id')
            ->whereIn('categories.slug', explode(',', $category_filter));
        });
      })
      ->paginate(20);

    $rating_details = ProductReview::select(
      DB::raw("product_reviews.rating as rating"),
      'product_reviews.*'
    )->whereNull('product_reviews.is_active')
      ->selectRaw('COUNT(product_reviews.id) AS total_rating,COUNT(*) as total_reviews,COUNT(product_reviews.id)*100/(SELECT COUNT(*) FROM product_reviews) as percentage')
      ->groupBy(['rating'])
      ->orderByDesc('rating')
      ->get();

    $title = array('Super', 'Very Good', 'Good', 'Pleasant', 'Poor');
    $rating_details->map(function ($item, $key) use ($title) {
      $item['rating_title'] = $title[$key];
      return $item;
    });

    $category = Category::groupBy('categories.id')
      ->whereNull('categories.is_active')
      ->select('categories.id', 'categories.slug', 'categories.name')
      ->join('products', function ($join) {
        $join->on('categories.id', '=', 'products.category_id');
      })->join('product_reviews', function ($join) {
        $join->on('products.id', '=', 'product_reviews.product_id')
          ->whereNull('product_reviews.is_active');
      })->selectRaw("count(product_reviews.id) as total_reviews")->get();

    $this->data['title'] = 'Review';
    $this->data['category'] = $category;
    $this->data['reviews'] = $reviews;
    $this->data['rating_details'] = $rating_details;
    $this->data['avg_rating'] = ProductReview::whereNull('is_active')->avg('rating');
    return $this->view('frontend.product-review');
  }
}
