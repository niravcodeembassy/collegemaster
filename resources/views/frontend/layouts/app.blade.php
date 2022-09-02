<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> {{ env('APP_NAME') }} | @yield('title', $title ?? 'Home')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="index, follow">
  <!-- Favicon -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('storage/' . $frontsetting->favicon) }}" type="png">

  {{-- seo meta tag --}}
  <meta name="title" content="@yield('title', $frontsetting->meta_title)">
  <meta name="description" content="@yield('description', $frontsetting->meta_description)">
  <meta name="keywords" content="@yield('keywords', $frontsetting->meta_keywords)">
  <meta property='article:published_time' content="@yield('published_time', now())">

  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="@yield('google_name', $frontsetting->meta_title)">
  <meta itemprop="description" content="@yield('google_description', $frontsetting->meta_description)">
  <meta itemprop="image" content="@yield('google_image', asset('storage/' . $frontsetting->logo))">

  <!-- Open Graph data -->
  <meta property="og:title" content="@yield('og-title', $frontsetting->meta_title)">
  <meta property="og:type" content="website">
  <meta property="og:url" content="@yield('og-url', url()->current())">
  <meta property="og:image" content="@yield('og-image', asset('storage/' . $frontsetting->logo))">
  <meta property="og:description" content="@yield('og-description', $frontsetting->meta_description)">
  <meta property="og:site_name" content="{{ env('APP_NAME') }}">

  <!-- Twitter Card data -->
  <meta name="twitter:card" content="@yield('twitter-card', 'product')">
  <meta name="twitter:site" content="@publisher_handle" />
  <meta name="twitter:title" content="@yield('twitter-title', $frontsetting->meta_title)">
  <meta name="twitter:description" content="@yield('twitter-description', $frontsetting->meta_description)">
  <meta name="twitter:creator"
    content="@author_handle" />
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

  <link href="{{ asset('front/assets/css/index.css') }}" rel="stylesheet">

  <style>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
  <script src="https://cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>
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


    const scroller = document.querySelector(".main_list");
    const dropDown = document.querySelectorAll(".sub-menu");
    scroller.addEventListener("scroll", checkScroll);

    function checkScroll() {
      for (let i = 0; i < dropDown.length; i++) {
        if (i === dropDown.length - 1) {
          var scr = scroller.scrollLeft + 181;
          dropDown[i].style.transform =
            "translateX(-" + scr + "px)";
        } else {
          dropDown[i].style.transform =
            "translateX(-" + scroller.scrollLeft + "px)";
        }
      }
    }


    function leftScroll() {
      const element = document.querySelector("#category_scroll");
      sideScroll(element, 'left', 25, 300, 80);
    }

    function rightScroll() {
      const element = document.querySelector("#category_scroll");
      sideScroll(element, 'right', 25, 300, 80);
    }

    function sideScroll(element, direction, speed, distance, step) {
      scrollAmount = 0;
      var slideTimer = setInterval(function() {
        if (direction == 'left') {
          element.scrollLeft -= step;
        } else {
          element.scrollLeft += step;
        }
        scrollAmount += step;
        if (scrollAmount >= distance) {
          window.clearInterval(slideTimer);
        }
      }, speed);
    }


    //ask why error
    document.querySelectorAll('oembed[url]').forEach(element => {
      const anchor = document.createElement('a');

      anchor.setAttribute('href', element.getAttribute('url'));
      var a = [];
      anchor.className = 'embedly-card';

      element.appendChild(anchor);
    });

    //mobile_view
    $('#live_search_mobile').on('keyup', function() {
      $('#search_mobile_btn').removeClass('d-none');
    });

    $('#search_mobile_btn').on('click', function() {
      $('#live_search_mobile').val('');
      @if (url()->current() == url('/all'))
        var url = "/";
        $('#live_search_mobile').val('')
        window.location.href = url;
      @endif
      $('#search_mobile_btn').addClass('d-none');
    })

    var route_second = $('#live_search_mobile').data('url');
    search('#live_search_mobile', route_second);
    $mobile_input = $('#live_search_mobile');
    $mobile_input.change(function() {
      var current = $mobile_input.typeahead("getActive");
      console.log(current);
      if (current) {
        var link = "/all?term=" + (current.name) + "&flag=" + false;
        window.location.href = link;
      }
    });


    //desktop view
    $('#live_search').on('keyup', function() {
      $('#search_btn').removeClass('d-none');
    });


    $('#search_btn').on('click', function() {
      $('#live_search').val('');

      @if (url()->current() == url('/all'))
        var url = "/";
        $('#live_search').val('');
        window.location.href = url;
      @endif

      $('#search_btn').addClass('d-none');
    })

    //product search
    var route = $('#live_search').data('url');
    redirectSearchPage('#live_search');
    search('#live_search', route);

    function redirectSearchPage(rawId) {
      $input = $(rawId);
      $input.change(function() {
        var current = $input.typeahead("getActive");
        if (current) {
          var link = "/all?term=" + (current.name) + "&flag=" + false;
          window.location.href = link;
        }
      });
    }


    function search(Id, route) {
      $(Id).typeahead({
        hint: true,
        highlight: true,
        source: function(query, process) {
          return $.get(route, {
            query: query
          }, function(data) {
            return process(data);
          });
        },
      });
    }
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
      @endphp @endif

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
