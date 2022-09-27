@extends('frontend.layouts.app')

@push('css')
  <link href="{{ asset('front/assets/css/auth.css') }}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{ asset('front/assets/build/css/intlTelInput.css') }}">
@endpush


@section('content')
  <div class="auth-header min-vh-100">
    <div class="container">
      <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
          <div class="card auth_card card-plain">
            <div class="card-header pb-0 text-left">
              <h4 class="font-weight-bolder">Sign Up</h4>
              <p class="font-para mb-0 h6">Enter your email and password to register</p>
            </div>
            <div class="card-body pb-3">
              <form class="auth_form" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <label for="first_name">{{ __('First name') }}</label>
                    <div class="mb-3">
                      <input id="first_name" type="text" placeholder="First Name" class="form-control form-control-lg @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name"
                        autofocus>
                      @error('first_name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="last_name">{{ __('Last name') }}</label>
                    <div class="mb-3">
                      <input id="last_name" type="text" placeholder="Last Name" class="form-control form-control-lg @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name"
                        autofocus>
                      @error('last_name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-12">
                    <label for="email">{{ __('E-Mail') }}</label>
                    <div class="mb-3">
                      <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
                      @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-12 w-100">
                    <label for="mobile">{{ __('Mobile number') }}</label>
                    <div class="intel_input">
                      <input id="mobile" type="tel" placeholder="Mobile number" class="form-control  form-control-lg @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile"
                        style="background: none;">
                      <label id="mobile-error" class="error text-danger" for="phone"></label>
                      @error('mobile')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-12" style="margin-top:-5px">
                    <label for="password">{{ __('Password') }}</label>
                    <div class="mb-3">
                      <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="password">
                      @error('password')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-12">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    <div class="mb-3">
                      <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                    </div>
                  </div>
                </div>
                {!! app('captcha')->display() !!}
                <span class="captcha text-danger" style="display:none">This field is required.</span>
                <div class="text-center">
                  <button type="submit" class="auth_btn text-uppercase btn text-white bg-gradient-primary w-100 mt-4 mb-0">Sign up</button>
                </div>
              </form>
            </div>
            <div class="card-footer text-center pt-0 px-sm-4 px-1">
              <p class="mb-4 mx-auto">
                Already have an account?
                <a href="{{ route('login') }}" class="text-dark text-gradient font-weight-bold">Sign in</a>
              </p>
            </div>
          </div>
        </div>
        <div class="col-6 image_content d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
          <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center">
            <img src="{{ asset('front/assets/images/pattern-lines.svg') }}" alt="pattern-lines" class="position-absolute opacity-4 start-0">
            <div class="position-relative">
              <img class="max-width-500 w-100 position-relative z-index-2" src="{{ asset('front/assets/images/chat.png') }}" alt="image">
            </div>
            <div class="mx-auto text_content">
              <h4 class="text-white font-weight-bolder">Your journey starts here</h4>
              <p class="text-white">Just as it takes a company to sustain a product, it takes a community to sustain a protocol.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {!! NoCaptcha::renderJs() !!}
@endsection

@push('js')
  <script src="{{ asset('front/assets/js/checkout.js') }}"></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
  <script src="https://js.stripe.com/v3/"></script>


  <script src="{{ asset('front/assets/build/js/intlTelInput.min.js') }}"></script>

  <script>
    var input = document.querySelector("#mobile");
    window.intlTelInput(input, {
      formatOnDisplay: true,
      autoPlaceholder: "polite",
      initialDialCode: true,
      americaMode: false,
      preferredCountries: ["us"],
    });

    $('.iti__flag-container').click(function() {
      country();
    });

    $('form').on('submit', function(e) {
      if (grecaptcha.getResponse() == "") {
        e.preventDefault();
        $(".captcha").show();
      } else {
        $('form').submit();
      }
    });


    function country() {
      var countryCode = $('.iti__selected-flag').attr('title');
      var countryCode = countryCode.replace(/[^0-9]/g, '')
      $('#mobile').val("");
      $('#mobile').val("+" + countryCode + "" + $('#mobile').val());
    }

    $('#mobile').keyup(function() {
      var mobile_no = $(this).val();
      var regex = /^\+(?:[0-9] ?){6,14}[0-9]$/;
      if (regex.test(mobile_no)) {
        $('#mobile-error').text('');
        return true;
      } else {
        $('#mobile-error').text('Please Enter Valid Mobile No');
        return false;
      }
    });
  </script>
  <script src="{{ asset('front/assets/build/js/intlTelInput-jquery.min.js') }}"></script>
@endpush
