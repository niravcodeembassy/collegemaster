@extends('frontend.layouts.app')

@section('title')
{{$blog->title}}
@endsection

@section('title', $blog->meta_title)
@section('keywords', $blog->meta_keywords)
@section('published_time', $blog->published_at)
@section('description', $blog->meta_description)

@section('og-title', $blog->meta_title)
@section('og-url', url()->current())
@section('og-image', $blog->image_src)
@section('og-description',$blog->meta_description)

@section('twiter-title', $blog->meta_title)
@section('twiter-description', $blog->meta_description)
@section('twitter-image', $blog->image_src)


@section('content')
<div class="breadcrumb-area breadcrumb-bg-1 pt-50 pb-70 mb-100">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="breadcrumb-title">Blog</h1>

        <!--=======  breadcrumb list  =======-->

        <ul class="breadcrumb-list">
          <li class="breadcrumb-list__item"><a href="{{ url('/') }}">HOME</a></li>
          <li class="breadcrumb-list__item"><a href="{{ route('blog')}}">Blog</a></li>
          <li class="breadcrumb-list__item breadcrumb-list__item--active">{{ $blog->title ??''}}</li>
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
                <img src="{{$blog->image_src ?? ''}}" class="img-fluid" alt="">
              </div>

              <!--=======  End of image  =======-->

              <!--=======  content  =======-->

              <div class="single-slider-post__content single-slider-post--sticky__content">
                <!--=======  post category  =======-->


                <h2 class="post-title"><a href="blog-single-post-left-sidebar.html">{{ ucwords($blog->title ??'')}}</a>
                </h2>

                <!--=======  End of post category  =======-->

                <!--=======  post info  =======-->

                <div class="post-info d-flex flex-wrap align-items-center mb-50">
                  <div class="post-user">
                    <i class="ion-android-person"></i> By
                    <span> Admin</span>
                  </div>
                  <div class="post-date mb-0 pl-30">
                    <i class="ion-android-calendar"></i>
                    <span> {{ $blog->created_at->format('F d Y')}}</span>
                  </div>
                </div>

                <div class="single-blog-post-section">
                  <p class="mb-30">
                    {{$blog->content ?? ''}}
                  </p>
                  <p class="mb-30">
                    {!! $blog->description ?? ''!!}
                  </p>
                </div>

                <!--=======  End of single blog post section align-items-center  =======-->


                <div class="row mt-30 align-items-center">
                  <div class="col-md-6 text-md-left mb-sm-15">
                    <div class="post-tags">
                      <i class="ion-ios-pricetags"></i>
                      <ul class="tag-list">
                        @forelse ($blog->tags as $tag)
                        @if(!$loop->last)
                        <li><span>{{ucwords($tag->name) ?? ''}}</span>,</li>
                        @else
                        <li><span>{{ucwords($tag->name) ?? ''}}</span></li>
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
