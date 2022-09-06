@extends('frontend.layouts.app')

@section('content')
  <div class=" breadcrumb-area   pt-20 pb-20 mb-100" style="background-color: #f5f5f5;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="breadcrumb-title">Login Us</h1>
          <!--=======  breadcrumb list  =======-->
          <ul class="breadcrumb-list">
            <li class="breadcrumb-list__item"><a href="{{ url('/') }}">HOME</a></li>
            <li class="breadcrumb-list__item breadcrumb-list__item--active">Login</li>
          </ul>
          <!--=======  End of breadcrumb list  =======-->
        </div>
      </div>
    </div>
  </div>
  <div class="container signin-form">
    <div class=" justify-content-center mb-100">
      <div class="row">
        <div class="col-md-6 np">
          <div class=" lezada-form login-form">
            <div class="card-bodys">
              <form method="POST" action="{{ route('login') }}" autocomplete="off">

                @csrf

                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password" required>

                    @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                      <label class="form-check-label  remember-text" for="remember">
                        {{ __('Remember Me') }}
                      </label>
                    </div>
                  </div>

                  <div class="col-md-6">
                    @if (Route::has('password.request'))
                      <a class="reset-pass-link reset-pass-link mt-0" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                      </a>
                    @endif
                  </div>

                </div>

                <div class="form-group row mb-0">
                  <div class="col-md-12 ">
                    <button type="submit" class="lezada-button lezada-button--medium">
                      {{ __('Login') }}
                    </button>

                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-6 right-login">
          <h2 class="mb-3">New Customer</h2>
          <div class="theme-card authentication-right">
            <h5 class="title-font text-uppercase">Create An Account</h5>
            <p>Sign up for a free account at our store. Registration is quick and easy. It allows you to be able to order
              from our shop. To start shopping click register.</p>
            <a href="{{ route('register') }}" class="lezada-button lezada-button--medium">Sign Up</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
