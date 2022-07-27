@extends('frontend.layouts.app')
@section('content')
    <div class="breadcrumb-area   pt-20 pb-20 mb-100" style="background-color: #f5f5f5;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="breadcrumb-title">Check Out</h1>

                    <!--=======  breadcrumb list  =======-->

                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-list__item"><a href="{{ url('/') }}">HOME</a></li>
                        <li class="breadcrumb-list__item breadcrumb-list__item--active">Check Out</li>
                    </ul>

                    <!--=======  End of breadcrumb list  =======-->

                </div>
            </div>
        </div>
    </div>
    <div class="checkout-page-area mb-130">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="lezada-form">
                        <!-- Checkout Form s-->
                        <form action="{{ route('checkout.post') }}" method="post" class="checkout-form" id="checkout">
                            @csrf
                            <div class="row row-40">

                                <div class="col-lg-7 mb-20">

                                    <!-- Billing Address -->
                                    <div id="billing-form" class="mb-40">
                                        <h4 class="checkout-title">Shipping Address</h4>

                                        <div class="row">

                                            <div class="col-md-6 col-12 mb-20">
                                                <label>First Name*</label>
                                                <input type="text" value="{{ $shippingAddress->first_name ?? '' }}"
                                                    required name="first_name" placeholder="First Name">
                                            </div>

                                            <div class="col-md-6 col-12 mb-20">
                                                <label>Last Name*</label>
                                                <input type="text" value="{{ $shippingAddress->last_name ?? '' }}"
                                                    required name="last_name" placeholder="Last Name">
                                            </div>

                                            <div class="col-md-6 col-12 mb-20">
                                                <label>Email Address*</label>
                                                <input type="email" value="{{ $shippingAddress->email ?? '' }}" required
                                                    data-rule-email="true" name="email" placeholder="Email Address">
                                            </div>

                                            <div class="col-md-6 col-12 mb-20">
                                                <label>Mobile no*</label>
                                                <input type="text" name="mobile"
                                                    value="{{ $shippingAddress->mobile ?? '' }}" minlength="10"
                                                    maxlength="10" data-rule-number="true" data-rule-required="true"
                                                    placeholder="Phone number">
                                            </div>


                                            <div class="col-12 mb-20">
                                                <label>Address*</label>
                                                <input required type="text"
                                                    value="{{ $shippingAddress->address_one ?? '' }}" name="address_one"
                                                    placeholder="Address line 1">
                                                <input type="text" name="address_two" placeholder="Address line 2"
                                                    value="{{ $shippingAddress->address_two ?? '' }}">
                                            </div>

                                            @php
                                                $countryList = App\Model\Country::get();
                                            @endphp
                                            <input type="hidden" name="country_url" id="country_url" value="{{ route('country.to.state') }}">
                                            <div class="col-md-6 col-12 mb-20">
                                                <label>Country*</label>
                                                <select class="nice-select" placeholder="Country" name="country"
                                                    style="display: none;" id="country">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countryList as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ isset($shippingAddress->country) && strtolower($shippingAddress->country) == strtolower($item->name) ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="billing-select-country"></div>
                                            </div>

                                            <div class="col-md-6 col-12 mb-20">
                                                <label>State*</label>
                                                <select class="nice-select state" required name="state" id="state"
                                                    style="display: none;">
                                                    <option value="">Select State</option>
                                                    {{-- @foreach ($stateList as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ isset($shippingAddress->state) && strtolower($shippingAddress->state) == strtolower($item->name) ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach --}}
                                                </select>
                                                <div class="select-state"></div>
                                            </div>

                                            <div class="col-md-6 col-12 mb-20">
                                                <label>Town/City*</label>
                                                <input type="text" name="city" value="{{ $shippingAddress->city ?? '' }}"
                                                    required placeholder="Town/City">
                                            </div>

                                            <div class="col-md-6 col-12 mb-20">
                                                <label>Zip Code*</label>
                                                <input type="text" name="postal_code"
                                                    value="{{ $shippingAddress->postal_code ?? '' }}" required
                                                    data-rule-number="true" placeholder="Zip Code">
                                            </div>



                                            <div class="col-12 mb-20">
                                                <div class="check-box">
                                                    <input type="checkbox"
                                                        {{ Session::has('different_billing_address') ? 'checked' : '' }}
                                                        name="different_billing_address" id="different_billing_address"
                                                        data-shipping="">
                                                    <label for="different_billing_address">Billing to Different
                                                        Address ?</label>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    @php
                                        $style = '';
                                        $sessionData = [];
                                        if (Session::has('different_billing_address')) {
                                            $style = 'display: block;';
                                            $sessionData = Session::get('different_billing_address');
                                        }
                                    @endphp
                                    <!-- Shipping Address -->
                                    <div id="shipping-form" class="mb-40" style="{{ $style }}">
                                        <h4 class="checkout-title">Billing Address</h4>
                                        <div class="row">

                                            <div class="col-md-6 col-12 mb-20">
                                                <label>First Name*</label>
                                                <input type="text" value="{{ $sessionData['billing_first_name'] ?? '' }}"
                                                    data-rule-required="#different_billing_address:checked"
                                                    name="billing_first_name" placeholder="First Name">
                                            </div>

                                            <div class="col-md-6 col-12 mb-20">
                                                <label>Last Name*</label>
                                                <input type="text" value="{{ $sessionData['billing_last_name'] ?? '' }}"
                                                    data-rule-required="#different_billing_address:checked"
                                                    name="billing_last_name" placeholder="Last Name">
                                            </div>

                                            <div class="col-md-6 col-12 mb-20">
                                                <label>Email Address*</label>
                                                <input type="email" data-rule-required="#different_billing_address:checked"
                                                    value="{{ $sessionData['billing_email'] ?? '' }}"
                                                    data-rule-email="true" name="billing_email" placeholder="Email Address">
                                            </div>

                                            <div class="col-md-6 col-12 mb-20">
                                                <label>Mobile no*</label>
                                                <input type="text" name="billing_mobile" minlength="10"
                                                    value="{{ $sessionData['billing_mobile'] ?? '' }}" maxlength="10"
                                                    data-rule-required="#different_billing_address:checked"
                                                    data-rule-number="true" placeholder="Phone number">
                                            </div>


                                            <div class="col-12 mb-20">
                                                <label>Address*</label>
                                                <input data-rule-required="#different_billing_address:checked" type="text"
                                                    value="{{ $sessionData['billing_address_one'] ?? '' }}"
                                                    name="billing_address_one" placeholder="Address line 1">
                                                <input type="text"
                                                    value="{{ $sessionData['billing_address_two'] ?? '' }}"
                                                    name="billing_address_two" placeholder="Address line 2">
                                            </div>


                                            <div class="col-md-6 col-12 mb-20">
                                                <label>Country*</label>
                                                <select class="nice-select billing_country" placeholder="Country" name="billing_country"
                                                    style="display: none;" id="billing_country">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countryList as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ isset($sessionData['billing_country']) && $item->name == $sessionData['billing_country'] ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="billing-select-country"></div>
                                            </div>

                                            <div class="col-md-6 col-12 mb-20">
                                                <label>State*</label>
                                                <select class="nice-select billing_state" placeholder="State" name="billing_state"
                                                    style="display: none;" id="billing_state">
                                                    <option value="">Select State</option>
                                                    {{-- @foreach ($stateList as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ isset($sessionData['billing_state']) && $item->state == $sessionData['billing_state'] ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach --}}
                                                </select>
                                                <div class="billing-select-state"></div>
                                            </div>

                                            <div class="col-md-6 col-12 mb-20">
                                                <label>Town/City*</label>
                                                <input type="text" value="{{ $sessionData['billing_city'] ?? '' }}"
                                                    name="billing_city"
                                                    data-rule-required="#different_billing_address:checked"
                                                    placeholder="Town/City">
                                            </div>

                                            <div class="col-md-6 col-12 mb-20">
                                                <label>Zip Code*</label>
                                                <input type="text"
                                                    value="{{ $sessionData['billing_postal_code'] ?? '' }}"
                                                    name="billing_postal_code"
                                                    data-rule-required="#different_billing_address:checked"
                                                    data-rule-number="true" placeholder="Zip Code">
                                            </div>


                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-5">

                                    @include('livewire.cart',['carts' => $carts])

                                    @if ($payment_setting->cash == 'Yes' || $payment_setting->razorpay_enable == 'Yes')

                                        <!-- Payment Method -->
                                        <div class="col-12">

                                            <h4 class="checkout-title">Payment Method</h4>

                                            <div class="checkout-payment-method">
                                                @if ($payment_setting->cash == 'Yes')
                                                    <div class="single-method">
                                                        <input type="radio" data-rule-required="true" class="radio"
                                                            id="payment_cash" name="payment_method" value="cash">
                                                        <label for="payment_cash">Cash on Delivery</label>
                                                    </div>
                                                @endif

                                                @if ($payment_setting->razorpay_enable == 'Yes')
                                                    <div class="single-method">
                                                        <input type="radio" id="razorpay" data-rule-required="true"
                                                            class="radio" name="payment_method" value="razorpay">
                                                        <label for="razorpay"> Credit Card/Debit Card/NetBanking</label>
                                                    </div>
                                                @endif
                                                <div class="checkout-radio-error">

                                                </div>
                                            </div>

                                            <button type="submit" class="lezada-button lezada-button--medium mt-30">Place
                                                order</button>

                                        </div>


                                    @endif

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('front/assets/js/checkout.js') }}"></script>
@endpush

