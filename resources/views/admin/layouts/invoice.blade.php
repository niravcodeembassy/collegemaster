<!DOCTYPE html>
<html class="h-full bg-grey-lighter">

<head>

    <meta charset="utf-8">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('/css/backend-plugins.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" rel="stylesheet">

    @stack('css')

    @stack('style')


</head>

    <body class="">
        @section('content')
        @show
    </div>
    <!-- ./wrapper -->
    @stack('js')

    @yield('modals') {{-- log viwer --}}

    @stack('scripts')

</body>

</html>
