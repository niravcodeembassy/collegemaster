@extends('frontend.layouts.app')

@push('style')
<style>
  a.active {
    opacity: 1 !important;
    color: black;
  }

  .nice-select.open .list {
    width: 100% !important;
  }

  .discounted-price {
    font-size: 1.1rem !important;
  }

  .shop-product__title h1 {
    font-size: 22px !important;
  }

  .social-share-link,
  .quickview-social-icons li a {
    font-size: 15px;
    /* margin: 0 4.5px; */
    display: inline-block;
    width: 30px;
    height: 30px;
    line-height: 37px;
    text-align: center;
    border-radius: 50%;
    color: #A0A0A0;
    background-color: #f5f5f5;
  }

  .svg_icon {
    display: inline-flex;
  }

  .svg_icon svg {
    vertical-align: -0.125em;
    width: 1em;
    height: 1em;
    display: inline-block;
  }

  .social-share-link:hover,
  .quickview-social-icons li a:hover {
    color: #ffffff !important;
    background-color: #1f1f1f;
  }

  .lezada-button {
    font-size: 15px !important;
    line-height: 42px !important;
    padding: 0 25px !important;
    border-radius: 0px !important;
  }
</style>
@endpush

@section('title')
{{ $product->name }}
@endsection

@section('title', $product->meta_title)
@section('keywords', $product->meta_keywords)
@section('published_time', $product->created_at)
@section('description', $product->meta_description)

@section('og-title', $product->meta_title)
@section('og-url', url()->current())
@section('og-image', $product->product_src)
@section('og-description',$product->meta_description)

@section('twiter-title', $product->meta_title)
@section('twiter-description', $product->meta_description)
@section('twitter-image', $product->product_src)

@section('content')
<div class="breadcrumb-area d-none   pt-20 pb-20" style="background-color: #f5f5f5;">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="breadcrumb-title">Shop</h1>
        <ul class="breadcrumb-list">
          <li class="breadcrumb-list__item"><a href="{{ url('/') }}">HOME</a></li>
          <li class="breadcrumb-list__item">
            <a href="{{ route('category.product', $product->category->slug) }}">{{ strtoupper($product->category->name)
              }}</a>
          </li>
          @php
          $sub = $product->subcategory;
          @endphp
          <li class="breadcrumb-list__item breadcrumb-list__item--active">
            <a href="{{ route('subcategory.product', ['id' => $sub->id, $sub->slug]) }}">{{ $sub->name }}
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!--==============================================            shop page content         ==============================================-->

