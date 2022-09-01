@php
$subTotal = 0;
@endphp
@forelse($cartList as $cart)
  @php

    $priceData = Helper::productPrice($cart->productvariant);

    $cartSubTotal = $cart->qty * $cart->productvariant->final_price;
    $subTotal += $cartSubTotal;
    $variant = json_decode($cart->productvariant->variants);

    $variant = collect($variant)
        ->map(function ($key, $item) {
            return '<span class="product-variation">' . ucfirst($item) . ': ' . ucfirst($key) . '</span>';
        })
        ->join('<br />');

    $cartSubTotal = Helper::priceFormate(number_format($cartSubTotal, 2));
    $routeParameter = ['slug' => $cart->product->slug, 'variant' => $cart->productvariant->id];
    $cartData = [
        'product_id' => $cart->product_id,
        'variant_id' => $cart->productvariant->id,
        'image_id' => $cart->productvariant->productimage_id,
    ];
  @endphp

  <tr>
    <td class="product-thumbnail pb-15 px-3" colspan="2">
      <a href="{{ route('product.view', $routeParameter) }}">
        @if ($cart->productvariant->productimage_id && optional($cart->image)->variant_image)
          <img src="{{ $cart->image->variant_image }}" class="img-fluid " style="width: 100px" alt="">
        @else
          <img src="{{ asset('storage/default/default.png') }}" style="width: 100px" class="img-fluid" alt="">
        @endif
      </a>
    </td>

    <td class="product-name pb-15 px-3">
      <a class="mb-10" data-tippy="{{ $cart->product->name ?? '' }}" data-tippy-placement="top" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
        href="{{ route('product.view', $routeParameter) }}">{{ Str::words($cart->product->name, 10, '...') }}</a>
      {!! $variant !!}
    </td>
    <td class="product-price pb-15 px-3"><span class="price">{{ $priceData->price ?? $priceData->offer_price }}</span>
    </td>
    <td class="product-quantity pb-15 px-3 text-center">
      <div style="height: 60px;margin-top:15px;">
        <div class="pro-qty d-inline-block py-0 mx-0">
          <input type="text" value="{{ $cart->qty }}" class="add-to-cart-update-view border-0" min="1" name="view_update_{{ $cart->id }}" readonly data-cart="{{ json_encode($cartData) }}"
            data-url="{{ route('cart.view-update', ['update' => true]) }}" data-msg-max="Product is out of stock" max="{{ $cart->productvariant->inventory_quantity }}">
        </div>
        <div class="errors"></div>
      </div>
    </td>
    <td data-url="{{ route('cart.load.popup', ['cart' => $cart->id]) }}" class="text-center load-image-popup  pb-15 px-3">
      <style>
        @keyframes zoom-in-zoom-out {
          0% {
            transform: scale(1, 1);
          }

          50% {
            transform: scale(1.5, 1.5);
          }

          100% {
            transform: scale(1, 1);
          }
        }

        .zoom-in-zoom-out {
          animation: zoom-in-zoom-out 2s ease-out infinite;

        }
      </style>
      @if ($cart->cartimage->count())
        @include('svg.right', ['width' => '30px'])
        <div class="text-success" style="font-size: 12px;line-height:initial">
          To Add More Pictures <br> Click Here
        </div>
      @else
        @auth
          @include('svg.upload', ['width' => '30px'])
        @else
          <a href="{{ route('login') }}">
            @include('svg.upload', ['width' => '30px'])
          </a>
        @endauth
        <div class="text-info" style="margin-top:4px;font-size: 12px;line-height:initial">
          Upload Pictures <br>
          (Optional)
        </div>
      @endif
      <br>

      @php
        $imageCount = $cart->cartimage->count();
        $uploadimage = $cart->product->attachment - $imageCount;
      @endphp

      <input type="hidden" class="attachment" name="attachment_{{ $cart->id }}" id="attachment_{{ $cart->id }}" value="{{ $imageCount }}" data-msg-max="Please upload {{ $uploadimage }} attachment"
        data-msg-min="Please upload {{ $uploadimage }} attachment" min="{{ $cart->product->attachment }}">
      <div class="errors"></div>
    </td>
    <td class="total-price pb-15 px-3"><span class="price">{{ $cartSubTotal }}</span></td>
    <td class="product-remove pb-15 px-3">
      <a href="javascript:void(0);" class="add-to-cart-remove-view" data-url="{{ route('cart.view-remove') }}" data-id="{{ $cart->id }}">
        <i class="ion-android-close"></i>
      </a>
    </td>
  </tr>
@empty
  <tr>
    <td colspan="7">
      <p class="text-center">Cart Is Empty</p>
    </td>
  </tr>
@endforelse
