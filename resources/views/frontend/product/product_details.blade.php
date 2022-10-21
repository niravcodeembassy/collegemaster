@extends('frontend.layouts.app')

@push('style')
  <style>
    a.active {
      opacity: 1 !important;
      color: black;
    }

    h1 {
      font-size: 24px;
      line-height: 34px;
      font-weight: 500;
    }

    .bt {
      border-bottom: 1px dotted black;
    }

    .nice-select.open .list {
      width: 100% !important;
    }

    .related_margin {
      margin-top: 25px;
      margin-bottom: 70px;
    }


    img.delivery_truck {
      width: 50px;
    }

    a.delivery_truck_link:hover {
      color: #444444;
    }

    a.delivery_truck_link {
      color: #444444;
    }

    .stock {
      width: 80px;
      margin-left: 50px;
    }


    .discounted-price {
      font-size: 1.35rem !important;
      color: #ad0101 !important;
    }

    .discount-percentage {
      font-size: 15px !important;
      color: #aaa;
    }

    .social-share-link {
      font-size: 15px;
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

    .social-share-link:hover {
      color: #ffffff !important;
      background-color: #1f1f1f;
    }

    .lezada-button {
      font-size: 15px !important;
      line-height: 42px !important;
      padding: 0 25px !important;
      border-radius: 0px !important;
    }

    .breadcrumb-list__item:after {
      content: ">" !important;
    }

    .collapse_border {
      border-top: 1px solid black;
      border-bottom: 1px solid black;
    }

    li.breadcrumb-list__item {
      font-size: 10px !important;
      font-weight: 500 !important;
    }

    .accordion .card-header:after {
      font-family: 'FontAwesome';
      content: "\f054";
      float: right;
    }

    .accordion .card-header:not(.collapsed)::after {
      content: "\f078";
    }

    .accordion .card-body {
      padding: 0.5rem !important;
    }

    span.faq-title {
      font-size: 20px !important;
      line-height: 16px;
    }

    .accordion .card-header {
      padding: 0.1rem 1.25rem;
    }

    span.faq_question {
      font-size: 18px !important;
    }

    .review_btn {
      text-decoration: underline;
    }

    .review_btn:hover {
      text-decoration: none;
    }

    .pb-bottom {
      padding-bottom: 3.5rem !important;
    }


    .ck_editor_data>ul {
      list-style-type: disc;
      display: block;
      margin-block-start: 1em;
      margin-block-end: 1em;
      margin-inline-start: 0px;
      margin-inline-end: 0px;
      padding-inline-start: 40px;
    }


    p.content_h1 {
      font-size: 14px;
    }

    span.content_h2 {
      font-weight: 600;
    }

    .ck_editor_data h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      padding-top: 5px;
    }

    .ck_editor_data h1 {
      font-size: 24px;
    }

    .ck_editor_data h2,
    h3 {
      font-size: 22px;
    }

    .ck_editor_data p {
      max-width: 100%;
      font-size: 15px;
    }


    .ck_editor_data blockquote p {
      max-width: 95%;
    }

    .ck_editor_data blockquote {
      padding-top: 5px;
      padding-bottom: 5px;
    }


    .ck_editor_data table,
    .ck_editor_data th,
    .ck_editor_data td {
      border: 1px solid black;
    }

    .shop-product__big-image-gallery-slider .slick-arrow {
      background: white;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      border: none;
      color: black;
    }

    .single-product__floating-icons {
      top: 8px;
      right: 10px;
    }

    .w-55 {
      width: 55%;
    }

    .single-product__floating-icons span a {
      width: 36px;
      height: 36px;
    }

    .shop-product__description-tab .tab-product-navigation--product-desc .nav-tabs a {
      font-size: 22px;
      line-height: 40px;
      margin-right: 4rem;
      margin-left: 4rem;
    }


    @media only screen and (max-width: 480px) {
      .delivery_truck {
        margin-top: -27px;
      }

      .shop-product__price .w-55 {
        width: 100% !important;
      }

      .shop-product__price {
        display: block !important;
      }


      .shop-product__buttons {
        display: block !important;
      }



      .shop-product__buttons .d-flex {
        display: block !important;
        margin-top: 10px;
      }

      .related_margin {
        margin: 0px;
      }

      .stock {
        margin-left: 0px;
        padding-top: 0px;
      }
    }

    @media only screen and (max-width: 600px) {
      .tab-product-navigation .nav {
        flex-direction: column;
      }

      .tab-product-navigation .nav-tabs .nav-link.active {
        border: none !important;
      }

      .nav-tabs a {
        border: none !important;
      }
    }

    @media only screen and (min-width: 640px) and (max-width: 667px) {
      .shop-product__price .w-55 {
        width: 60% !important;
      }
    }

    @media all and (device-width: 1024px) and (device-height: 768px) and (orientation:landscape) {
      .shop-product__price .w-55 {
        width: 60% !important;
      }
    }
  </style>
