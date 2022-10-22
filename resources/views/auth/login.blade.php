@extends('frontend.layouts.app')

@push('css')
  <link href="{{ asset('front/assets/css/auth.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title')
  {{$title}}
@endsection

@section('content')
  <div class="auth-header min-vh-100">
    <div class="container">
      <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
          <div class="card auth_card card-plain">
            <div class="card-header pb-0 text-left">
              <h4 class="font-weight-bolder">Sign In</h4>
              <p class="font-para mb-0 h6">Enter your email and password to sign in</p>
            </div>
            <div class="card-body">
              <form class="auth_form" method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf
                <label for="email">{{ __('E-Mail') }}</label>
                <div class="mb-3">
                  <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="Email" aria-label="Email">
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <label>{{ __('Password') }}</label>
                <div class="mb-3">
                  <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autofocus placeholder="Password" aria-label="Password">
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="d-md-flex justify-content-md-between">
                  {{-- <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label  remember-text" for="remember">
                      {{ __('Remember Me') }}
                    </label>
                  </div> --}}
                  <div>
                    <label class="switch">
                      <input type="checkbox" name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                      <span class="slider round"></span>
                    </label>
                    <label class="form-check-label"> {{ __('Remember Me') }}</span>
                  </div>


                  @if (Route::has('password.request'))
                    <a class="text-muted forgot_pwd" href="{{ route('password.request') }}">
                      {{ __('Forgot Your Password?') }}
                    </a>
                  @endif
                </div>

                <div class="text-center">
                  <button type="submit" class="auth_btn btn text-uppercase text-white bg-gradient-primary  w-100 mt-4 mb-0">
                    Sign in
                  </button>
                </div>
              </form>
            </div>
            <div class="card-footer text-center pt-0 px-lg-2 px-1">
              <p class="mb-4 text-sm mx-auto">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-dark text-gradient font-weight-bold">Sign up</a>
              </p>
            </div>
          </div>
        </div>
        <div class="col-6 image_content d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
          <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center">
            <img src="{{ asset('front/assets/images/pattern-lines.svg') }}" alt="pattern-lines" title="pattern-lines" class="position-absolute opacity-4 start-0">
            <div class="position-relative">
              <img class="max-width-500 w-100 position-relative z-index-2" src="{{ asset('front/assets/images/chat.png') }}" alt="image" title="image">
            </div>
            <div class="mx-auto text_content">
              <h4 class="text-white font-weight-bolder">"Attention is the new currency"</h4>
              <p class="text-white">The more effortless the writing looks, the more effort the writer actually put into the process.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
