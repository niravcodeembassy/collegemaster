<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Model\CommonBanner;
use App\Model\Homepagebanner;
use App\Model\Newsletter;
use App\Model\Product;
use App\Model\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function store(Request $request, $id)
  {
    $review = new ProductReview();
    $review->name = $request->name;
    $review->email = $request->email;
    $review->message = $request->message;
    $review->rating = $request->rating;
    $review->product_id = $id;
    $review->user_id = Auth::user()->id;
    $review->save();
    return back()->with('success', "Thanks for your valuable feedback.");
  }


  public function reviewList(Request $request, $id)
  {
    $review = ProductReview::with('user')->where('product_id', $id)->whereNull('is_active')->paginate(2);
    if ($request->ajax()) {
      $view = view('frontend.product.partial.review_data', ['review' => $review])->render();
      return response()->json(['html' => $view]);
    }

    // $review = ProductReview::with('user')->where('product_id', $id)->get();
    // $html = view('frontend.product.reviewlist', ['reviews' => $review])->render();
    // return response()->json([
    //   'html' => $html,
    //   'success' => true
    // ]);
  }
}