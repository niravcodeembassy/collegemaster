@extends('frontend.layouts.app')

@section('title', 'Order Chat')

@push('css')
  <link href="{{ asset('front/assets/css/chat.css') }}" rel="stylesheet">
@endpush

@section('content')

  {{-- <div class="breadcrumb-area pt-20 pb-20" style="background-color: #f5f5f5;">
    <div class="container wide">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="breadcrumb-title">{{ $title ?? '' }}</h1>
          <ul class="breadcrumb-list">
            <li class="breadcrumb-list__item"><a href="{{ route('front.home') }}">HOME</a></li>
            <li class="breadcrumb-list__item breadcrumb-list__item--active">{{ $title ?? '' }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div> --}}


  <section class="section-b-space">
    <div class="container wide">
      <div class="row mt-80 mb-80">
        <div class="col-lg-2">

          <div class="dashboard-left" style="left: 0px;">
            <div class="list-group">
              <span href="#" class="list-group-item " style="background: #333333; color:white;">
                My account
              </span>
              <a class="list-group-item @if (strtolower(\Request::route()->getName()) == 'profile.index') {{ 'active' }} @endif" href="{{ route('profile.index') }}"> <i class="fa fa-user"></i> Profile</a>
              <a class="list-group-item @if (strtolower(\Request::route()->getName()) == 'changepassword.get') {{ 'active' }} @endif" href="{{ route('changepassword.get') }}"> <i class="fa fa-lock"></i> Change Password</a>
              <a class="list-group-item @if (strtolower(\Request::route()->getName()) == 'orders.list') {{ 'active' }} @endif" href="{{ route('orders.list') }}"><i class="fa fa-truck"></i> Order</a>
              <a class="list-group-item @if (strtolower(\Request::route()->getName()) == 'wishlist.index') {{ 'active' }} @endif" href="{{ route('wishlist.index') }}"><i class="fa fa-list"></i> Wish List</a>
              <a class="list-group-item  @if (strtolower(\Request::route()->getName()) == 'order.chat') {{ 'active' }} @endif" wire:poll="mountComponent()" href="{{ route('order.chat') }}"><i class="fa fa-comments-o"></i>
                Order Chat @livewire('order-counter')
              </a>
              <a class="list-group-item @if (strtolower(\Request::route()->getName()) == 'logout') {{ 'active' }} @endif" href="{{ route('logout') }}"><i class="fa fa-power-off"></i> Logout</a>
            </div>
          </div>

        </div>
        <div class="col-lg-9 mt-sm-40 mt-md-40 mt-lg-0">
          @livewire('user-chat', ['messages' => $messages ?? null, 'orders' => $orders])
        </div>
      </div>
    </div>
  </section>
@endsection


@push('script')
  <script>
    window.addEventListener('send-message', event => {
      var objDiv = document.querySelector(".scroll_div");
      console.log(objDiv.scrollTop);
      objDiv.scrollTop = objDiv.scrollHeight;
    });

    window.addEventListener('get-user', event => {
      var objDiv = document.querySelector(".scroll_div");
      objDiv.scrollTop = objDiv.scrollHeight;
    });

    // function scroll() {
    //   var objDiv = document.querySelector(".scroll_div");
    //   objDiv.scrollTop = objDiv.scrollHeight;
    // }
  </script>
@endpush
