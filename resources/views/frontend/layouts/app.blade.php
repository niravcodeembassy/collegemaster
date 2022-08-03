<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> {{ env('APP_NAME') }} | @yield('title', $title ?? 'Home')</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Favicon -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('storage/' . $frontsetting->favicon) }}" type="png">

  {{-- seo meta tag --}}
  <meta name="title" content="@yield('title', $frontsetting->meta_title)">
  <meta name="description" content="@yield('description', $frontsetting->meta_description)">
  <meta name="keywords" content="@yield('keywords', $frontsetting->meta_keywords)">
  <meta property='article:published_time' content="@yield('published_time', now())">

  <meta property='og:type' content="website">
  <meta property='og:description' content="@yield('og-description', $frontsetting->meta_description)">
  <meta property='og:title' content="@yield('og-title', $frontsetting->meta_title)">
  <meta property='og:url' content="@yield('og-url', url()->current())">
  <meta property='og:image' itemprop="image" content="@yield('og-image', asset('storage/' . $frontsetting->logo))">

  <meta name="twitter:card" content="@yield('twitter-card', 'Property')">
  <meta name="twitter:title" content="@yield('twitter-title', $frontsetting->meta_title)">
  <meta name="twitter:description" content="@yield('twitter-description', $frontsetting->meta_description)">
  <meta name="twitter:image" content="@yield('twitter-image', asset('storage/' . $frontsetting->logo))">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-CE3412SH9L"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-CE3412SH9L');
  </script>

  @yield('meta')

  <!-- CSS
         ============================================ -->
  <!-- Bootstrap CSS -->
  <link href="{{ asset('front/assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- FontAwesome CSS -->
  <link href="{{ asset('front/assets/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- Ionicons CSS -->
  <link href="{{ asset('front/assets/css/ionicons.min.css') }}" rel="stylesheet">
  <!-- Themify CSS -->
  <link href="{{ asset('front/assets/css/themify-icons.css') }}" rel="stylesheet">
  <!-- Plugins CSS -->
  <link href="{{ asset('front/assets/css/plugins.css') }}" rel="stylesheet">
  <!-- Helper CSS -->
  <link href="{{ asset('front/assets/css/helper.css') }}" rel="stylesheet">
  <!-- Main CSS -->
  <link href="{{ asset('front/assets/css/main.css') }}" rel="stylesheet">
  <link href="{{ asset('front/assets/css/footer.css') }}" rel="stylesheet">

  <!-- Responsive D CSS -->
  <link href="{{ asset('front/assets/css/responsive.css') }}?v=<?= rand() ?>" rel="stylesheet">

  <!-- Revolution Slider CSS -->
  <link href="{{ asset('front/assets/revolution/css/settings.css') }}" rel="stylesheet">
  <link href="{{ asset('front/assets/revolution/css/navigation.css') }}" rel="stylesheet">
  <link href="{{ asset('front/assets/revolution/custom-setting.css') }}" rel="stylesheet">

  <!-- Modernizer JS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" rel="stylesheet" />

  <script src="{{ asset('front/assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>

  <style>
    /* the slides */
    .slick-slide {
      margin: 0 10px;
    }

    /* the parent */
    .slick-list {
      margin: 0 -10px;
    }

    .lds-ellipsis {
      display: inline-block;
      position: relative;
      width: 64px;
      height: 64px;
    }

    .error.text-danger {
      font-size: 12px;
    }

    .sidebar-btn .dark-light {
      display: none !important;
    }


    .lds-ellipsis div {
      position: absolute;
      top: 27px;
      width: 11px;
      height: 11px;
      border-radius: 50%;
      background: orange;
      animation-timing-function: cubic-bezier(0, 1, 1, 0);
    }

    .lds-ellipsis div:nth-child(1) {
      left: 6px;
      animation: lds-ellipsis1 0.6s infinite;
    }

    .lds-ellipsis div:nth-child(2) {
      left: 6px;
      animation: lds-ellipsis2 0.6s infinite;
    }

    .lds-ellipsis div:nth-child(3) {
      left: 26px;
      animation: lds-ellipsis2 0.6s infinite;
    }

    .lds-ellipsis div:nth-child(4) {
      left: 45px;
      animation: lds-ellipsis3 0.6s infinite;
    }

    @keyframes lds-ellipsis1 {
      0% {
        transform: scale(0);
      }

      100% {
        transform: scale(1);
      }
    }

    @keyframes lds-ellipsis3 {
      0% {
        transform: scale(1);
      }

      100% {
        transform: scale(0);
      }
    }

    @keyframes lds-ellipsis2 {
      0% {
        transform: translate(0, 0);
      }

      100% {
        transform: translate(19px, 0);
      }
    }

    .offcanvas-cart-content-container .cart-product-wrapper .cart-product-container .single-cart-product .content h5 {
      font-size: 15px;
      line-height: 17px;
      width: 225px;
    }

    .shop-product__small-image-gallery-slider .slick-track {
      margin-left: 0;
      margin-right: 0;
    }

    .checkout-form .nice-select .list {
      width: 100%;
      height: 250px;
      overflow-y: scroll;
    }

    .breadcrumb-title {
      font-size: 22px;
      line-height: 0.8 !important;
      color: #333333 !important;
      margin-bottom: 6px !important;
    }

    .signup-form input[type=submit] {
      background: url('{{ asset('front/assets/images/payment/telegram-plane.svg') }}');
      background-repeat: no-repeat;
      width: 35px;
      height: 30px;
      position: absolute;
      right: 5px;
      top: 50%;
      transform: translateY(-50%);
      border: none;
      font-size: 0;
      padding: 0
    }

    /* //header css */
    .search_form_mobile {
      position: relative;
      width: 100% !important;
    }

    .search_form {
      width: 70% !important;
      position: relative;
    }

    .search_form input {
      border-radius: 96px;
      padding: 20px;
      border: 2px solid black;
    }

    .search_form_mobile input {
      border-radius: 96px;
      padding: 10px;
      border: 2px solid black;
    }


    .search_form button,
    .search_form_mobile button {
      font-size: 25px;
      position: absolute;
      top: 50%;
      right: 0px;
      padding: 0px 10px;
      -webkit-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
      color: #cccccc;
      border: none;
      background: none;
    }

    nav.site-nav>ul>li {
      line-height: 35px;
    }

    nav.site-nav>ul>li>a:after {
      bottom: 0px;
    }

    .about-overlay .overlay-content {
      width: 290px;
      padding: 55px 20px;
    }

    a.login_link:hover {
      color: black;
    }

    @media only screen and (min-width: 768px) and (max-width: 991px) {
      .header-right-icons {
        float: right;
      }

      .header-bottom-container .header-right-container {
        flex-basis: 60%;
      }
    }

    @media only screen and (max-width: 767px) {
      .header-bottom-container .header-right-container {
        flex-basis: 72%;
      }
    }

    @media only screen and (max-width: 479px) {
      .header-right-icons .single-icon {
        margin-left: 8px;
      }

      .header-right-icons {
        float: right;
      }
    }
  </style>

  @stack('css')

  @stack('style')

  @livewireStyles

