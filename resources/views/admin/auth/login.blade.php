@extends('admin.layouts.auth')

@section('content')

<div class="container vh-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-4">
            <div class="justify-content-center d-flex">
                <div class="">
                    <img
                    class="mb-5"
                    src="{{ asset('storage/'.$frontsetting->logo) }}"
                    style="width: 90%;"
                    srcset="">
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="text-left">{{ __('Login') }}</h5>
                    <hr style="margin-right: -15px;margin-left: -15px;">

                    <form method="POST" action="{{ route('admin.login') }}" aria-label="{{ __('Login') }}">

                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-12 col-form-label ">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-12 col-form-label ">{{ __('Password') }}</label>
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
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

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 ">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('admin.password.request'))
                                    <a class="btn btn-link float-right" href="{{ route('admin.password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
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
