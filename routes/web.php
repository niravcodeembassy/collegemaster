<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;


// use Barryvdh\DomPDF\Facade as PDF;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/sitemap.xml', function (Request $request) {
  $content = Storage::disk('public')->get('sitemap.xml');
  return response($content, 200, [
    'Content-Type' => 'application/xml'
  ]);
});

Route::group(['namespace' => 'Front', 'middleware' => ['isActiveUser']], function () {

  Route::get('transaction-fail', function () {
    return view('frontend.payment.fail');
  });

  Route::get('/', 'HomeController@index')->name('front.home');

  Route::post('newsletter', 'HomeController@newsletter')->name('newsletter');
  Route::get('blog', 'HomeController@allBlog')->name('blog');
  Route::get('blog/{slug}', 'HomeController@viewBlog')->name('blog.show');

  Route::get('live-search', 'HomeController@liveSearch')->name('live.search');

  Route::get('contact-us', 'ContactUsController@index')->name('contact-us.index');

  Route::get('review', 'HomeController@productReview')->name('review');

  Route::get('about-us', 'ContactUsController@about')->name('page.about');
  Route::get('our-story', 'ContactUsController@ourStory')->name('page.story');
  Route::get('privacy-policy', 'ContactUsController@policy')->name('page.policy');
  Route::get('photo-policy', 'ContactUsController@photoPolicy')->name('page.photo');
  Route::get('cookie-policy', 'ContactUsController@cookiePolicy')->name('page.cookie');
  Route::get('return-policy', 'ContactUsController@returnPolicy')->name('page.returns');
  Route::get('term-conditions', 'ContactUsController@term')->name('page.term');

  Route::get('how-to-place-order', 'ContactUsController@placeOrder')->name('page.order.place');
  Route::get('how-to-send-photo', 'ContactUsController@sendPhoto')->name('page.send.photo');
  Route::get('how-many-photo-send', 'ContactUsController@photoSend')->name('page.photo.send');
  Route::get('how-to-save-change', 'ContactUsController@saveChange')->name('page.save.change');
  Route::get('estimate-delivery-time', 'ContactUsController@deliveryTime')->name('page.delivery.time');
  Route::get('frequent-ask-question', 'ContactUsController@faq')->name('page.faq');

  Route::post('contact-us', 'ContactUsController@store')->name('contact-us.stroe');


  // Route::get('product/category/{slug}', 'ProductController@categoryProductList')->name('category.product');
  // Route::get('product/details/{slug}', 'ProductController@productDetails')->name('product.details');
  // Route::get('product/category/sub-category-{id}/{slug}', 'ProductController@subcategoryProductList')->name('subcategory.product');


  Route::post('product/varient/', 'ProductController@varient')->name('product.varients');

  Route::post('cart/add', 'CartController@add')->name('cart.add');
  Route::post('cart/gift', 'CartController@gift')->name('cart.gift');
  Route::post('cart/remove', 'CartController@remove')->name('cart.remove');
  Route::get('cart/update', 'CartController@update')->name('cart.update');

  Route::get('cart/view', 'CartController@viewcart')->name('cart.view');
  Route::post('cart/view-update', 'CartController@updatecartView')->name('cart.view-update');
  Route::post('cart/view-remove', 'CartController@removecartView')->name('cart.view-remove');


  // 'verified'
  Route::middleware(['auth'])->group(function () {

    Route::get('load/image-popup', 'CartController@loadImagePopUp')->name('cart.load.popup');
    Route::get('load/image-popup/ordered', 'CartController@loadImagePopUpOrdered')->name('cart.load.popup.ordered');
    Route::post('cart/image-store', 'CartController@imageStore')->name('cart.image.store');
    Route::post('cart/image-remove', 'CartController@productImageRemove')->name('cart.productimage.remove');

    Route::resource('profile', 'UserProfileController');
    Route::post('/change/image/{id}', 'UserProfileController@changeProfilImage')->name('changeProfilImage');

    Route::get('/chat', 'MessageController@index')->name('order.chat');

    Route::post('/checkEmail', 'UserProfileController@checkEmail')->name('mailcheck');
    Route::get('/change-password', 'UserProfileController@changePasswordGet')->name('changepassword.get');
    Route::post('/change-password', 'UserProfileController@changePassword')->name('changePassword');
    Route::post('checkOldPassword', 'UserProfileController@checkOldPassword')->name('checkuserPassword');
    Route::get('orders-show/{id}', 'UserProfileController@ordersShow')->name('orders.show');
    Route::post('orders-msg', 'UserProfileController@orderMsg')->name('orders.msg');
    Route::get('user/orders/list', 'UserProfileController@orderList')->name('orders.list');
    Route::get('order/invoice/{id}', 'UserProfileController@orderInvoice')->name('order.inv');

    Route::get('wishlist', 'WishListController@index')->name('wishlist.index');
    Route::get('add-wish-list', 'WishListController@addWishList')->name('wishlist.add.remove');

    Route::match(['get', 'post'], 'cart/check-out', 'CheckOutController@index')->name('checkout');

    // Route::get('cart/check-out', 'CheckOutController@index')->name('checkout');
    Route::post('cart/check-out/post', 'CheckOutController@checkout')->name('checkout.post');
    Route::post('cart/rozarpay-check-out/post', 'CheckOutController@checkoutRozarpay')->name('rozarpay.checkout.post');
    Route::post('countrytostate', 'CheckOutController@country')->name('country.to.state');

    Route::post('stripe/payment', 'StripeController@stripe')->name('stripe.post');
    Route::get('payment/razorpay/{id}', 'CheckOutController@paymentRazorpay')->name('payment.razorpay');
    Route::get('payment/stripe/success/{id}', 'CheckOutController@paymentSuccess')->name('payment.stripe.success');
    Route::post('payment/razorpay/success/{id}', 'CheckOutController@rozarpayPaymentSuccess')->name('payment.razorpay.success');
    Route::get('thankyou/{id}', 'CheckOutController@thankYou')->name('payment.thankyou');

    Route::post('product/review/{product}', 'ProductReviewController@store')->name('product.review');
  });
  Route::get('product/review/{product}/list', 'ProductReviewController@reviewList')->name('product.review.list');
});

Auth::routes(['verify' => true]);

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['namespace' => 'Front', 'middleware' => ['isActiveUser']], function () {
  Route::get('product/{slug}', 'ProductController@productView')->name('product.view');
  Route::get('{cat_slug}/{product_subcategory_slug}/{slug?}', 'ProductController@productDetails')->name('product.details'); //category/product
  Route::get('{slug}', 'ProductController@categoryProductList')->name('category.product'); //category page
  // Route::get('{cat_slug}/{sub_slug}/{slug}', 'ProductController@productSubDetails')->name('product.sub.details'); //category/subcategory/product
});
