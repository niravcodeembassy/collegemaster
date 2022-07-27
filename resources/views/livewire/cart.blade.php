<div class="row">
    <!-- Cart Total -->
    <div class="col-12 mb-40 np">
        <!--<h4 class="checkout-title">Check Out</h4>-->
        <div class="checkout-cart-total">

            <h4>Product <span>Total</span></h4>

            <ul>

                @foreach ($carts['cart'] as $cart)
                @php
                $cart = (object) $cart ;

                @endphp
                <li title="{{$cart->name}}" class="clearfix">
                    {{ Str::limit($cart->name,28, '....') }} X {{ $cart->qty }}
                    <span> {{ Helper::showPrice($cart->qty_price) }}</span>
                    <br>
                    {{-- @if (isset($cart->discount_in_percentage) and $cart->discount_in_percentage > 0)
                    <span class="float-left text-success" style="font-size: 12px;"> Discount in percentage
                        {{ number_format($cart->discount_in_percentage,2) }}
                        {{ number_format($cart->discount_amount,2) }}
                    </span>
                    @endif --}}
                </li>
                @endforeach
            </ul>

            <p>Sub Total <span>{{ Helper::showPrice($carts['show_sub_total']) }}</span></p>

            @if ($carts['discount'] > 0)
                <p>Discount <span>{{ Helper::showPrice($carts['discount']) }}</span></p>
            @endif

            @if($carts['shipping_charge'] != 0)
                <p>Shipping Fee <span>{{ Helper::showPrice($carts['shipping_charge']) }}</span></p>
            @endif

            {{-- @if ($carts['tax'] > 0)
            <p>Tax <span>{{ Helper::showPrice($carts['tax']) }}</span></p>
            @endif --}}

            {{-- <h4>Grand Total <span>{{ Helper::showPrice($carts['total']) }}</span></h4> --}}
            <h4>Grand Total <span>{{ Helper::showPrice($carts['show_total']) }}</span></h4>
        </div>
        <p class="text-danger">Note : All price are inclusive tax</p>
    </div>

    <div class="w-100 row px-3 mb-20 lezada-form coupon-form np">
        <div class="col-md-8 col-8">
            <input type="text" name="discount_code" wire:model.lazy="code" id="coupon_code"
                value="{{ request('discount_code') }}" placeholder="Enter your coupon code">
        </div>
        @if (request('discount_code',null))
        <div class="col-md-4 col-4">
            <a href="javascript:void(0)" data-url="{{ route('checkout') }}"
                class=" lezada-button remove-coupon-btn float-right lezada-button--small">remove
                </a>
        </div>
        @else

        <div class="col-md-4 col-4">
            <a href="javascript:void(0)" data-url="{{ route('checkout') }}"
                class=" lezada-button coupon-btn float-right lezada-button--small">apply
                </a>
        </div>
        @endif
        <div class="text-danger col-sm-12">
            <div>{{ Session::get('coupon_error' , '') }}</div>
            @if ($carts['discount'] > 0)
            <div class="text-success">Discount apply successfully.</div>
            @endif
        </div>
    </div>

</div>
