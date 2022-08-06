@extends('admin.layouts.app')


@section('title', $title)


@push('css')
  <link rel="stylesheet" href="{{ asset('css/style.bundle.css') }}">
  <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
@endpush
@section('content')

  <div class="row">
    <div class="col-lg-12">
      @livewire('message', ['users' => $users, 'messages' => $messages ?? null, 'orders' => $orders])
    </div>
  </div>
@endsection

@push('js')
  <script src="{{ asset('js/scripts.bundle.js') }}"></script>
@endpush

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
