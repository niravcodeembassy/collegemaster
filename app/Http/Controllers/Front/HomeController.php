<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Model\CommonBanner;
use App\Model\Homepagebanner;
use App\Model\Newsletter;
use App\Model\Product;
use App\Blog;
use App\Model\Testimonial;
use Illuminate\Http\Request;
use App\Category;
use App\Model\SubCategory;

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
}