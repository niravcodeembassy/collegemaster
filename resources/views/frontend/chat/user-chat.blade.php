@extends('frontend.layouts.app')

@section('title', 'Order Chat')

@push('css')
  <link href="{{ asset('front/assets/css/chat.css') }}" rel="stylesheet">
@endpush

@section('content')

  @include('frontend.layouts.banner', [
      'pageTitel' => $title ?? '',
  ])

  <section class="section-b-space">
    <div class="container ">
      <div class="row mt-80 mb-80">
        @include('frontend.dashboard.sidebar')
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
