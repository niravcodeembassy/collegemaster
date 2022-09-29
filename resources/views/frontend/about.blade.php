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

    .ck_editor_data h1 {
      font-size: 24px;
    }

    .ck_editor_data h2,
    h3 {
      font-size: 22px;
    }

    .ck_editor_data p {
      max-width: 100%;
      font-size: 15px;
    }


    .ck_editor_data blockquote p {
      max-width: 95%;
    }

    .ck_editor_data blockquote {
      padding-top: 5px;
      padding-bottom: 5px;
    }
  </style>
@endpush
@push('css')
  <link rel="stylesheet" href="{{ asset('front/assets/css/testimonial.css') }}">
@endpush

@section('title')
  {{ $page->page_title }}
@endsection

@section('meta_title', $page->page_title)
@section('keywords', $page->meta_keywords)
@section('published_time', $page->created_at)
@section('description', $page->meta_desc)

@section('google_name', $page->meta_title)
@section('google_description', $page->meta_description)

@section('og-title', $page->page_title)
@section('og-url', url()->current())
@section('og-description', $page->meta_desc)

@section('twiter-title', $page->meta_title)
@section('twiter-description', $page->meta_desc)

@php
$schema_organization = Schema::organizationSchema();
$schema_local = Schema::localSchema();

$schema_organization = json_encode($schema_organization, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$schema_local = json_encode($schema_local, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

$schema = [$schema_organization, $schema_local];
@endphp

@section('schema')

  @foreach ($schema as $key => $list)
    <x-schema>
      {!! $list !!}
    </x-schema>
  @endforeach

@endsection


@section('content')
  <div class=" breadcrumb-area   pt-20 pb-20 mb-30" style="background-color: #f5f5f5;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2 class="breadcrumb-title">About Us</h2>

          <!--=======  breadcrumb list  =======-->

          <ul class="breadcrumb-list">
            <li class="breadcrumb-list__item"><a href="{{ route('front.home') }}">HOME</a></li>
            <li class="breadcrumb-list__item breadcrumb-list__item--active">About us</li>
          </ul>

          <!--=======  End of breadcrumb list  =======-->

        </div>
      </div>
    </div>
  </div>

  <div class="section-title-container mb-80">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <!--=======  section title  =======-->

          <div class="section-title section-title--one text-center">

            <h1>{{ $page->title }}</h1>
          </div>

          <!--=======  End of section title  =======-->
        </div>
      </div>
    </div>
  </div>

  <div class="about-page-content mb-100 mb-sm-45">
    <div class="container wide">

      <div class="row">
        <div class="col-lg-6 mb-md-50 mb-sm-50">
          <!--=======  about page 2 image  =======-->

          @if (isset($page->slider_image))
            <div class="about-page-2-image">
              <img src="{{ $page->page_image }}" class="img-fluid" alt="{{ $page->title ?? '' }}" title="{{ $page->title ?? '' }}">
            </div>
          @endif

          <!--=======  End of about page 2 image  =======-->
        </div>

        <div class="offset-xl-1 col-xl-4 col-lg-6 col-md-6 mb-sm-50">

          <div class="about-page-text">
            <p class="mb-35">{{ $page->short_content ?? '' }}</p>
          </div>
        </div>

        <div class="col-lg-12">
          <div class="about-page-text ck_editor_data">
            <p class="my-35">{!! $page->bodyhtml ?? '' !!}</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if ($team->count() > 0)
    <div class="section-title section-title--one text-center mb-30">
      <h2 class="font-weight-bold">Creative team</h2>
      <div class="divider-custom">
        <div class="divider-custom-line-1"></div>
        <div class="divider-custom-icon">
          <i class="fa fa-circle" aria-hidden="true"></i>
        </div>
        <div class="divider-custom-line-1"></div>
      </div>
    </div>
  @endif


  <div class="team-member-area mb-100">
    <div class="container">
      <div class="row">
        <div class="fadeOut owl-carousel owl-theme">
          @foreach ($team as $key => $member)
            <div class="item">
              <div class="single-team-member text-center">
                <div class="member-image">
                  <img src="{{ $member->image_src ?? '' }}" class="img-fluid" alt="{{ $member->title ?? '' }}" title="{{ $member->title ?? '' }}">
                  <div class="social-inside d-none">
                    <ul class="social-list">
                      <li class="social-list__item"><a href="#"><i class="fa fa-facebook"></i></a></li>
                      <li class="social-list__item"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                      <li class="social-list__item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="member-caption">
                  <h2 class="name">{{ $member->title ?? '' }}</h2>
                  <span class="subtext">{{ $member->designation ?? '' }}</span>
                </div>
              </div>
            </div>
          @endforeach
        </div>


      </div>
    </div>
  </div>


  @if ($testimonial->count() > 0)
    @include('frontend.testimonial')
  @endif

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
          nav: true
        },
        1000: {
          items: 4,
          nav: true,
          loop: false
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
