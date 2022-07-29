<div class="single-product--list">
  <!--=======  single product image  =======-->
  @php
  $priceData = Helper::productPrice($product->productdefaultvariant);
  $routeParameter = Helper::productRouteParameter($product);
  $route = route('product.details',$routeParameter);
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
        <a href="javascript:void(0)" class="has-wish-lists bg-danger" data-tippy="Add to wishlist"
          data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
          data-tippy-theme="sharpborder" data-tippy-placement="left"
          data-url="{{ route('wishlist.add.remove',['variant_id' => $product->variant_id]) }}">
          <i class="ion-android-favorite-outline text-white"></i>
        </a>
        @else
        <a href="javascript:void(0)" class="has-wish-lists" data-tippy="Add to wishlist" data-tippy-inertia="true"
          data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder"
          data-tippy-placement="left"
          data-url="{{ route('wishlist.add.remove',['variant_id' => $product->variant_id]) }}">
          <i class="ion-android-favorite-outline"></i>
        </a>
        @endif
        @else
        <a href="{{ route('login') }}" class="" data-tippy="Add to wishlist" data-tippy-inertia="true"
          data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder"
          data-tippy-placement="left" data-url="#">
          <i class="ion-android-favorite-outline "></i>
        </a>
        @endauth
      </span>
    </div>



  </div>

  <!--=======  End of single product image  =======-->

  <!--=======  single product content  =======-->
  <div class="single-product__content">

    <div class="title">
      <h3> <a href="{{ $route }}">{{ $product->name }}</a></h3>
    </div>
    <div class="price">
      @if ($priceData->offer_price)
      <span class="main-price discounted" style="font-size: 16px;">{{ $priceData->offer_price }}</span>
      @endif
      <span class="main-price" style="font-size: 20px;">{{ $priceData->price }}</span>
    </div>
    <p class="short-desc">
      {!! $product->content !!}
    </p>

    <a href="{{ $route }}" class="lezada-button lezada-button--medium">VIEW PRODUCT</a>

  </div>
  <!--=======  End of single product content  =======-->
</div>
