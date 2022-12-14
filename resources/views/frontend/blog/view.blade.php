@extends('frontend.layouts.app')

@section('title')
  {{ $blog->meta_title }}
@endsection

@section('meta_title', $blog->meta_title)
@section('keywords', $blog->meta_keywords)
@section('published_time', $blog->published_at)
@section('description', $blog->meta_description)

@section('google_name', $blog->meta_title)
@section('google_description', $blog->meta_description)
@section('google_image', $blog->product_src)

@section('og-title', $blog->meta_title)
@section('og-url', url()->current())
@section('og-image', $blog->image_src)
@section('og-description', $blog->meta_description)

@section('twiter-title', $blog->meta_title)
@section('twiter-description', $blog->meta_description)
@section('twiter-image', $blog->image_src)

@push('style')
  <style>
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

@php
  $schema_organization = Schema::organizationSchema();
  $schema_local = Schema::localSchema();
  $review_schema = Schema::reviewSchema();

  $schema_organization = json_encode($schema_organization, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  $schema_local = json_encode($schema_local, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  $schema_review = json_encode($review_schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

  $schema = [$schema_organization, $schema_local, $schema_review];
@endphp

@section('schema')

  @foreach ($schema as $key => $list)
    <x-schema>
      {!! $list !!}
    </x-schema>
  @endforeach
@endsection

@section('content')
  <div class="breadcrumb-area breadcrumb-bg-1 pt-50 pb-70 mb-100">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="breadcrumb-title">Blog</h1>

          <!--=======  breadcrumb list  =======-->

          <ul class="breadcrumb-list">
            <li class="breadcrumb-list__item"><a href="{{ route('front.home') }}">HOME</a></li>
            <li class="breadcrumb-list__item"><a href="{{ route('blog') }}">Blog</a></li>
            <li class="breadcrumb-list__item breadcrumb-list__item--active">{{ $blog->title ?? '' }}</li>
          </ul>

          <!--=======  End of breadcrumb list  =======-->
        </div>
      </div>
    </div>
  </div>


  <div class="blog-page-wrapper mb-100">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 order-1 mb-md-70 mb-sm-70">
          <div class="row">

            <div class="col-md-12 mb-40">
              <div class="single-slider-post  pb-60">
                <!--=======  image  =======-->

                <div class="single-slider-post__image single-slider-post--sticky__image mb-30">
                  <img src="{{ $blog->image_src ?? '' }}" class="img-fluid" alt="{{ $blog->title ?? '' }}" title="{{ $blog->title ?? '' }}">
                </div>

                <!--=======  End of image  =======-->

                <!--=======  content  =======-->

                <div class="single-slider-post__content single-slider-post--sticky__content">
                  <!--=======  post category  =======-->


                  <h2 class="post-title">{{ ucwords($blog->title ?? '') }}</h2>


                  <!--=======  End of post category  =======-->

                  <!--=======  post info  =======-->

                  <div class="post-info d-flex flex-wrap align-items-center mb-50">
                    <div class="post-user">
                      <i class="ion-android-person"></i> By
                      <span> Admin</span>
                    </div>
                    <div class="post-date mb-0 pl-30">
                      <i class="ion-android-calendar"></i>
                      <span> {{ $blog->created_at->format('F d Y') }}</span>
                    </div>
                  </div>

                  <div class="single-blog-post-section">
                    <p class="mb-30">
                      {{ $blog->content ?? '' }}
                    </p>
                    <div class="mb-30 ck_editor_data">
                      {!! $blog->description ?? '' !!}
                    </div>
                  </div>

                  <!--=======  End of single blog post section align-items-center  =======-->


                  <div class="row mt-30 align-items-center">
                    <div class="col-md-6 text-md-left mb-sm-15">
                      <div class="post-tags">
                        <i class="ion-ios-pricetags"></i>
                        <ul class="tag-list">
                          @forelse ($blog->tags as $tag)
                            @if (!$loop->last)
                              <li><span>{{ ucwords($tag->name) ?? '' }}</span>,</li>
                            @else
                              <li><span>{{ ucwords($tag->name) ?? '' }}</span></li>
                            @endif
                          @empty
                            <li><span>no tag for blog</span></li>
                          @endforelse
                        </ul>
                      </div>
                    </div>

                    <div class="col-md-6 text-center text-md-right d-none">
                      <div class="post-share">
                        <span>Share this post:</span>
                        <ul>
                          <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                          <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                          <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                          <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