<div class="shop-page-wrapper mt-50 mb-50 mt-sm-40 mb-sm-40">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="breadcrumb-area pb-30">
          <ul class="breadcrumb-list">
            <li class="breadcrumb-list__item"><a href="{{ url('/') }}">HOME</a></li>
            <li class="breadcrumb-list__item">
              <a href="{{ route('category.product', $product->category->slug) }}">{{
                strtoupper($product->category->name)
                }}</a>
            </li>
            @php
            $sub = $product->subcategory;
            @endphp
            @if ($sub->count()>0)
            <li class="breadcrumb-list__item">
              <a href="{{ route('subcategory.product', ['id' => $sub->id, $sub->slug]) }}">{{ $sub->name }}
              </a>
            </li>
            @endif
            <li class="breadcrumb-list__item breadcrumb-list__item--active truncate">
              <a href="{{ route('product.details', ['slug' =>$product->slug]) }}">
                {{-- {{ Str::limit($product->name,50)}} --}}
                {{ Str::words($product->name,8, '...') }}
            </li>
            </a>
            </li>
          </ul>
        </div>
        <!--=======  shop product content  =======-->

        <div class="shop-product">
          <div class="row pb-50">
            <div class="col-lg-6 mb-md-70 mb-sm-30">
              <!--=======  shop product big image gallery  =======-->

              <div class="shop-product__big-image-gallery-wrapper mb-30">

                <!--=======  shop product gallery icons  =======-->

                <div class="single-product__floating-badges single-product__floating-badges--shop-product">
                  {{-- <span class="hot">hot</span> --}}
                  <input type="hidden" value="{{ route('product.varients') }}" id="varient_url">
                </div>


                <div class="shop-product-rightside-icons">

                  <span class="wishlist-icon">
                    @if (isset($wishList))
                    @auth
                    <a href="javascript:void(0)" class="has-wish-lists bg-danger p-1"
                      data-url="{{ route('wishlist.add.remove', ['variant_id' => $productVarinat->id]) }}">
                      <i class="ion-android-favorite-outline text-white"></i>
                    </a>
                    @else
                    <a href="javascript:void(0)" class="has-wish-lists p-1"
                      data-url="{{ route('wishlist.add.remove', ['variant_id' => $productVarinat->id]) }}">
                      <i class="ion-android-favorite-outline"></i>
                    </a>
                    @endif
                    @endauth

                  </span>
                  <span class="enlarge-icon">
                    <a class="btn-zoom-popup p-1" href="#" data-tippy="Click to enlarge" data-tippy-placement="left"
                      data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50"
                      data-tippy-arrow="true" data-tippy-theme="sharpborder"><i class="ion-android-expand"></i></a>
                  </span>
                </div>
                @php
                $images = $product->images;
                if ($productVarinat->productimage_id !== null) {
                $findImage = $images->where('id', $productVarinat->productimage_id)->first();
                $images = $images->reject(function ($value, $key) use ($productVarinat) {
                return $productVarinat->productimage_id == $value->id;
                });
                $images->splice(0, 0, [$findImage]);
                }
                $images = $product->images;
                @endphp
                {{-- @dump($images,$productVarinat) --}}
                <!--=======  End of shop product gallery icons  =======-->

                <div class="shop-product__big-image-gallery-slider lazy">
                  <!--=======  single image  =======-->
                  @foreach ($images as $key=>$item)
                  <div class="single-image main_big_img" id="slick_image_id_{{$item->id}}">
                    <img src="{{ $item->variant_image }}" class="img-fluid" alt="{{ $item->image_alt ?? '' }}">
                  </div>
                  @endforeach
                  <!--=======  End of single image  =======-->
                </div>

              </div>

              <!--=======  End of shop product big image gallery  =======-->

              <!--=======  shop product small image gallery  =======-->

              <div class="shop-product__small-image-gallery-wrapper">
                <div class="shop-product__small-image-gallery-slider lazy">
                  @foreach ($images as $key=>$item)
                  <!--=======  single image  =======-->
                  <div class="single-image" id="slick_id_{{$item->id}}">
                    <img src="{{ $item->variant_image }}" class="img-fluid" alt="{{ $item->image_alt ?? '' }}">
                  </div>
                  <!--=======  End of single image  =======-->
                  @endforeach
                </div>
              </div>

              <!--=======  End of shop product small image gallery  =======-->
            </div>

            <div class="col-lg-6">
              <!--=======  shop product description  =======-->
              <div class="shop-product__description shop-product-url "
                data-url="{{ route('product.details', ['slug' => $product->slug]) }}">
                <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                <!--=======  shop product navigation  =======-->

                {{-- <div class="shop-product__navigation">
                  <a href="shop-product-basic.html"><i class="ion-ios-arrow-thin-left"></i></a>
                  <a href="shop-product-basic.html"><i class="ion-ios-arrow-thin-right"></i></a>
                </div> --}}

                <!--=======  End of shop product navigation  =======-->

                <!--=======  shop product rating  =======-->
                @auth
                @if ($review->count() > 0)
                <div class="shop-product__rating mb-15 text-right">
                  <span class="review-link ">
                    {{-- <a href="javascript:void(0)">({{ $review->count() }} customer
                      reviews)</a> --}}
                    @foreach (range(1,3) as $rating)
                    <i class="fa fa-star" aria-hidden="true"></i>
                    @endforeach
                    @foreach (range(1,2) as $rating)
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    @endforeach
                    <a href="javascript:void(0)">
                      Review ({{ $review->count() }})</a>
                  </span>
                </div>
                @endif
                @endauth

                <!--=======  End of shop product rating  =======-->

                <!--=======  shop product title  =======-->

                <div class="shop-product__title mb-15">
                  <h1>{{ $product->name }}</h1>
                </div>

                <!--=======  End of shop product title  =======-->

                <!--=======  shop product price  =======-->
                @php
                $priceData = Helper::productPrice($productVarinat);
                $currentVariant = json_decode($productVarinat->variants, true);
                if ($product->product_type == 'variant') {
                $variatoinList = $product->load('optoinvalue')->optoinvalue->groupBy('option_id');
                }
                @endphp

                <div class="shop-product__price mb-30">
                  @if ($priceData->offer_price)
                  <span class="main-price discounted">{{ $priceData->offer_price }}</span>
                  @endif
                  <span class="discounted-price">{{ $priceData->price }}</span>
                </div>

                <!--=======  End of shop product price  =======-->

                <!--=======  shop product short description  =======-->

                <div class="shop-product__short-desc mb-50">
                  {!! $product->short_content ?? '' !!}
                </div>
                <!--=======  End of shop product short description  =======-->
                @if (isset($variatoinList))
                <div id="block-varient">
                  @foreach ($variatoinList as $key => $variatoins)

                  <div class="form-group mb-25    ">
                    @php
                    $option = \App\Model\Option::find($key);
                    $productvariants = \App\Model\ProductVariant::whereProductId($product->id)->get();
                    @endphp
                    <label for="variatoins_{{ $key }}" class="d-block shop-product__block__title">{{
                      ucfirst($option->name) }}</label>
                    <div class="d-block clearfix " style="width: 30%;">
                      <select name="variatoins" class="form-control change-combination " id="variatoins_{{ $key }}"
                        style="width: 250px;">
                        @foreach ($variatoins as $item)
                        @php
                        $price = [];
                        foreach ($productvariants as $productvariant) {
                        if ($productvariant->type == 'variant') {
                        $varint = json_decode($productvariant->variants);
                        $array = get_object_vars($varint);
                        $properties = array_keys($array);

                        if (in_array($option->name, $properties)) {
                        if ($item->name == $array[$option->name]) {
                        array_push($price, $productvariant->offer_price);
                        }
                        // dd($properties);
                        }
                        }
                        }
                        @endphp

                        @if ($loop->first)
                        <option value=""> Select </option>
                        @endif
                        @if (count($currentVariant) > 0 && $currentVariant[$option->name] == $item->name)
                        <option value="{{ $item->id }}" data-optionvalue="{{ $item->name }}"
                          data-option="{{ $option->name }}">
                          {{ $item->name }} @if ($price != null)
                          (${{ min($price) }} - ${{ max($price) }})
                          @endif
                        </option>
                        @else
                        <option value="{{ $item->id }}" data-optionvalue="{{ $item->name }}"
                          data-option="{{ $option->name }}">
                          {{ $item->name }} @if ($price != null)
                          (${{ min($price) }} - ${{ max($price) }})
                          @endif
                        </option>
                        @endif
                        {{-- @break --}}
                        @endforeach
                      </select>
                    </div>
                  </div>
                  @php
                  // dd($productvariants);
                  @endphp
                  @endforeach
                </div>
                @endif
                <!--=======  shop product size block  =======-->

                <div class="shop-product__block shop-product__block--size mb-20 d-none">
                  <div class="shop-product__block__title">Size: </div>
                  <div class="shop-product__block__value">
                    <div class="shop-product-size-list">
                      <span class="single-size">L</span>
                      <span class="single-size">M</span>
                      <span class="single-size">S</span>
                      <span class="single-size">XS</span>
                    </div>
                  </div>
                </div>

                <!--=======  End of shop product size block  =======-->

                <!--=======  shop product color block  =======-->

                <div class="shop-product__block shop-product__block--color d-none mb-20">
                  <div class="shop-product__block__title">Color: </div>
                  <div class="shop-product__block__value">
                    <div class="shop-product-color-list">

                      <ul class="single-filter-widget--list single-filter-widget--list--color">
                        <li class="mb-0 pt-0 pb-0 mr-10"><a class="active" href="#"><span
                              class="color-picker black"></span></a></li>
                        <li class="mb-0 pt-0 pb-0 mr-10"><a href="#"><span class="color-picker blue"></span></a></li>
                        <li class="mb-0 pt-0 pb-0 mr-10"><a href="#"><span class="color-picker brown"></span></a></li>

                      </ul>
                    </div>
                  </div>
                </div>

                <!--=======  End of shop product color block  =======-->
                @php
                $style = null;
                if ($productVarinat->inventory_quantity <= 0) {
                  $style='pointer-events: none;cursor: not-allowed;opacity: 0.2;' ; } $cart=['product_id'=>
                  $productVarinat->product_id, 'variant_id' => $productVarinat->id, 'image_id' =>
                  $productVarinat->productimage_id];
                  @endphp
                  <!--=======  shop product quantity block  =======-->
                  <div id="changeEvent" style="{{ $style }}">
                    <div class="shop-product__block shop-product__block--quantity mb-40">
                      <div class="shop-product__block__title">Quantity: </div>
                      <div class="shop-product__block__value">
                        <div class="pro-qty d-inline-block mx-0 pt-0">
                          <input type="text" id="producQty" value="1" readonly
                            max="{{ $productVarinat->inventory_quantity }}" min="1">
                        </div>
                      </div>
                    </div>
                    <div class="mb-20">
                      <div class="shop-product__block__title">Personalization: </div>
                      <textarea name="personalization" class="form-control" id="personalization" cols="50"
                        rows="2">{{ $cart_product->notes ?? '' }}</textarea>
                    </div>
                    @auth
                    <div class="shop-product__buttons mb-40">
                      <a class="lezada-button add-to-cart lezada-button--medium" href="javascript:void(0)"
                        data-cart="{{ json_encode($cart) }}" data-url="{{ route('cart.add') }}">add to cart</a>
                    </div>
                    @else
                    <div class="shop-product__buttons mb-40">
                      <a class="lezada-button add-to-cart lezada-button--medium" href="javascript:void(0)"
                        data-cart="{{ json_encode($cart) }}" data-url="{{ route('cart.add') }}">add to cart</a>
                    </div>
                    @endauth
                  </div>

                  <!--=======  End of shop product buttons  =======-->


                  <!--=======  other info table  =======-->

                  <div class="quick-view-other-info pb-0">
                    <table>

                      @if ($product->sku)
                      <tr class="single-info">
                        <td class="quickview-title w-25">SKU : </td>
                        <td class="quickview-value w-75">
                          <span>{{ $product->sku ?? '' }}</span>
                        </td>
                      </tr>
                      @endif
                      <tr class="single-info">
                        <td class="quickview-title w-25">Categories : </td>
                        <td class="quickview-value w-75">
                          <span>{{ $product->category->name ?? '' }}</span>
                        </td>
                      </tr>
                      @if (!is_null($product->additional_description))
                      <tr class="single-info">
                        <td class="quickview-title w-25">Additional Description : </td>
                        <td class="quickview-value w-75">
                          {!! $product->additional_description ?? '' !!}
                        </td>
                      </tr>
                      @endif


                      <tr class="single-info d-none">
                        <td class="quickview-title">Tags: </td>
                        <td class="quickview-value">
                          <a href="#">Fashion</a>,
                          <a href="#">Men</a>
                        </td>
                      </tr>
                      <tr class="single-info d-none">
                        <td class="quickview-title">Share: </td>
                        <td class="quickview-value">
                          <div class="share mb-30">
                            <span class="socials">
                              <a href="https://www.facebook.com/sharer.php?u=https://demo4.drfuri.com/razzi/shop/blazer-coupe-amincie/"
                                target="_blank" class="social-share-link facebook"><span class="svg_icon "><svg
                                    aria-hidden="true" role="img" focusable="false" width="24" height="24"
                                    viewBox="0 0 7 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M5.27972 1.99219H6.30215V0.084375C6.12609 0.0585937 5.51942 0 4.81306 0C3.33882 0 2.32912 0.99375 2.32912 2.81953V4.5H0.702148V6.63281H2.32912V12H4.32306V6.63281H5.88427L6.13245 4.5H4.32306V3.03047C4.32306 2.41406 4.47791 1.99219 5.27972 1.99219Z">
                                    </path>
                                  </svg></span><span class="after-text d-none">Share on Facebook</span></a><a
                                href="https://twitter.com/intent/tweet?url=https://demo4.drfuri.com/razzi/shop/blazer-coupe-amincie/&amp;text=Blazer%20Coupe%20Amincie"
                                target="_blank" class="social-share-link twitter"><span class="svg_icon "><svg
                                    aria-hidden="true" role="img" focusable="false" viewBox="0 0 24 24" width="24"
                                    height="24" fill="currentColor">
                                    <path
                                      d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                    </path>
                                  </svg></span><span class="after-text d-none">Share on Twitter</span></a><a
                                href="https://www.pinterest.com/pin/create/button/?description=Blazer%20Coupe%20Amincie&amp;media=https://i0.wp.com/demo4.drfuri.com/razzi/wp-content/uploads/sites/14/2020/10/m11.jpg?fit=1000%2C1200&amp;ssl=1&amp;url=https://demo4.drfuri.com/razzi/shop/blazer-coupe-amincie/"
                                target="_blank" class="social-share-link pinterest"><span class="svg_icon "><svg
                                    aria-hidden="true" role="img" focusable="false" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 24 24" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M12.289,2C6.617,2,3.606,5.648,3.606,9.622c0,1.846,1.025,4.146,2.666,4.878c0.25,0.111,0.381,0.063,0.439-0.169 c0.044-0.175,0.267-1.029,0.365-1.428c0.032-0.128,0.017-0.237-0.091-0.362C6.445,11.911,6.01,10.75,6.01,9.668 c0-2.777,2.194-5.464,5.933-5.464c3.23,0,5.49,2.108,5.49,5.122c0,3.407-1.794,5.768-4.13,5.768c-1.291,0-2.257-1.021-1.948-2.277 c0.372-1.495,1.089-3.112,1.089-4.191c0-0.967-0.542-1.775-1.663-1.775c-1.319,0-2.379,1.309-2.379,3.059 c0,1.115,0.394,1.869,0.394,1.869s-1.302,5.279-1.54,6.261c-0.405,1.666,0.053,4.368,0.094,4.604 c0.021,0.126,0.167,0.169,0.25,0.063c0.129-0.165,1.699-2.419,2.142-4.051c0.158-0.59,0.817-2.995,0.817-2.995 c0.43,0.784,1.681,1.446,3.013,1.446c3.963,0,6.822-3.494,6.822-7.833C20.394,5.112,16.849,2,12.289,2">
                                    </path>
                                  </svg></span><span class="after-text d-none">Share on Pinterest</span></a>
                            </span>
                          </div>
                        </td>

                      </tr>
                      <tr class="single-info">
                        <td class="quickview-title">Share: </td>
                        <td class="quickview-value">
                          <ul class="quickview-social-icons">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="d-none"><a href="#"><i class="fa fa-google-plus "></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                          </ul>
                        </td>
                      </tr>
                    </table>
                  </div>

                  <!--=======  End of other info table  =======-->
              </div>
              <!--=======  End of shop product description  =======-->
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!--=======  shop product description tab  =======-->

              <div class="shop-product__description-tab pt-30">
                <!--=======  tab navigation  =======-->

                <div class="tab-product-navigation tab-product-navigation--product-desc mb-20">
                  <div class="nav nav-tabs justify-content-center" id="nav-tab2" role="tablist">
                    <a class="nav-item nav-link mx-5 active" id="product-tab-1" data-toggle="tab"
                      href="#product-series-1" role="tab" aria-selected="true">Description</a>
                    <a class="nav-item nav-link mx-5" id="product-tab-3" data-toggle="tab" href="#product-series-3"
                      role="tab" aria-selected="false">Reviews
                      ({{ $review->count() }})</a>
                  </div>
                </div>

                <!--=======  End of tab navigation  =======-->

                <!--=======  tab content  =======-->

                <div class="tab-content" id="nav-tabContent2">

                  <div class="tab-pane fade show active" id="product-series-1" role="tabpanel"
                    aria-labelledby="product-tab-1">
                    <!--=======  shop product long description  =======-->

                    <div class="shop-product__long-desc mb-30">
                      <p>{!! $product->content !!}</p>
                    </div>

                    <!--=======  End of shop product long description  =======-->
                  </div>

                  <div class="tab-pane fade" id="product-series-3" role="tabpanel" aria-labelledby="product-tab-3">
                    <!--=======  shop product reviews  =======-->

                    <div class="shop-product__review">
                      @if ($review->count() > 0 && $review != null)

                      <h2 class="review-title mb-20">{{ $review->count() }} reviews for
                        High-waist
                        Trousers</h2>

                      <!--=======  single review  =======-->
                      @foreach ($review as $item)

                      <div class="single-review">
                        <div class="single-review__image">
                          <img src="{{ $item->user->profile_src }}" class="img-fluid" alt="user image">
                        </div>
                        <div class="single-review__content">
                          <!--=======  rating  =======-->

                          <div class="shop-product__rating">
                            <span class="product-rating">
                              @foreach (range(1, $item->rating) as $rating)
                              <i class="active ion-android-star"></i>
                              @endforeach
                            </span>
                          </div>

                          <!--=======  End of rating  =======-->

                          <!--=======  username and date  =======-->

                          <p class="username">{{ $item->name == null ? $item->user->name : $item->name }} <span
                              class="date">/
                              {{ $item->created_at->format('M d Y') }}</span>
                          </p>

                          <!--=======  End of username and date  =======-->

                          <!--=======  message  =======-->

                          <p class="message">
                            {{ $item->message }}
                          </p>

                          <!--=======  End of message  =======-->
                        </div>


                      </div>

                      @endforeach
                      <div class="text-center mb-40">
                        <button class="lezada-button show-reviewPopup lezada-button--small"
                          data-url="{{ route('product.review.list', ['product' => $product->id]) }}">Load
                          More</button>
                      </div>
                      <!--=======  End of single review  =======-->

                      @endif
                      <h2 class="review-title mb-20">Add a review</h2>
                      <p class="text-center">Your email address will not be published. Required
                        fields are marked *
                      </p>

                      <!--=======  review form  =======-->

                      <div class="lezada-form lezada-form--review">
                        <form method="POST" action="{{ route('product.review', $product->id) }}">
                          @csrf
                          <div class="row">
                            <div class="col-lg-6 mb-20">
                              <input type="text" name="name" required placeholder="Name *" required>
                            </div>
                            <div class="col-lg-6 mb-20">
                              <input type="email" name="email" required placeholder="Email *" required>
                            </div>
                            <div class="col-lg-12 mb-20">
                              <span class="rating-title mr-30">YOUR RATING</span>
                              <span class="product-rating">

                                <select id="rating" name="rating">
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                </select>
                              </span>
                            </div>
                            <div class="col-lg-12 mb-20">
                              <textarea cols="30" rows="10" required name="message"
                                placeholder="Your review *"></textarea>
                            </div>
                            <div class="col-lg-12 text-center">
                              <button type="submit" class="lezada-button lezada-button--medium">submit</button>
                            </div>
                          </div>
                        </form>
                      </div>

                      <!--=======  End of review form  =======-->


                    </div>

                    <!--=======  End of shop product reviews  =======-->
                  </div>

                </div>

                <!--=======  End of tab content  =======-->
              </div>

              <!--=======  End of shop product description tab  =======-->
            </div>
          </div>
          @include('frontend.product.related_product' ,[
          'product' => $product
          ])

        </div>

        <!--=======  End of shop product content  =======-->
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modelReview" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reviews</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 300px;overflow-y: auto">
        <div id="modalBody"></div>
      </div>
    </div>
  </div>
