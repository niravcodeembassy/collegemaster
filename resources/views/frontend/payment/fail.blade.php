@extends('frontend.layouts.app')
@section('content')
<div class="nothing-found-area ">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="nothing-found-content">
                    <h2 class="text-danger">Oops Somethings went to wrong ????</h2>
                    <p class="direction-page text-center">Your Transaction Fail. <br> <br> <a href="{{ route('cart.view') }}">Go to cart</a> </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
