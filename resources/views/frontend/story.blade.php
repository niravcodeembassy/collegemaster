@extends('frontend.layouts.app')
@push('style')
  <style>
    .owl-nav button {
      position: absolute;
      top: 50%;
      background-color: #000;
      transform: translateY(-50%);
      color: #fff;
      margin: 0;
      transition: all 0.3s ease-in-out;
    }

    .owl-nav button.owl-prev {
      left: 0;
    }

    .owl-nav button.owl-next {
      right: 0;
    }
  </style>
@endpush

@section('title')
  {{ $story->title }}
@endsection


@section('content')
  <div class="breadcrumb-area d-none   pt-20 pb-20 mb-30" style="background-color: #f5f5f5;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="breadcrumb-title">{{ $title ?? '' }}</h1>

          <!--=======  breadcrumb list  =======-->

          <ul class="breadcrumb-list">
            <li class="breadcrumb-list__item"><a href="{{ url('/') }}">HOME</a></li>
            <li class="breadcrumb-list__item breadcrumb-list__item--active">{{ $title ?? '' }}</li>
          </ul>

          <!--=======  End of breadcrumb list  =======-->

        </div>
      </div>
    </div>
  </div>
  <hr />
  <div class="section-title-container mb-40">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <!--=======  section title  =======-->

          <div class="section-title section-title--one text-center">

            <p class="subtitle subtitle--deep d-none">SIMPLY OR WHITE</p>
            <h1 class="mt-2">{{ $story->title ?? '' }}</h1>
          </div>

          <!--=======  End of section title  =======-->
        </div>
      </div>
    </div>
  </div>

  <div class="about-video-content mb-100">
    <div class="container">
      <div class="row">
        <div class="col-lg-10 offset-lg-1">
          <div class="about-video-bg-area about-video-bg-2 pt-300 pb-300 pt-sm-200 pb-sm-200  pt-xs-150 pb-xs-150  mb-50">
            <!--=======  floating-text left  =======-->

            <p class="video-text video-text-left d-none"><a href="#">LEZADA STORE</a></p>

            <!--=======  End of floating-text left  =======-->
            <div class="play-icon text-center mb-40">
              <a href="{{ $story->video_url ?? 'https://www.youtube.com/watch?v=feOScd2HdiU' }}" class="popup-video">
                <img src="{{ asset('front/assets/images/icons/icon-play-100x100.png') }}" class="img-fluid" alt="">
              </a>
            </div>
            <h1>OUR STORY</h1>

            <!--=======  floating-text right  =======-->

            <p class="video-text video-text-right d-none"><a href="#">OUR STORY</a></p>

            <!--=======  End of floating-text right  =======-->

          </div>

          <div class="row">
            <div class="col-lg-8 col-md-9 mb-sm-50">
              <div class="lezada-widget lezada-widget--about mb-35">
                {!! $story->description ?? '' !!}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-12 my-2">
          <h3 class="text-center my-5"><a href="{{ $story->instagram_handle_url ?? '' }}">{{ $story->instagram_handle ?? '' }}</a></h3>
          <div class="slider-area">
            <div class="fadeOut owl-carousel owl-theme">
              @foreach ($story->image as $item)
                <div class="item mx-4">
                  <a href="{{ $item->url ?? '' }}">
                    <img src="{{ $item->image_url }}" class="img-fluid">
                  </a>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('css')
  <link rel="stylesheet" href="{{ asset('front/assets/css/animate.css') }}">
  <link rel="stylesheet" href="{{ asset('front/assets/css/owl.carousel.min.css') }}">
@endpush

@push('js')
  <script src="{{ asset('front/assets/js/owl.carousel.js') }}"></script>
@endpush

@push('script')
  <script>
    var owl = $('.owl-carousel');
    owl.owlCarousel({
      items: 4,
      animateOut: 'slideOutUp',
      animateIn: 'goDown',
      loop: false,
      autoplay: true,
      autoplayTimeout: 5000,
      navigation: true,
      navText: [
        "<i class='fa fa-chevron-left'></i>",
        "<i class='fa fa-chevron-right'></i>"
      ],
      transitionStyle: "fade",
      responsiveClass: true,
      responsive: {
        0: {
          items: 1,
          nav: false
        },
        600: {
          items: 3,
          nav: false
        },
        1000: {
          items: 3,
          nav: true,
          loop: true
        }
      }
    });
    jQuery(document).ready(function($) {
      $('.fadeOut').owlCarousel({
        items: 1,
        animateOut: 'fadeOut',
        loop: true,
        margin: 10,
      });
    });
  </script>
@endpush
