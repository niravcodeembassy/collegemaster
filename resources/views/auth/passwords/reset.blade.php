@extends('frontend.layouts.app')

@section('content')
  <div class=" breadcrumb-area   pt-20 pb-20 mb-100" style="background-color: #f5f5f5;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="breadcrumb-title">{{ __('Reset Password') }}</h1>
          <!--=======  breadcrumb list  =======-->
          <ul class="breadcrumb-list">
            <li class="breadcrumb-list__item"><a href="{{ url('/') }}">HOME</a></li>
            <li class="breadcrumb-list__item breadcrumb-list__item--active">{{ __('Reset Password') }}</li>
          </ul>
          <!--=======  End of breadcrumb list  =======-->
        </div>
      </div>
    </div>
  </div>

  <div class="container pswd-reset">
    <div class=" justify-content-center mb-100">
      <div class="row">
        <div class="col-md-6">
          <div class=" lezada-form login-form">
            <div class="card-bodys">

              <h3>Reset Password</h3>
              <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group row">
                  <div class="col-md-12 mb-40">
                    <label for="email" class="">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>


                  <div class="col-md-12 mb-40">
                    <label for="password" class="">{{ __('Password') }}</label>
                    <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>



                  <div class="col-md-12 mb-40">
                    <label for="password-confirm" class="">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
                  </div>

                  <div class="col-md-12">
                    <button type="submit" class="lezada-button lezada-button--medium">
                      {{ __('Reset Password') }}
                    </button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>



  </div>
@endsection