</head>

<body>
  {{-- <link itemprop="thumbnailUrl" href="@yield('og-image', asset('storage/' . $frontsetting->logo))"> --}}
  <!--=============================================
         =            Header without topbar         =
         =============================================-->
  @include('frontend.layouts.header')
  <!--===== End of Header without topbar ======-->
  @section('content')
  @show

  @include('frontend.layouts.footer')

  <!-- scroll to top  -->
  {{-- <a href="#" class="scroll-top"></a> --}}
  <!-- end of scroll to top -->
  <!-- JS
         ============================================ -->
  <!-- jQuery JS -->
  <script src="{{ asset('front/assets/js/vendor/jquery.min.js') }}"></script>
  <!-- Popper JS -->
  <script src="{{ asset('front/assets/js/popper.min.js') }}"></script>
  <!-- Bootstrap JS -->
  <script src="{{ asset('front/assets/js/bootstrap.min.js') }}"></script>
  <!-- Plugins JS -->
  <script src="{{ asset('front/assets/js/plugins.js') }}"></script>
  <!-- Main JS -->
  <script src="{{ asset('front/assets/js/main.js') }}"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.js"></script>

  <script src="{{ asset('front/assets/js/productdetails.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

  <script>
    var lodingImage = '<div class="lds-ellipsis"> <div></div> <div></div> <div></div> <div></div> </div>';
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    function showLoader() {
      $.blockUI({
        message: lodingImage,
        baseZ: 2000,
        css: {
          border: '0',
          cursor: 'wait',
          backgroundColor: 'transparent'
        },
      });
    }

    function stopLoader() {
      $.unblockUI();
    }

    $(".alert").delay(4000).slideUp(200, function() {
      $(this).alert('close');
    });
  </script>

  @stack('js')


  @stack('script')

  <script>
    window.Laravel = @json([
    'csrfToken' => csrf_token(),
]);
    const message = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success shadow mr-5',
        cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
    });

    const toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000,
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
      $.toast({
        heading: "Success",
        text: "{!! session('success') !!}",
        showHideTransition: "slide",
        icon: "success",
        loaderBg: "#f96868",
        position: "top-right"
      });
      @php
        session()->forget('success');
      @endphp
    @endif

    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
      $(document).on('click', '.call-modal', function(e) {

        e.preventDefault();
        // return false;
        var el = $(this);

        if (el.data('requestRunning')) {
          console.log('0');
          return;
        }
        el.data('requestRunning', true);

        showLoader();

        var url = el.data('url');
        var target = el.data('target-modal');

        console.log(target);

        $.ajax({
          type: "GET",
          url: url
        }).always(function() {

          $('#load-modal').html(' ');
          el.data('requestRunning', false);

          stopLoader();

        }).done(function(res) {
          $('#load-modal').html(res.html);
          // $('body').append(res.html);
          el.attr({
            'data-toggle': "modal",
            'data-target': target
          });
          $(target).modal('toggle');

        });

      });


      $(document).on('click', '.has-wish-lists', function() {

        var el = $(this);
        var url = el.attr('data-url');
        var remove = el.attr('data-remove');

        $.ajax({
          type: "GET",
          url: url,
        }).done(function(res) {

          if (res.process == "add") {
            $(el).addClass('bg-danger');
            $(el).find('i').addClass('text-white');
            $.toast({
              heading: 'Success',
              text: 'Favourite add successfully.',
              showHideTransition: 'slide',
              icon: 'success',
              loaderBg: '#f96868',
              position: 'top-right',
              stack: 1
            });
          } else if (res.process == "remove") {

            if (remove) {
              el.closest('.col-grid-box').remove();
              if (!$('.col-grid-box').length) {
                $('.dashboard').html('<h4>You have no wishlist</h4>')
              }
            }

            $(el).removeClass('bg-danger');
            $(el).find('i').removeClass('text-white');
            $.toast({
              heading: 'Success',
              text: 'Favourite remove successfully.',
              showHideTransition: 'slide',
              icon: 'success',
              loaderBg: '#f96868',
              position: 'top-right',
              stack: 1
            });
          }

        }).fail(function(res) {

          $.toast({
            heading: 'Error',
            text: 'Something went wrong.',
            showHideTransition: 'slide',
            icon: 'success',
            loaderBg: '#f96868',
            position: 'top-right'
          })

        });

      });


    });
  </script>


  <script async src="https://widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js"></script>

  <script async data-id="72975" src="https://cdn.widgetwhats.com/script.min.js"></script>
  @livewireScripts

</body>

</html>
