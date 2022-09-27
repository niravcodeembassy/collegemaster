@extends('frontend.layouts.app')

@push('css')
  <link href="{{ asset('front/assets/css/password.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('front/assets/css/auth.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
  <div class="min-vh-100 bg-gray-200">
    <div class="container">
      <div class="row">
        <div class="col-xl-5 col-lg-6 col-md-9 d-flex flex-column mx-auto">
          <div class="card z-index-0 mt-sm-12 mt-9 mb-4">
            <div class="card-header text-center pt-4 pb-1">
              <h4 class="font-weight-bolder mb-1">Reset password</h4>
              <p class="mb-0 font-para">You will receive an e-mail in maximum 60 seconds</p>
            </div>
            <div class="card-body">

              @if (session('status'))
                <div class="alert alert-success" role="alert">
                  {{ session('status') }}
                </div>
              @endif

              <form method="POST" class="password_form" action="{{ route('password.email') }}" id="forgotpassword">
                @csrf
                <div class="mb-3">
                  <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Email" aria-label="Email" name="email" value="{{ old('email') }}" required>
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="text-center">
                  <button type="submit" class="auth_btn btn text-uppercase text-white bg-gradient-primary  w-100 my-2 mb-2">
                    Send
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
