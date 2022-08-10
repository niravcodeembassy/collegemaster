<!DOCTYPE html>
<html class="h-full bg-grey-lighter">

<head>

  <meta charset="utf-8">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title> {{ env('APP_NAME') }} | @yield('title', $title ?? 'Admin')</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/backend-plugins.css') }}" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" rel="stylesheet">

  @stack('css')

  @stack('style')

  <style>
    .select2-container {
      width: 100% !important;
    }

    .badge.badge-pill.badge-secondary.mb-1,
    .badge.badge-pill.badge-success.m-auto.mb-1,
    .badge.badge-pill.badge-primary.m-auto.mb-1,
    .my-badge {
      padding: 7px 15px !important;
    }

    /* .dataTable thead.thead-dark {
            background-color: #82a4f3 !important;
        } */
    .ck-editor__editable {
      min-height: 300px;
    }

    .min .ck-editor__editable {
      min-height: 200px;
    }

    :not(.layout-fixed) .main-sidebar {
      height: inherit;
      min-height: 100%;
      position: absolute;
      top: 0;
      bottom: 0;
    }
  </style>
  @livewireStyles
</head>

<body class="sidebar-mini layout-navbar-fixed ">

  <div class="wrapper">

    <nav class="main-header navbar navbar-expand  navbar-white">
      <!-- Navbar -->
      @include('admin.layouts.nav')
      <!-- /.navbar -->
    </nav>


    <!-- Main Sidebar Container -->
    <aside class="main-sidebar  sidebar-dark-primary  elevation-4">
      @include('admin.layouts.mainaside')
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <div class="content">
        <div class="container-fluid p-4">
          @section('content')
          @show
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      @include('admin.layouts.aside')
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->

  </div>
  <!-- ./wrapper -->
  <div id="load-modal"></div>

  <script>
    window.Laravel = @json([
    'csrfToken' => csrf_token(),
])
  </script>

  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/datatables.js') }}"></script>
  <script src="{{ asset('js/backend-plugins.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.3.5/dist/alpine.min.js" defer></script>
  <script>
    $('[data-toggle="tooltip"]').tooltip();
    const message = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success shadow mr-3',
        cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
    })
    const toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
    });
    @if (Session::has('error'))
      toast.fire({
        type: 'error',
        title: 'Error',
        text: "{!! session('error') !!}"
      });
      @php session()->forget('error') @endphp
    @endif
    @if (Session::has('success'))
      toast.fire({
        type: 'success',
        title: 'Success',
        text: "{!! session('success') !!}"
      });
      @php
        session()->forget('success');
      @endphp
    @endif
  </script>

  @stack('js')

  @yield('modals') {{-- log viwer --}}

  @stack('scripts')

  @livewireScripts

</body>

</html>
