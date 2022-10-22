@extends('frontend.layouts.app')

@push('css')
  <link href="{{ asset('front/assets/css/password.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('front/assets/css/auth.css') }}" rel="stylesheet" type="text/css" />
@endpush

@php
  $title = 'Verify Email';
@endphp
@section('title')
  {{ $title }}
@endsection

@section('content')
  <div class="bg-gray-200 min-vh-100">
    <div class="container">
      <div class="row">
        <div class="col-xl-5 col-lg-6 col-md-9 d-flex flex-column mx-auto">
          <div class="card z-index-0 mt-sm-12 mt-9 mb-4">
            <div class="card-header text-center pt-4 pb-1">
              <h4 class="font-weight-bolder mb-1">{{ __('Verify Your Email Address') }}</h4>
            </div>

            <div class="card-body">
              @if (session('resent'))
                <div class="alert alert-success" role="alert">
                  {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
              @endif

              {{ __('Before proceeding, please check your email for a verification link.') }}
              {{ __('If you did not receive the email') }},
              <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="auth_btn btn text-uppercase text-white bg-gradient-primary  w-100 my-2 mb-2">
                  {{ __('click here to request another') }}
                </button>
              </form>
            </div>


          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
