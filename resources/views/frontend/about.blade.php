@extends('frontend.layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('front/assets/css/testimonial.css') }}">
@endpush
@section('title')
  {{ $page->title }}
@endsection

@section('title', $page->page_title)
@section('keywords', $page->meta_keywords)
@section('published_time', $page->created_at)
@section('description', $page->meta_desc)

@section('og-title', $page->page_title)
@section('og-url', url()->current())
@section('og-description', $page->meta_desc)

@section('twiter-title', $page->meta_title)
@section('twiter-description', $page->meta_desc)


@section('content')
  <div class=" breadcrumb-area   pt-20 pb-20 mb-30" style="background-color: #f5f5f5;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="breadcrumb-title">About Us</h1>

          <!--=======  breadcrumb list  =======-->

          <ul class="breadcrumb-list">
            <li class="breadcrumb-list__item"><a href="{{ url('/') }}">HOME</a></li>
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

            <h2>{{ $page->title }}</h2>
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
              <img src="{{ $page->page_image }}" class="img-fluid" alt="">
            </div>
          @endif

          <!--=======  End of about page 2 image  =======-->
        </div>

        <div class="offset-xl-1 col-xl-4 col-lg-6 col-md-6 mb-sm-50">

          <div class="about-page-text">
            <p class=" mb-35">{!! $page->bodyhtml ?? '' !!}</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('frontend.testimonial')

@endsection

@push('script')
  <script src="https://www.google.com/recaptcha/api.js"></script>
  <script>
    function onSubmit(token) {
      document.getElementById("contact-form").submit();
    }
  </script>
  <script>
    $(".alert").delay(4000).slideUp(200, function() {
      $(this).alert('close');
    });
  </script>
@endpush
