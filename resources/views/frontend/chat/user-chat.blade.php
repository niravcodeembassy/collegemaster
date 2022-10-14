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
      <div class="row mt-lg-80 mt-20 mb-80">
        @include('frontend.dashboard.sidebar', ['class' => 'col-lg-2'])
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