@push('script')

    <script>
        $(document).ready(function() {
            $('.lezada-button-code').on('click', function(e) {
                e.preventDefault();
                var el = $(this);
                var url = el.data('url')
                let code = $("#coupon_code").val();
                showLoader();

                $.ajax({
                    type: "POST",
                    url: url,
                    cache: false,
                    data: {
                        id: id,
                        code: code
                    }
                }).always(function(respons) {
                    stopLoader();

                }).done(function(respons) {

                    toast.fire({
                        type: 'success',
                        title: 'Success',
                        text: respons.message
                    });

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

        $('#country').on('change', function() {
            var country_code = $(this).val();
            var country_url = $('#country_url').val();

            $.post(country_url, {
                    _token: '{{ csrf_token() }}',
                    country_code: country_code
                },
                function(data) {
                    if (data.length != "") {
                        $('.state').html(null);
                        var html = "";
                        for (var i = 0; i < data.length; i++) {
                            html += '<option value="'+data.stateData[i].id+'">'+data.stateData[i].name+'</option>';
                        }
                        $('.state').html(html);
                        $('select.state').niceSelect();
                        $('select.state').niceSelect('update');

                    } else {
                        $('.state').html(null);
                    }
                });
        });

        $('#billing_country').on('change', function() {
            var country_code = $(this).val();
            var country_url = $('#country_url').val();

            $.post(country_url, {
                    _token: '{{ csrf_token() }}',
                    country_code: country_code
                },
                function(data) {
                    if (data.length != "") {
                        $('.billing_state').html(null);
                        var html = "";
                        for (var i = 0; i < data.length; i++) {
                            html += '<option value="'+data.stateData[i].id+'">'+data.stateData[i].name+'</option>';
                        }
                        $('.billing_state').html(html);
                        $('select.billing_state').niceSelect();
                        $('select.billing_state').niceSelect('update');

                    } else {
                        $('.billing_state').html(null);
                    }
                });
        });
    </script>
@endpush
