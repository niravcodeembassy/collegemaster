@extends('frontend.layouts.app')
@section('title','Thahank you')
@section('content')
<div class="nothing-found-area bg-404">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="nothing-found-content">
                    <h2>Hi {{ ucfirst(Auth::user()->name) }}, Your Order Successfully Placed & Your Order No. is
                        {{ $order->order_number ?? '' }}.</h2>
                    <p class="direction-page mt-20">Keep Shopping <a href="/">homepage</a> <a href="{{ route('orders.list') }}">Go to Order History</a> </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
