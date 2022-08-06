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
        <div class="col-lg-9">
          {{-- @livewire('user-chat', ['users' => $users, 'messages' => $messages ?? null, 'orders' => $orders ?? null]) --}}
          @livewire('user-chat')
        </div>
      </div>
    </div>
  </section>


@endsection


@push('script')
  <script>
    scroll();
    window.addEventListener('send-message', event => {
      scroll();
    });

    function scroll() {
      var objDiv = document.getElementById("scroll_body");
      objDiv.scrollTop = objDiv.scrollHeight;
    }
  </script>
@endpush
