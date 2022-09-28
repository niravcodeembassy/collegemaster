@extends('frontend.layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('front/assets/css/testimonial.css') }}">
@endpush


@push('style')
  <style>
    .masthead {
      height: 50vh;
      padding-top: 9.5rem;
      padding-bottom: 9rem;
      color: #fff;
      background-image: url('{{ asset('front/assets/images/404-error.jpg') }}');
      background-repeat: no-repeat;
      background-attachment: scroll;
      background-position: center center;
      background-size: cover;
    }

    .primary_title {
      margin-top: 0px;
      line-height: normal;
      text-transform: uppercase;
      font-size: 24px;
    }

    .primary_content {
      line-height: normal;
      font-size: 13px;
    }

    .primary_content a {
      color: #bf1e2e;
    }

    .primary_content a:hover {
      color: #343a40;
    }

    @media only screen and (max-width: 480px) {
      .masthead {
        margin-left: -365px;
      }

      .box_area {
        position: absolute;
        left: 10px;
        border: 1px solid black;
        width: 340px;
        padding-top: 5px;
        padding-bottom: 5px;
        background: hsla(0, 0%, 100%, .85);
        margin-top: 60px;
        margin-right: 5px;
      }

      .primary_title {
        font-size: 18px;
      }
    }

    @media screen and (max-width: 1600px) {
      .masthead {
        padding-top: 8.5rem;
      }
    }

    @media screen and (max-width: 1366px) {
      .masthead {
        padding-top: 7.5rem;
      }
    }

    @media only screen and (min-width: 640px) and (max-width: 667px) {
      .masthead {
        margin-left: -365px;
      }

      .box_area {
        position: absolute;
        left: 10px;
        padding-left: 10px;
        padding-right: 10px;
        padding-top: 20px;
      }
    }

    @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait) {
      .masthead {
        height: 32vh;
        padding-top: 5.5rem;
      }

    }
  </style>
@endpush

@php
$commonBanner = App\Model\CommonBanner::whereNull('is_active')->get();
@endphp
@section('content')
  <div class="masthead mb-50">
    <div class="container mx-auto">
      <div class="row">
        <div class="col-md-6 box_area">
          <h3 class="primary_title font-weight-bold">OOPS! THIS PAGE IS LOST OR MAY HAVE BEEN MOVED.</h3>
          <p class="primary_content text-dark">Sorry! Either we can’t find the page you’re looking for, or there was a jam in our machine. Try searching or return to our <a class="primary_link" href="{{ route('front.home') }}">homepage</a></p>
        </div>
      </div>

    </div>
  </div>
  @if ($commonBanner->count() > 0)
    <div class="section-title-container mb-30 mb-md-30 mb-sm-30">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <!--=======  section title  =======-->
            <div class="section-title section-title--one text-center">
              <h3 class="text-uppercase font-weight-bold quality_h3">Clever & unique ideas</h3>
              <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon">
                  <i class="fa fa-circle" aria-hidden="true"></i>
                </div>
                <div class="divider-custom-line"></div>
              </div>
              <p class="idea_content d-xl-block d-none">
                <span>Collage Master is a one-of-a-kind gifting service that has revolutionized the art of gifting. Gifting pictures has been an age-old concept but we at Collage Master</span>
                <br /><span> refined this concept and added our own twist to it. We have come up with a new way of capturing your memories and portraying them</span><br />
                <span>in a beautiful manner. We are more than just a collage-making service.</span>
              </p>
              <p class="idea_content d-xl-none">
                Collage Master is a one-of-a-kind gifting service that has revolutinized the art of gifting. Gifting pictures has been an age-old concept but we at Collage Master
                refined this concept and added our own twist to it. We have come up with a new way of capturing your memories and portraying them
                in a beautiful manner. We are more than just a collage-making service.
              </p>
            </div>
            <!--=======  End of section title  =======-->
          </div>
        </div>
      </div>
    </div>
    <div class="hover-banner-area mb-65 mb-md-45 mb-sm-45">
      <div class="container wide">
        <div class="row">
          @foreach ($commonBanner as $item)
            <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 mb-30 banner_side">
              <!--=======  single category  =======-->
              <div class="single-category single-category--three">
                <!--=======  single category image  =======-->
                <div class="single-category__image single-category__image--three single-category__image--three--creativehome single-category__image--three--banner">
                  <img src="{{ $item->banner_image }}" class="img-fluid" alt="{{ $item->caption1 ?? '' }}" title="{{ $item->caption1 ?? '' }}">
                </div>
                <!--=======  single category content  =======-->
                <div class="single-category__content single-category__content--three single-category__content--three--creativehome  single-category__content--three--banner mt-25 mb-lg-0 mb-md-15 mb-sm-15">
                  <div class="title">
                    <p><a href="{{ $item->url }}">{{ $item->caption1 ?? '' }} <span>{{ $item->caption2 ?? '' }}</span></a></p>
                    @if ($item->url)
                      <a class="lezada-button caption_button lezada-button--custom" href="{{ $item->url }}">{{ $item->caption3 ?? '' }}</a>
                    @endif
                  </div>
                </div>
                <!--=======  banner-link  =======-->
                @if ($item->url)
                  <a href="{{ $item->url }}" class="banner-link"></a>
                @endif
                <!--=======  End of banner-link  =======-->
              </div>
              <!--=======  End of single category  =======-->
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endif
@endsection
