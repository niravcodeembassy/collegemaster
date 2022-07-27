@extends('frontend.layouts.app')

@section('content')
<div class=" breadcrumb-area   pt-20 pb-20 mb-100" style="background-color: #f5f5f5;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="breadcrumb-title">Register</h1>

                <!--=======  breadcrumb list  =======-->

                <ul class="breadcrumb-list">
                    <li class="breadcrumb-list__item"><a href="{{ url('/') }}">HOME</a></li>
                    <li class="breadcrumb-list__item breadcrumb-list__item--active">Register</li>
                </ul>

                <!--=======  End of breadcrumb list  =======-->

            </div>
        </div>
    </div>
</div>
<div class="container register-form">
    <div class=" justify-content-center mb-100">
        <div class="col-md-6">
            <div class=" lezada-form login-form">
                <div class="card-bodys">
                  <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md-12">
                                <label for="first_name" >{{ __('First name') }}</label>
                                <input id="first_name" type="text" class=" @error('first_name') is-invalid @enderror" name="first_name"
                                    value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-md-12">
                                <label for="last_name" >{{ __('Last name') }}</label>
                                <input id="last_name" type="text" class=" @error('last_name') is-invalid @enderror" name="last_name"
                                    value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-12">
                                <label for="email" >{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class=" @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">

                            <div class="col-md-12">
                                <label for="mobile" >{{ __('Mobile number') }}</label>
                                <input id="mobile" type="tel" placeholder="Mobile number" class=" @error('mobile') is-invalid @enderror" name="mobile"
                                    value="{{ old('mobile') }}" required autocomplete="mobile" style="background: none;padding-left:72px!important">

                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong id="mobile-error">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-12">
                                <label for="password" >{{ __('Password') }}</label>
                                <input id="password" type="password" class=" @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="password-confirm" >{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="" name="password_confirmation" required
                                    autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="lezada-button lezada-button--medium">
                                    {{ __('Register') }}
                                </button>
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
        var input = document.querySelector("#mobile");
        window.intlTelInput(input, {
            formatOnDisplay: true,
            autoPlaceholder: "polite",
            initialDialCode: true,
            americaMode: false,
            preferredCountries: ["us"],
        });

        $('#mobile').keyup(function(){
            var mobile_no = $(this).val();
            var regex = /^\+(?:[0-9] ?){6,14}[0-9]$/;
            if(regex.test(mobile_no)){
                $('#mobile-error').text('');
                return true;
            }else{
                $('#mobile-error').text('Please Enter Valid Mobile No');
                return false;
            }
        });

        
    </script>
    <script src="{{ asset('front/assets/build/js/intlTelInput-jquery.min.js') }}"></script>

    @endpush
