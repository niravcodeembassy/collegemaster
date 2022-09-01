@extends('frontend.layouts.app')
@push('style')
  <style>
    a.active {
      opacity: 1 !important;
      color: black;
    }

    .page-item.active .page-link {
      background-color: #333333 !important;
      border-color: #333333 !important;
    }

    @media only screen and (max-width: 375px) {
      .page-link {
        padding: 0.3rem 0.35rem;
        margin-left: -2px
      }
    }

    @media only screen and (min-width: 376px) and (max-width: 480px) {
      .page-link {
        padding: 0.4rem 0.4rem;
        margin-left: -2px
      }
    }
  </style>
@endpush
@section('title')
  {{ $title }}
@endsection
@section('content')
  <div class="breadcrumb-area breadcrumb-bg-1 pt-50 pb-70 mb-100">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="breadcrumb-title">Blog</h1>

          <!--=======  breadcrumb list  =======-->

          <ul class="breadcrumb-list">
            <li class="breadcrumb-list__item"><a href="{{ url('/') }}">HOME</a></li>
            <li class="breadcrumb-list__item breadcrumb-list__item--active">Blog</li>
          </ul>

          <!--=======  End of breadcrumb list  =======-->

        </div>
      </div>
    </div>
  </div>


  <div class="blog-page-wrapper mb-100">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 order-1">
          @if ($blogs->count() > 0)
            <div class="row">

              @foreach ($blogs as $key => $blog)
                <div class="col-md-12 mb-60">
                  <div class="single-slider-post single-slider-post--list {{ $loop->last ? 'border-0 pb-0' : '' }}">
                    <!--=======  image  =======-->

                    <div class="single-slider-post__image single-slider-post--list__image mb-sm-30">
                      <a href="{{ route('blog.show', $blog->slug) }}">
                        <img src="{{ $blog->image_src ?? '' }}" class="img-fluid" alt="">
                      </a>
                    </div>

                    <!--=======  End of image  =======-->

                    <!--=======  content  =======-->

                    <div class="single-slider-post__content single-slider-post--list__content">
                      <div class="post-date">
                        <i class="ion-android-calendar"></i>
                        <span> {{ $blog->created_at->format('F d Y') }}</span>
                      </div>
                      <h2 class="post-title"><a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title ?? '' }}</a></h2>
                      <p class="post-excerpt">{{ Str::limit($blog->content, 150) }} </p>
                      <a href="{{ route('blog.show', $blog->slug) }}" class="blog-readmore-btn">read more</a>
                    </div>

                    <!--=======  End of content  =======-->
                  </div>
                </div>
              @endforeach


            </div>

            <div class="row">
              <div class="col-lg-12 d-flex justify-content-center mt-30">
                {{ $blogs->appends(request()->query())->links() }}
              </div>
            </div>
          @endif


        </div>

      </div>
    </div>
  </div>

@endsection
