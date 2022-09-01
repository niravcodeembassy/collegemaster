<div class="single-product">
  <!--=======  single product image  =======-->
  @php
    $priceData = Helper::productPrice($product);
    $routeParameter = Helper::productRouteParameter($product);
    $route = route('product.view', $product->slug);
  @endphp
  <div class="single-product__image">
    <a class="image-wrap" href="{{ $route }}">
      @foreach ($product->images->take(1) as $item)
        <img src="{{ $item->variant_image }}" class="img-fluid" alt="{{ $item->image_alt ?? '' }}">
      @endforeach
    </a>

    <div class="single-product__floating-icons">
      <span class="wishlist">
        @auth
          @if ($product->wish_lists_id)
            <a href="javascript:void(0)" class="has-wish-lists bg-danger" data-tippy="Add to wishlist" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder"
              data-tippy-placement="left" data-url="{{ route('wishlist.add.remove', ['variant_id' => $product->variant_id]) }}">
              <i class="ion-android-favorite-outline text-white"></i>
            </a>
          @else
            <a href="javascript:void(0)" class="has-wish-lists" data-tippy="Add to wishlist" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder"
              data-tippy-placement="left" data-url="{{ route('wishlist.add.remove', ['variant_id' => $product->variant_id]) }}">
              <i class="ion-android-favorite-outline"></i>
            </a>
          @endif
        @else
          <a href="{{ route('login') }}" class="" data-tippy="Add to wishlist" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder" data-tippy-placement="left"
            data-url="#">
            <i class="ion-android-favorite-outline"></i>
          </a>
        @endauth
      </span>
    </div>

  </div>

  <!--=======  End of single product image  =======-->

  <!--=======  single product content  =======-->

  <div class="single-product__content">
    <div class="title">
      <h3 class="large_screen_content">
        <a href="{{ $route }}">{{ Str::words($product->name, 8, '...') }}</a>
      </h3>
      <h3 class="small_screen_content" style="display: none">
        <a href="{{ $route }}">{{ Str::words($product->name, 6, '...') }}</a>
      </h3>
      <a href="{{ $route }}">
        VIEW PRODUCT
      </a>
    </div>
    <div class="price">
      <span class="main-price" style="font-size: 18px;">{{ 'US' . $priceData->price . '+' }}</span>
      @if ($priceData->offer_price)
        <span class="main-price discounted" style="font-size: 14px;">{{ 'US' . $priceData->offer_price . '+' }}</span>
        <span class="discount-percentage">({{ intval($priceData->dicount) }}% Off)</span>
      @endif
    </div>
  </div>

  <!--=======  End of single product content  =======-->
</div>