@endpush

@section('title')
  {{ $product->meta_title }}
@endsection

@section('meta_title', $product->meta_title)
@section('keywords', $product->meta_keywords)
@section('published_time', $product->created_at)
@section('description', $product->meta_description)

@section('google_name', $product->meta_title)
@section('google_description', $product->meta_description)
@section('google_image', $product->product_src)

@section('og-title', $product->meta_title)
@section('og-url', url()->current())
@section('og-image', $product->product_src)
@section('og-description', $product->meta_description)

@section('twiter-title', $product->meta_title)
@section('twiter-description', $product->meta_description)
@section('twiter-image', $product->product_src)

@php
  $priceData = Helper::productPrice($productVarinat);
  $schema_first = [
      '@context' => 'https://schema.org/',
      '@type' => 'Product',
      'name' => $product->meta_title,
      'image' => $product->product_src,
      'description' => $product->meta_description,
      'brand' => [
          '@type' => 'Brand',
          'name' => env('APP_NAME'),
      ],
      'sku' => $product->sku,
      'offers' => [
          '@type' => 'Offer',
          'url' => route('product.view', $product->slug),
          'priceCurrency' => 'USD',
          'price' => str_replace("$", '', $priceData->price),
          'availability' => 'https://schema.org/InStock',
          'itemCondition' => 'https://schema.org/NewCondition',
      ],
      'aggregateRating' => [
          '@type' => 'AggregateRating',
          'ratingValue' => round($global_review_avg, 1),
          'bestRating' => '5',
          'worstRating' => '1',
          'ratingCount' => $global_review_count,
      ],
  ];

  $schema_organization = Schema::organizationSchema();
  $schema_local = Schema::localSchema();

  $schema_third = [
      '@context' => 'https://schema.org/',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
          [
              '@type' => 'ListItem',
              'position' => 1,
              'name' => 'Home',
              'item' => route('front.home'),
          ],
          [
              '@type' => 'ListItem',
              'position' => 2,
              'name' => 'Products',
              'item' => route('category.product', $product->category->slug),
          ],
          [
              '@type' => 'ListItem',
              'position' => 3,
              'name' => $product->name,
              'item' => url()->current(),
          ],
      ],
  ];

  $product_schema = json_encode($schema_first, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  $schema_organization = json_encode($schema_organization, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  $schema_local = json_encode($schema_local, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  $list_schema = json_encode($schema_third, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

  $schema = [$product_schema, $schema_organization, $list_schema, $schema_local];
@endphp

@section('schema')

  @foreach ($schema as $key => $list)
    <x-schema>
      {!! $list !!}
    </x-schema>
  @endforeach

@endsection

@section('content')

  <div class="mt-15">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="breadcrumb-area pb-20">
            <ul class="breadcrumb-list">
              <li class="breadcrumb-list__item text-uppercase"><a href="{{ route('front.home') }}">HOME</a></li>
              <li class="breadcrumb-list__item {{ is_null($product->subcategory) ? 'breadcrumb-list__item--active text-uppercase' : 'text-uppercase' }}">
                <a href="{{ route('category.product', $product->category->slug) }}">{{ strtoupper($product->category->name) }}</a>
              </li>
              @php
                $routeParameter = Helper::productRouteParameter($product);
                $sub = $product->subcategory;
                unset($routeParameter['slug']);
              @endphp
              @if (isset($sub) && !is_null($sub))
                <li class="breadcrumb-list__item breadcrumb-list__item--active text-uppercase">
                  <a href="{{ route('product.details', $routeParameter) }}">{{ $sub->name }}
                  </a>
                </li>
              @endif
              <li class="breadcrumb-list__item breadcrumb-list__item--active d-none">
                <a href="javascript:void(0)">
                  {{ $product->name }}
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>




  <!--==============================================            shop page content         ==============================================-->

  <div class="shop-page-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <!--=======  shop product content  =======-->
          <div class="shop-product">
            <div class="row pb-100">

              <div class="col-lg-6 mb-md-70 mb-sm-70">
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
                          <a href="javascript:void(0)" class="has-wish-lists bg-danger p-1" data-url="{{ route('wishlist.add.remove', ['variant_id' => $productVarinat->id]) }}">
                            <i class="ion-android-favorite-outline text-white"></i>
                          </a>
                        @else
                          <a href="javascript:void(0)" class="has-wish-lists p-1" data-url="{{ route('wishlist.add.remove', ['variant_id' => $productVarinat->id]) }}">
                            <i class="ion-android-favorite-outline"></i>
                          </a>
                        @endif
                      @endauth

                    </span>
                    @php
                      $images = $product->images;

                      // if ($productVarinat->productimage_id !== null) {
                      //     $findImage = $images->where('id', $productVarinat->productimage_id)->first();
                      //     $images = $images->reject(function ($value, $key) use ($productVarinat) {
                      //         return $productVarinat->productimage_id == $value->id;
                      //     });
                      //     $images->splice(0, 0, [$findImage]);
                      // }
                      $images_list = $product->images->map(function ($item) {
                          return [
                              'alt' => $item->image_alt,
                              'src' => $item->variant_image,
                          ];
                      });
                    @endphp
                    <span class="enlarge-icon">
                      <a class="btn-zoom-popup p-1" href="#" data-images="{{ $images_list }}" data-tippy="Click to enlarge" data-tippy-placement="left" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50"
                        data-tippy-arrow="true" data-tippy-theme="sharpborder"><i class="ion-android-expand"></i></a>
                    </span>
                  </div>

                  {{-- @dump($images, $productVarinat) --}}
                  <!--=======  End of shop product gallery icons  =======-->

                  <div class="shop-product__big-image-gallery-slider lazy">
                    <!--=======  single image  =======-->
                    @foreach ($images as $key => $item)
                      <div class="single-image main_big_img" id="slick_image_id_{{ $item->id }}">
                        <img src="{{ $item->variant_image }}" class="img-fluid" alt="{{ $item->image_alt ?? '' }}" title="{{ $item->image_alt ?? '' }}">
                      </div>
                    @endforeach
                    <!--=======  End of single image  =======-->
                  </div>

                </div>

                <!--=======  End of shop product big image gallery  =======-->

                <!--=======  shop product small image gallery  =======-->

                <div class="shop-product__small-image-gallery-wrapper">
                  <div class="shop-product__small-image-gallery-slider lazy">
                    @foreach ($images as $key => $item)
                      <!--=======  single image  =======-->
                      <div class="single-image" id="slick_id_{{ $item->id }}">
                        <img src="{{ $item->variant_image }}" class="img-fluid" alt="{{ $item->image_alt ?? '' }}" title="{{ $item->image_alt ?? '' }}">
                      </div>
                      <!--=======  End of single image  =======-->
                    @endforeach
                  </div>
                </div>

                <!--=======  End of shop product small image gallery  =======-->
              </div>

              <div class="col-lg-6">
                <div class="shop-product__description shop-product-url" data-url="{{ route('product.view', $product->slug) }}">
                  <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                  <!--=======  shop product navigation  =======-->

                  {{-- <div class="shop-product__navigation">
                      <a href="shop-product-basic.html"><i class="ion-ios-arrow-thin-left"></i></a>
                      <a href="shop-product-basic.html"><i class="ion-ios-arrow-thin-right"></i></a>
                    </div> --}}

                  <!--=======  End of shop product navigation  =======-->

                  <!--=======  shop product rating  =======-->
                  @auth
                    @if ($product_review->count() > 0)
                      <div class="shop-product__rating mb-15 text-right d-none">
                        <span class="review-link ">
                          {{-- <a href="javascript:void(0)">({{ $product_review->count() }} customer
                      reviews)</a> --}}
                          @for ($i = 0; $i < $review_rating; $i++)
                            <i class="fa fa-star star fa-1x" aria-hidden="true"></i>
                          @endfor
                          @for ($i = 0; $i < 5 - $review_rating; $i++)
                            <i class="fa fa-star-o fa-1x" aria-hidden="true"></i>
                          @endfor
                          <a href="javascript:void(0)">
                            Review ({{ $product_review->count() }})</a>
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

                  <div class="align-items-center d-flex mb-25 shop-product__price">
                    <div class="d-flex flex-wrap w-55">
                      <span class="discounted-price">{{ 'US' . $priceData->price . '+' }}</span>
                      @if ($priceData->offer_price)
                        <span class="main-price discounted">{{ 'US' . $priceData->offer_price . '+' }}</span>
                        <span class="discount-percentage">({{ intval($priceData->dicount) }}% Off)</span>
                      @endif
                      <p class="content_h1"><span class="content_h2">HOORAY!</span> This item delivers for free.</p>
                    </div>
                    <img src="{{ asset('front/assets/images/stock.png') }}" class="stock img-fluid" alt="item in stock" title="item in stock">
                  </div>


                  <!--=======  End of shop product price  =======-->

                  <!--=======  shop product short description  =======-->

                  {{-- <div class="shop-product__short-desc">
                    {!! $product->short_content ?? '' !!}
                  </div> --}}
                  <!--=======  End of shop product short description  =======-->
                  @if (isset($variatoinList))
                    <div id="block-varient">
                      @foreach ($variatoinList as $key => $variatoins)
                        <div class="form-group mb-25">
                          @php
                            $option = \App\Model\Option::find($key);
                            $productvariants = \App\Model\ProductVariant::whereProductId($product->id)->get();
                          @endphp
                          <label for="variatoins_{{ $key }}" class="d-block shop-product__block__title"><b>{{ ucfirst($option->name) }}</b> <span class="text-danger">*</span></label>
                          <div class="d-block clearfix " style="width: 30%;">
                            <select name="variatoins" class="form-control change-combination " id="variatoins_{{ $key }}" style="width: 350px;">
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
                                  <option value="{{ $item->id }}" data-optionvalue="{{ $item->name }}" data-option="{{ $option->name }}">
                                    {{ $item->name }} @if ($price != null)
                                      (${{ min($price) }} - ${{ max($price) }})
                                    @endif
                                  </option>
                                @else
                                  <option value="{{ $item->id }}" data-optionvalue="{{ $item->name }}" data-option="{{ $option->name }}">
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
                          <li class="mb-0 pt-0 pb-0 mr-10"><a class="active" href="#"><span class="color-picker black"></span></a></li>
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
                        $style = 'pointer-events: none;cursor: not-allowed;opacity: 0.2;';
                    }
                    $cart = ['product_id' => $productVarinat->product_id, 'variant_id' => $productVarinat->id, 'image_id' => $productVarinat->productimage_id];
                  @endphp
                  <!--=======  shop product quantity block  =======-->
                  <div id="changeEvent" style="{{ $style }}">
                    <div class="shop-product__block shop-product__block--quantity mb-20">
                      <div class="shop-product__block__title"><b>Quantity:</b> </div>
                      <div class="shop-product__block__value">
                        <div class="pro-qty d-inline-block mx-0 pt-0">
                          <input type="text" id="producQty" value="1" readonly max="{{ $productVarinat->inventory_quantity }}" min="1">
                        </div>
                      </div>
                    </div>
                    <div class="mb-20">
                      <div class="shop-product__block__title pb-2"><b>Personalization:</b> </div>
                      <textarea name="personalization" class="form-control" id="personalization" cols="50" rows="2">{{ $cart_product->notes ?? '' }}</textarea>
                    </div>
                    {{-- @auth
                      <div class="shop-product__buttons mb-40">
                        <a class="lezada-button add-to-cart lezada-button--medium" href="javascript:void(0)" data-cart="{{ json_encode($cart) }}" data-url="{{ route('cart.add') }}">add to cart</a>
                      </div>
                    @endauth --}}

                    @php
                      $processing_time = isset($frontsetting->processing_time) ? $frontsetting->processing_time : 4;
                      $delivery_days = isset($frontsetting->delivery_days) ? $frontsetting->delivery_days : 7;
                      $today = today();
                      $nexDate = today()->addDays($delivery_days);
                      $date = $today->format('d M ') . '-' . $nexDate->format(' d M');
                      if ($today->format('M') == $nexDate->format('M')) {
                          $date = $today->format('d') . ' - ' . $nexDate->format('d M');
                      }
                    @endphp

                    <div class="shop-product__buttons mb-40 d-flex">
                      <a class="lezada-button lezada-button--medium add-to-cart mr-3" href="javascript:void(0)" data-cart="{{ json_encode($cart) }}" data-url="{{ route('cart.add') }}">add to cart</a>
                      <div class="d-flex tooltip_truck" data-tippy="{{ $frontsetting->delivery_caption ?? '' }}" data-tippy-placement="top" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50"
                        data-tippy-arrow="true">
                        <a href="javascript:void(0)" class="ml-2 mr-3">
                          <img src="{{ asset('front/assets/images/truck.png') }}" alt="delivery information" title="delivery information" class="delivery_truck img-fluid">
                        </a>
                        <a href="javascript:void(0)" class="delivery_truck_link mt-lg-0 mt-col-3">
                          <b class="mt-lg-0">Arrives By
                            <span class="bt">
                              {{ $date }}
                            </span></b><br />
                          <span>If you order today.</span>
                        </a>
                      </div>


                    </div>
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
                          <td class="quickview-value w-75 ck_editor_data">
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
                      <tr class="single-info">
                        <td class="quickview-title">Share : </td>
                        <td class="quickview-value">
                          <ul class="quickview-social-icons">
                            <li><a href="{{ $social_link['facebook'] }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="{{ $social_link['twitter'] }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="{{ $social_link['whatsapp'] }}" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                            <li><a href="{{ $social_link['linkedin'] }}" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="{{ $social_link['pinterest'] }}" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                            <li>
                              <a href="javascript:void(0)" id="kt_clipboard_3" class="copy_link" data-clipboard-text="{{ url()->current() }}" data-tippy="Copy Link" data-tippy-placement="right" data-tippy-inertia="true"
                                data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder"><i class="fa fa-link"></i></a>
                            </li>
                            <span style="display: none" id="link_copied">Link Copied</span>
                          </ul>
                        </td>
                      </tr>
                      <tr class="single-info d-none">
                        <td class="quickview-title">Share : </td>
                        <td class="quickview-value">
                          <div class="share">
                            <span class="socials">
                              <a href="https://www.facebook.com/sharer.php?u=https://demo4.drfuri.com/razzi/shop/blazer-coupe-amincie/" target="_blank" class="social-share-link facebook"><span class="svg_icon "><svg aria-hidden="true"
                                    role="img" focusable="false" width="24" height="24" viewBox="0 0 7 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M5.27972 1.99219H6.30215V0.084375C6.12609 0.0585937 5.51942 0 4.81306 0C3.33882 0 2.32912 0.99375 2.32912 2.81953V4.5H0.702148V6.63281H2.32912V12H4.32306V6.63281H5.88427L6.13245 4.5H4.32306V3.03047C4.32306 2.41406 4.47791 1.99219 5.27972 1.99219Z">
                                    </path>
                                  </svg></span><span class="after-text d-none">Share on Facebook</span></a><a href="https://twitter.com/intent/tweet?url=https://demo4.drfuri.com/razzi/shop/blazer-coupe-amincie/&amp;text=Blazer%20Coupe%20Amincie"
                                target="_blank" class="social-share-link twitter mx-2"><span class="svg_icon "><svg aria-hidden="true" role="img" focusable="false" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                    <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                    </path>
                                  </svg></span><span class="after-text d-none">Share on Twitter</span></a>
                              <a href="https://www.pinterest.com/pin/create/button/?description=Blazer%20Coupe%20Amincie&amp;media=https://i0.wp.com/demo4.drfuri.com/razzi/wp-content/uploads/sites/14/2020/10/m11.jpg?fit=1000%2C1200&amp;ssl=1&amp;url=https://demo4.drfuri.com/razzi/shop/blazer-coupe-amincie/"
                                target="_blank" class="social-share-link pinterest"><span class="svg_icon "><svg aria-hidden="true" role="img" focusable="false" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"
                                    version="1.1" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M12.289,2C6.617,2,3.606,5.648,3.606,9.622c0,1.846,1.025,4.146,2.666,4.878c0.25,0.111,0.381,0.063,0.439-0.169 c0.044-0.175,0.267-1.029,0.365-1.428c0.032-0.128,0.017-0.237-0.091-0.362C6.445,11.911,6.01,10.75,6.01,9.668 c0-2.777,2.194-5.464,5.933-5.464c3.23,0,5.49,2.108,5.49,5.122c0,3.407-1.794,5.768-4.13,5.768c-1.291,0-2.257-1.021-1.948-2.277 c0.372-1.495,1.089-3.112,1.089-4.191c0-0.967-0.542-1.775-1.663-1.775c-1.319,0-2.379,1.309-2.379,3.059 c0,1.115,0.394,1.869,0.394,1.869s-1.302,5.279-1.54,6.261c-0.405,1.666,0.053,4.368,0.094,4.604 c0.021,0.126,0.167,0.169,0.25,0.063c0.129-0.165,1.699-2.419,2.142-4.051c0.158-0.59,0.817-2.995,0.817-2.995 c0.43,0.784,1.681,1.446,3.013,1.446c3.963,0,6.822-3.494,6.822-7.833C20.394,5.112,16.849,2,12.289,2">
                                    </path>
                                  </svg></span><span class="after-text d-none">Share on Pinterest</span>
                              </a>
                              <a href="#" class="social-share-link" target="_blank"><i class="fa fa-whatsapp"></i></a>
                              <a href="#" class="social-share-link" target="_blank"><i class="fa fa-instagram"></i></a>
                            </span>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </div>

                  <!--=======  End of other info table  =======-->
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <!--=======  shop product description tab  =======-->

                <div class="shop-product__description-tab pt-30 mb-100">
                  <!--=======  tab navigation  =======-->

                  <div class="tab-product-navigation tab-product-navigation--product-desc mb-20">
                    <div class="nav nav-tabs justify-content-center flex-lg-row" id="nav-tab2" role="tablist">
                      <a class="nav-item nav-link active text-uppercase" id="product-tab-1" data-toggle="tab" href="#product-series-1" role="tab" aria-selected="true">Description</a>
                      <a class="nav-item nav-link text-uppercase" id="product-tab-2" data-toggle="tab" href="#product-series-2" role="tab" aria-selected="false">Specification
                      </a>
                      <a class="nav-item nav-link text-uppercase" id="product-tab-3" data-toggle="tab" href="#product-series-3" role="tab" aria-selected="false">
                        <h3>Reviews
                          ({{ $product_review->count() }})</h3>
                      </a>
                    </div>
                  </div>

                  <!--=======  End of tab navigation  =======-->

                  <!--=======  tab content  =======-->

                  <div class="tab-content" id="nav-tabContent2">

                    <div class="tab-pane fade active show" id="product-series-1" role="tabpanel" aria-labelledby="product-tab-1">
                      <!--=======  shop product long description  =======-->

                      <div class="shop-product__long-desc mb-30">
                        <div class="ck_editor_data">
                          {!! $product->content !!}
                        </div>
                      </div>

                      <!--=======  End of shop product long description  =======-->
                    </div>

                    <div class="tab-pane fade" id="product-series-2" role="tabpanel" aria-labelledby="product-tab-2">
                      <!--=======  shop product additional information  =======-->

                      @include('frontend.product.partial.specification')

                      <!--=======  End of shop product additional information  =======-->
                    </div>

                    <div class="tab-pane fade" id="product-series-3" role="tabpanel" aria-labelledby="product-tab-3">
                      <!--=======  shop product reviews  =======-->

                      @include('frontend.product.partial.review')

                      <!--=======  End of shop product reviews  =======-->
                    </div>

                  </div>

                  <!--=======  End of tab content  =======-->
                </div>

                <!--=======  End of shop product description tab  =======-->
              </div>
            </div>
            @include('frontend.product.related_product', [
                'product' => $product,
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

    .quick-view-other-info table tr td .quickview-social-icons li {
      margin-right: 18px;
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



@push('js')
  <script src="{{ asset('front/assets/js/review.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
@endpush







@push('script')
  <script>
    let productCombination = @json($variantCombination);
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
      // Select element
      const target = document.getElementById('kt_clipboard_3');

      clipboard = new ClipboardJS(target);

      // Success action handler
      clipboard.on('success', function(e) {
        const currentLabel = target.innerHTML;
        // Exit label update when already in progress
        if (target.innerHTML === 'Copied!') {
          return;
        }
        // Update button label
        $.toast({
          text: "Link Copied",
          showHideTransition: "slide",
          icon: "success",
          loaderBg: "#f96868",
          position: "top-right",
        });
      });

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
            text: data.message ? data.message : 'something went wrong please try again !'
          });

        });

      });

    });
  </script>
@endpush
