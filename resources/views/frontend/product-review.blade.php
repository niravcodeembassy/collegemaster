@extends('frontend.layouts.app')

@section('title')
  {{ $title }}
@endsection

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

@push('style')
  <style>
    .single-method input[type=radio]+label {
      font-size: 16px;
    }

    .single-review {
      border-bottom: none;
      padding-bottom: 20px;
    }

    .publish_date {
      color: brown;
      font-size: 14px;
    }

    .page-item.active .page-link {
      background-color: #333333;
      border-color: #333333;
    }

    img.product_img {
      width: 120px;
      height: 120px;
    }

    .lezada-button {
      border-radius: 0px;
      background-color: #353535;
      padding: 5px 8px;
    }

    a span.blue {
      background-color: #1e73be;
    }

    a span.grey {
      background-color: #e5e9f2;
    }

    a span.color-picker {
      display: inline-block;
      vertical-align: top;
      height: 18px;
      width: 18px;
      line-height: 18px;
      margin-top: 3px;
      border-radius: 100%;
    }

    .card {
      background-color: #e9ecef !important;
    }

    .bottom_border {
      border-bottom: 1px solid black;
    }

    .bottom_top {
      border-top: 1px solid black;
      padding: 10px 0 0 0;
    }

    input[type=radio] {
      width: 20px;
      height: 20px;
    }

    input[type=checkbox] {
      width: 17px;
      height: 17px;
    }

    .review_img {
      height: 70px;
    }

    .digit {
      display: inline-block;
      float: right;
    }

    p.review_text {
      font-size: 13px;
    }

    i.gold,
    span.gold {
      color: #f5cc26;
    }

    div.progress_bar_review .col-lg-2 {
      flex: 0 0 12.666667%;
      max-width: 12.666667%;
    }

    @media only screen and (max-width: 480px) {
      .review_content {
        flex-direction: column !important;
      }

      div.progress_bar_review .col-lg-2 {
        flex: 0 0 17.666667%;
        max-width: 17.666667%;
      }
    }
  </style>
@endpush



