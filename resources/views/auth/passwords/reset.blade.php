@extends('frontend.layouts.app')

@push('css')
  <link href="{{ asset('front/assets/css/password.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('front/assets/css/auth.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
  <div class="bg-gray-200 min-vh-100">
    <div class="container">
      <div class="row">
        <div class="col-xl-5 col-lg-6 col-md-9 d-flex flex-column mx-auto">
          <div class="card z-index-0 mt-sm-12 mt-9 mb-4">
            <div class="card-header text-center pt-4 pb-1">
              <h4 class="font-weight-bolder mb-1">Change password</h4>
            </div>
            <div class="card-body">
              <form method="POST" class="password_form" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                @csrf
                <div class="mb-3">
                  <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="mb-3">
                  <input id="password" type="password" placeholder="Password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="mb-3">
                  <input id="password-confirm" class="form-control form-control-lg" type="password" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="text-center">
                  <button type="submit" class="auth_btn btn text-uppercase text-white bg-gradient-primary  w-100 my-2 mb-2">
                    Reset Password
                  </button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
