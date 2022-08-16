@extends('admin.layouts.app')


@section('title', $title)

@push('css')
  <link rel="stylesheet" href="{{ asset('css/style.bundle.css') }}">
  <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
@endpush

@push('style')
  <style>
    .chat_content {
      font-size: 0.85rem !important;
    }
  </style>
@endpush


@section('content')
  <div style="margin-top: 25px;">
    @component('component.heading',
        [
            'page_title' => 'Order Chat',
            'icon' => '',
            'action' => route('admin.home'),
            'action_icon' => 'fa fa-arrow-left',
            'text' => 'Back',
        ])
    @endcomponent

    <div class="row">
      <div class="col-lg-12">
        @livewire('message', ['messages' => $messages ?? null, 'orders' => $orders])
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    scroll();
    window.addEventListener('send-message', event => {
      scroll();
    });

    window.addEventListener('get-user', event => {
      scroll();
    });

    function scroll() {
      var objDiv = document.getElementById("scroll_body");
      objDiv.scrollTop = objDiv.scrollHeight;
    }
  </script>
@endpush
