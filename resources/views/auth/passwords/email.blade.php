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

<div class="container forgot-pswd">
    <div class=" justify-content-center mb-100">
        <div class="row">
            <div class="col-md-6">
                <div class=" lezada-form login-form">
                    <div class="card-bodys">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h3>FORGOT YOUR PASSWORD</h3>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12 mb-40">
                                    <label for="email" class="">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class="col-md-12">
                                    <button type="submit"
                                        class="lezada-button lezada-button--medium">
                                        {{ __('Send Password Reset Link') }}
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