@section('content')
  <div class="pt-80 review_main_content">
    <div class="container pb-80">

      <div class="row mb-80">
        <div class="col-lg-3"></div>
        <div class="col-lg-9 text-center">
          <span class="h2 gold font-weight-bold">{{ $rating_details->sum('total_rating') }}</span>
          <span class="h2 font-weight-bold">Customer Reviews</span>
          <p class="review_text">Shopper Approved collects trusted reviews from customers who have made a verified purchase</p>
        </div>
      </div>

      <div class="row mb-80">
        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
          <div class="text-center">
            <p class="h2 font-weight-bold">{{ round($avg_rating, 1) }}</p>
            @for ($i = 0; $i < round($avg_rating); $i++)
              <i class="fa fa-star gold star fa-lg" aria-hidden="true"></i>
            @endfor
            @for ($i = 0; $i < 5 - round($avg_rating, 2); $i++)
              <i class="fa fa-star-o fa-lg" aria-hidden="true"></i>
            @endfor
            <br>
            <small class="text-capitalize mt-1">OVERALL STAR RATING</small>
          </div>
        </div>
        <div class="col-lg-9 mt-md-50 mt-sm-50 mt-lg-0">
          <div class="row">
            <div class="col-md-8">
              @foreach ($rating_details as $list)
                <div class="row progress_bar_review">
                  <div class="col-lg-2 col-md-2 col-2">
                    <span>{{ $list->rating }} <i class="fa fa-star active star fa-1x" aria-hidden="true"></i>
                  </div>
                  @php
                    $perc = number_format($list->percentage, 2);
                  @endphp
                  <div class="col-lg-6 col-md-6 col-4">
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" style="width: {{ $perc }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-5">
                    <span class="font-weight-bold mx-2">{{ $list->total_rating }}</span>
                    <span>({{ number_format($list->percentage, 2) }}) %</span>
                  </div>
                </div>
              @endforeach
            </div>
            <div class="col-lg-4 mt-md-50 mt-sm-50 mt-lg-0">
              {{-- <img src="{{ asset('front/assets/images/truck.png') }}" class="img-fluid review_img" alt="review" title="review"> --}}
            </div>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between bottom_border mb-3">
                <span class="h5">Filters</span>
                <i class="ion-android-funnel"></i>
              </div>
              <p>Date</p>
              {{-- <div class="form-check">
                  <input class="form-check-input filter_review" type="radio" {{ request()->get('filter') == 'all' ? 'checked' : '' }} data-filter="all" id="all">
                  <label class="form-check-label mx-2" for="all">
                    All
                  </label>
                </div> --}}
              <div class="form-check my-2">
                <input class="form-check-input filter_review" type="radio" {{ request()->get('filter') == 'latest' ? 'checked' : '' }} data-filter="latest" id="latest">
                <label class="form-check-label mx-2" for="latest">
                  Latest
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input filter_review" type="radio" {{ request()->get('filter') == 'oldest' ? 'checked' : '' }} data-filter="oldest" id="oldest">
                <label class="form-check-label mx-2" for="oldest">
                  Oldest
                </label>
              </div>
              <p class="bottom_top mt-4">Category</p>
              @forelse ($category as $item)
                <div class="form-check">
                  <input class="form-check-input filter_review" type="checkbox" {{ request()->get('filter') == $item->slug ? 'checked' : '' }} data-filter="{{ $item->slug }}">
                  <label class="form-check-label mx-2">
                    {{ $item->name }}
                  </label>
                  <span class="digit">{{ $item->total_reviews }}</span>
                </div>
              @empty
                <p>Category Review Not Found</p>
              @endforelse
              <p class="bottom_top mt-4">Rating</p>
              @forelse ($rating_details as $details)
                <div class="form-check">
                  <input class="form-check-input filter_review" type="checkbox" data-filter="{{ $details->rating }}" {{ request()->get('filter') == $details->rating ? 'checked' : '' }}>
                  <label class="form-check-label mx-2">
                    {{ $details->rating_title }} ({{ $details->rating }}) <i class="fa fa-star active star fa-1x" aria-hidden="true"></i>
                  </label>
                  <span class="digit">{{ $details->total_rating }}</span>
                </div>
              @empty
                <p>Rating Not Found</p>
              @endforelse
            </div>
          </div>
        </div>
        <div class="col-lg-9 mt-md-50 mt-sm-50 mt-lg-0">
          <div class="row">
            @forelse ($reviews as $key=> $review)
              @php
                $img_url = $review->product->defaultimage->image_url;
                $img_alt = $review->product->defaultimage->image_alt;
                $img = asset('storage/' . $img_url);
                $category = $review->product->category->name;
                $name = isset($review->user) ? $review->user->name : $review->name;
                $published_date = date('d.m.Y', strtotime($review->created_at));
                $user_url = 'https://ui-avatars.com/api/?name=' . $name;
              @endphp
              <div class="col-12 col-lg-12 col-md-12 col-sm-12 mb-25">
                <div class="card">
                  <div class="card-body">
                    <div class="single-review mb-0">
                      <div class="single-review__image">
                        <img src="{{ $user_url ?? asset('front/assets/images/blank.png') }}" class="img-fluid" alt="{{ $name }}" title="{{ $name }}">
                      </div>
                      <div class="single-review__content">
                        <!--=======  rating  =======-->
                        <div class="shop-product__rating">
                          <span class="product-rating">
                            @for ($i = 0; $i < $review->rating; $i++)
                              <i class="fa fa-star active star fa-1x" aria-hidden="true"></i>
                            @endfor
                            @for ($i = 0; $i < 5 - $review->rating; $i++)
                              <i class="fa fa-star-o fa-1x" aria-hidden="true"></i>
                            @endfor
                            <small class="mx-2 font-italic">{{ $review->rating }}/5</small>
                            <span class="">Published: {{ $published_date }}</span>
                          </span>
                        </div>
                        <span>{{ $name }}</span>
                        <!--=======  End of message  =======-->
                      </div>
                    </div>
                    <div class="review_content d-flex">
                      <img src="{{ $img ?? asset('front/assets/images/blank.png') }}" title="{{ $img_alt }}" alt="{{ $img_alt }}" class="img-fluid product_img mr-4">
                      <div class="my-lg-0 my-md-0 my-3">
                        <div class="message">
                          <b>{{ $review->product->name ?? '' }}</b>
                        </div>
                        <div class="message mt-2">
                          {{ $review->message ?? '' }}
                        </div>
                      </div>
                    </div>
                    <a class="lezada-button float-right" href="{{ route('product.view', ['slug' => $review->product->slug]) }}">View Product</a>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12 col-lg-12 col-md-12 col-sm-12 mb-25">
                <div class="card">
                  <div class="card-body">
                    <h3 class="text-center">Review Not Found</h3>
                  </div>
                </div>
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>


  </div>

  <div class="row">
    <div class="col-lg-12 d-flex justify-content-center mb-80">
      {{ $reviews->appends(request()->query())->links() }}
    </div>
  </div>
  </div>
  </div>
@endsection

@push('script')
  <script>
    $(document).on("change", ".filter_review", function(e) {

      $('input[type="checkbox"]').not(this).prop('checked', false);
      $('input[type="radio"]').not(this).prop('checked', false);

      var filter = $(this).data('filter');
      var url = '{{ route('review') }}';

      var link = url + "?filter=" + filter;

      window.location.href = link;

    });
  </script>
@endpush
