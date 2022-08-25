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
            <form method="post" class="checkout-form" id="checkout">
              @csrf
              <div class="row row-40">

                <div class="col-lg-7 mb-20">

                  <!-- Billing Address -->
                  <div id="billing-form" class="mb-40">
                    <h4 class="checkout-title">Shipping Address</h4>

                    <div class="row">

                      <div class="col-md-6 col-12 mb-20">
                        <label>First Name*</label>
                        <input type="text" value="{{ $shippingAddress->first_name ?? '' }}" required name="first_name" placeholder="First Name">
                      </div>

                      <div class="col-md-6 col-12 mb-20">
                        <label>Last Name*</label>
                        <input type="text" value="{{ $shippingAddress->last_name ?? '' }}" required name="last_name" placeholder="Last Name">
                      </div>

                      <div class="col-md-6 col-12 mb-20">
                        <label>Email Address*</label>
                        <input type="email" value="{{ $shippingAddress->email ?? '' }}" required data-rule-email="true" name="email" placeholder="Email Address">
                      </div>

                      <div class="col-md-6 col-12 mb-20 mobile_input">
                        <label for="telephone">Mobile no*</label>
                        <input type="tel" placeholder="Phone number" value="{{ $shippingAddress->mobile ?? '' }}" name="mobile" id="telephone" style="padding-left: 53px;" data-rule-required="true" required>
                        <label id="telephone-error" class="error text-danger" for="telephone"></label>

                      </div>


                      <div class="col-12 mb-20">
                        <label>Address*</label>
                        <input required type="text" value="{{ $shippingAddress->address_one ?? '' }}" name="address_one" placeholder="Address line 1">
                        <input type="text" name="address_two" placeholder="Address line 2" value="{{ $shippingAddress->address_two ?? '' }}">
                      </div>

                      @php
                        $countryList = App\Model\Country::get();
                      @endphp
                      <input type="hidden" name="country_url" id="country_url" value="{{ route('country.to.state') }}">
                      <div class="col-md-6 col-12 mb-20">
                        <label>Country*</label>
                        <select class="nice-select" placeholder="Country" name="country" style="display: none;" id="country">
                          <option value="">Select Country</option>
                          @foreach ($countryList as $item)
                            <option value="{{ $item->id }}" {{ isset($shippingAddress->country) && strtolower($shippingAddress->country) == strtolower($item->name) ? 'selected' : '' }}>
                              {{ $item->name }}</option>
                          @endforeach
                        </select>
                        <div class="billing-select-country"></div>
                      </div>

                      <div class="col-md-6 col-12 mb-20">
                        <input type="hidden" name="old_state" id="old_state" value="{{ isset($shippingAddress->state) && $shippingAddress->state != '' ? strtolower($shippingAddress->state) : '' }}">
                        <label>State*</label>
                        <select class="nice-select state" required name="state" id="state" style="display: none;">
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
                        <input type="text" name="city" value="{{ $shippingAddress->city ?? '' }}" required placeholder="Town/City">
                      </div>

                      <div class="col-md-6 col-12 mb-20">
                        <label>Zip Code*</label>
                        <input type="text" name="postal_code" value="{{ $shippingAddress->postal_code ?? '' }}" required placeholder="Zip Code">
                      </div>



                      <div class="col-12 mb-20">
                        <div class="check-box">
                          <input type="checkbox" {{ Session::has('different_billing_address') ? 'checked' : '' }} name="different_billing_address" id="different_billing_address" data-shipping="">
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
                        <input type="text" value="{{ $sessionData['billing_first_name'] ?? '' }}" data-rule-required="#different_billing_address:checked" name="billing_first_name" placeholder="First Name">
                      </div>

                      <div class="col-md-6 col-12 mb-20">
                        <label>Last Name*</label>
                        <input type="text" value="{{ $sessionData['billing_last_name'] ?? '' }}" data-rule-required="#different_billing_address:checked" name="billing_last_name" placeholder="Last Name">
                      </div>

                      <div class="col-md-6 col-12 mb-20">
                        <label>Email Address*</label>
                        <input type="email" data-rule-required="#different_billing_address:checked" value="{{ $sessionData['billing_email'] ?? '' }}" data-rule-email="true" name="billing_email" placeholder="Email Address">
                      </div>

                      <div class="col-md-6 col-12 mb-20 billing_input">
                        <label for="billing_mobile">Mobile no*</label>
                        <input type="tel" placeholder="Phone number" value="{{ $sessionData['billing_mobile'] ?? '' }}" name="billing_mobile" id="billing_mobile" data-rule-required="true"
                          data-rule-required="#different_billing_address:checked" required pattern="^([0|\+[0-9]{1,5})?([7-9][0-9]{9})$" data-msg-required="Mobile no is required" data-rule-mobileUK="true"
                          style="padding-left:73px!important;padding:10px">
                        <label id="billing_mobile-error" class="error text-danger" for="billing_mobile"></label>


                      </div>


                      <div class="col-12 mb-20">
                        <label>Address*</label>
                        <input data-rule-required="#different_billing_address:checked" type="text" value="{{ $sessionData['billing_address_one'] ?? '' }}" name="billing_address_one" placeholder="Address line 1">
                        <input type="text" value="{{ $sessionData['billing_address_two'] ?? '' }}" name="billing_address_two" placeholder="Address line 2">
                      </div>


                      <div class="col-md-6 col-12 mb-20">
                        <label>Country*</label>
                        <select class="nice-select billing_country" placeholder="Country" name="billing_country" style="display: none;" id="billing_country">
                          <option value="">Select Country</option>
                          @foreach ($countryList as $item)
                            <option value="{{ $item->id }}" {{ isset($sessionData['billing_country']) && $item->name == $sessionData['billing_country'] ? 'selected' : '' }}>
                              {{ $item->name }}</option>
                          @endforeach
                        </select>
                        <div class="billing-select-country"></div>
                      </div>

                      <div class="col-md-6 col-12 mb-20">
                        <input type="hidden" name="old_billing_state" id="old_billing_state" value="{{ isset($sessionData['billing_state']) && $sessionData['billing_state'] != '' ? strtolower($sessionData['billing_state']) : '' }}">
                        <label>State*</label>
                        <select class="nice-select billing_state" placeholder="State" name="billing_state" style="display: none;" id="billing_state">
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
                        <input type="text" value="{{ $sessionData['billing_city'] ?? '' }}" name="billing_city" data-rule-required="#different_billing_address:checked" placeholder="Town/City">
                      </div>

                      <div class="col-md-6 col-12 mb-20">
                        <label>Zip Code*</label>
                        <input type="text" value="{{ $sessionData['billing_postal_code'] ?? '' }}" name="billing_postal_code" data-rule-required="#different_billing_address:checked" placeholder="Zip Code">
                      </div>


                    </div>

                  </div>

                </div>

                <div class="col-lg-5">

                  @include('livewire.cart', ['carts' => $carts])

                  @if ($payment_setting->cash == 'Yes' || $payment_setting->stripe_enable == 'Yes')
                    <!-- Payment Method -->
                    <div class="col-12">

                      <h4 class="checkout-title">Payment Method</h4>

                      <div class="checkout-payment-method">
                        @if ($payment_setting->cash == 'Yes')
                          <div class="single-method">
                            <input type="radio" data-rule-required="true" class="radio" id="payment_cash" name="payment_method" value="cash">
                            <label for="payment_cash">Cash on Delivery</label>
                          </div>
                        @endif

                        @if ($payment_setting->stripe_enable == 'Yes')
                          <div class="single-method">
                            <input type="radio" id="stripe" data-rule-required="true" class="radio" name="payment_method" value="stripe">
                            <label for="stripe"> Credit Card/Debit Card/NetBanking <br>
                              <br>
                              <img src="{{ asset('storage\payment_icon\payment.png') }}" alt="master-card" style="width:312px">
                            </label>
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
  <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
  <script src="https://js.stripe.com/v3/"></script>

  <link rel="stylesheet" href="{{ asset('front/assets/build/css/intlTelInput.css') }}">
  <script src="{{ asset('front/assets/build/js/intlTelInput.min.js') }}"></script>

  <script>
    var input = document.querySelector("#telephone");
    window.intlTelInput(input, {
      formatOnDisplay: false,
      autoPlaceholder: "polite",
      initialDialCode: true,
      americaMode: false,
      preferredCountries: ["us"],
    });

    var data = document.querySelector("#billing_mobile");
    window.intlTelInput(data, {
      formatOnDisplay: false,
      autoPlaceholder: "polite",
      initialDialCode: true,
      americaMode: false,
      preferredCountries: ["us"],
    });

    $('.mobile_input .iti__flag-container').click(function() {
      var countryCode = $('.mobile_input .iti__selected-flag').attr('title');
      var countryCode = countryCode.replace(/[^0-9]/g, '')
      $('#telephone').val("");
      $('#telephone').val("+" + countryCode + "" + $('#telephone').val());
    });

    $('.billing_input .iti__flag-container').click(function() {
      var countryCode = $('.billing_input .iti__selected-flag').attr('title');
      var countryCode = countryCode.replace(/[^0-9]/g, '')
      $('#billing_mobile').val("");
      $('#billing_mobile').val("+" + countryCode + "" + $('#billing_mobile').val());
    });





    $('#billing_mobile').keyup(function() {
      var mobile_no = $(this).val();
      var regex = /^\+(?:[0-9] ?){6,14}[0-9]$/;
      if (regex.test(mobile_no)) {
        $('#billing_mobile-error').text('');
        return true;
      } else {
        $('#billing_mobile-error').text('Please Enter Valid Mobile No');
        return false;
      }
    });

    $('#telephone').keyup(function() {
      var mobile_no = $(this).val();
      var regex = /^\+(?:[0-9] ?){6,14}[0-9]$/;
      if (regex.test(mobile_no)) {
        $('#phone-error').text('');
        return true;
      } else {
        $('#phone-error').text('Please Enter Valid Mobile No');
        return false;
      }
    });
  </script>
  <script src="{{ asset('front/assets/build/js/intlTelInput-jquery.min.js') }}"></script>
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
            text: data.message ? data.message : 'something went wrong please try again !'
          });
        });

      });
    });

    $(document).ready(function() {
      var country_code = $('#country').val();
      var country_url = $('#country_url').val();

      get_state(country_code, country_url)

    });

    $('#country').on('change', function() {
      var country_code = $(this).val();
      var country_url = $('#country_url').val();

      get_state(country_code, country_url)

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

            var old_billing_state = $('#old_billing_state').val();

            var html = "";
            for (var i = 0; i < data.length; i++) {

              var state_name = data.stateData[i].name.toLowerCase();
              if (state_name == old_billing_state) {
                var var_selected = "selected";
              } else {
                var var_selected = "";
              }
              html += '<option value="' + data.stateData[i].id + '" ' + var_selected + '>' + data
                .stateData[i].name + '</option>';


              // html += '<option>' + data.stateData[i].name + '</option>';
            }
            $('.billing_state').html(html);
            $('select.billing_state').niceSelect();
            $('select.billing_state').niceSelect('update');

          } else {
            $('.billing_state').html(null);
          }
        });
    });

    function get_state(country_code, country_url) {
      $.post(country_url, {
          _token: '{{ csrf_token() }}',
          country_code: country_code
        },
        function(data) {
          if (data.length != "") {
            $('.state').html(null);

            var old_state = $('#old_state').val();

            var html = "";
            for (var i = 0; i < data.length; i++) {
              var state_name = data.stateData[i].name.toLowerCase();
              if (state_name == old_state) {
                var var_selected = "selected";
              } else {
                var var_selected = "";
              }
              html += '<option value="' + data.stateData[i].id + '" ' + var_selected + '>' + data
                .stateData[i].name + '</option>';
            }

            $('.state').html(html);
            $('select.state').niceSelect();
            $('select.state').niceSelect('update');

          } else {
            $('.state').html(null);
          }
        });
    }
  </script>

  <script type="text/javascript">
    $('#checkout').on('submit', function(e) {
      $(this).validate({
        debug: false,
        ignore: '.nice-select-search,.select2-search__field,:hidden:not("textarea,.files,.radio,#state,#billing_state")',
        rules: {
          billing_state: {
            required: function(element) {
              return $("#different_billing_address").is(":checked");
            }
          }
        },
        errorPlacement: function(error, element) {
          console.log(error, element, $(element).hasClass('.radio'));
          if ($(element).hasClass('radio')) {
            error.appendTo($('.checkout-radio-error')).addClass('text-danger');
          } else if ($(element).is('#state')) {
            error.appendTo($('.select-state').html('')).addClass('text-danger');
          } else if ($(element).is('#billing_state')) {
            error.appendTo($('.billing-select-state').html('')).addClass('text-danger');
          } else {
            error.appendTo(element.parent()).addClass('text-danger');
          }
        },
        submitHandler: function(e) {
          return true;
        }
      });
      e.preventDefault();
      var formData = new FormData(this);
      // showLoader();

      $.ajax({
        url: '{{ route('checkout.post') }}',
        type: 'POST',
        data: formData,
        headers: {
          'X-CSRF-Token': '{{ csrf_token() }}',
        },
        dataType: 'JSON',
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {

          if (response.status == "success") {
            if (response.payment_method == "cash") {
              return window.location.href = response.url;
            }
            var url = '{{ route('stripe.post') }}';
            var order_id = response.order_id;
            let user = {
              order_id: order_id
            };
            var stripe_key = '{{ config('app.stripe.stripe_key') }}';
            var stripe = Stripe(
              stripe_key
            );

            fetch(url, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json;charset=utf-8',
                  'X-CSRF-Token': '{{ csrf_token() }}',
                },
                body: JSON.stringify(user)
              })
              .then(function(response) {
                // stopLoader();
                return response.json();
              })
              .then(function(session) {
                // stopLoader();
                return stripe.redirectToCheckout({
                  sessionId: session.id
                });
              })
              .then(function(result) {
                stopLoader();
                if (result.error) {
                  alert(result.error.message);
                }
              })
              .catch(function(error) {
                stopLoader();
                console.error("Error:", error);
              });
          }
          if (response.status == "error") {
            stopLoader();
            alert('Payment Fail');
          }
        }
      });

    });
  </script>
@endpush