</div>
<!--=====  End of shop page content  ======-->
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.3.5/dist/alpine.min.js" defer></script>
<script src="{{ asset('js/jquery.barrating.min.js') }}" defer></script>
@endpush
@push('css')
<style>
  .br-theme-fontawesome-stars .br-widget {
    height: 28px;
    white-space: nowrap;
    display: inline;
  }

  .br-theme-fontawesome-stars .br-widget a {
    font: normal normal normal 20px/1 FontAwesome;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    text-decoration: none;
    margin-right: 2px;
  }

  .br-theme-fontawesome-stars .br-widget a:after {
    content: '\f005';
    color: #d2d2d2;
  }

  .br-theme-fontawesome-stars .br-widget a.br-active:after {
    color: #EDB867;
  }

  .br-theme-fontawesome-stars .br-widget a.br-selected:after {
    color: #EDB867;
  }

  .br-theme-fontawesome-stars .br-widget .br-current-rating {
    display: none;
  }

  .br-theme-fontawesome-stars .br-readonly a {
    cursor: default;
  }

  @media print {
    .br-theme-fontawesome-stars .br-widget a:after {
      content: '\f006';
      color: black;
    }

    .br-theme-fontawesome-stars .br-widget a.br-active:after,
    .br-theme-fontawesome-stars .br-widget a.br-selected:after {
      content: '\f005';
      color: black;
    }
  }
</style>
@endpush
@push('script')
<script>
  let productCombination = @json($variantCombination);
        console.log(productCombination);

</script>
<script>
  $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();

        });
        var init = function() {
            //return scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };

        window.onload = init;

        $(document).ready(function() {

            $('#rating').barrating({
                theme: 'fontawesome-stars'
            });

            $('.show-reviewPopup').on('click', function() {
                const el = $(this);
                let url = el.data('url');
                // window.loaders.show();
                showLoader()
                $.ajax({
                    url: url,
                }).always(function(respons) {
                    $('#modalBody').html('');
                    stopLoader();
                }).done(function(respons) {
                    $('#modalBody').html(respons.html);
                    $('#modelReview').modal('toggle');
                }).fail(function(respons) {
                    var data = respons.responseJSON;
                    toast.fire({
                        type: 'error',
                        title: 'Error',
                        text: data.message ? data.message :
                            'something went wrong please try again !'
                    });

                });

            });

        });

</script>
@endpush
