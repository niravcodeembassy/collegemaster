@extends('frontend.layouts.app')

@section('title')
    {{ $title }}
@endsection



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

@section('pagination')
    @if ($reviews->hasPages())
        @if ($reviews->previousPageUrl() !== null)
            <link rel="prev" href="{{ $reviews->previousPageUrl() }}" />
        @endif
        @if ($reviews->nextPageUrl() !== null)
            <link rel="next" href="{{ $reviews->nextPageUrl() }}" />
        @endif
    @endif
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

        .shop-product__rating .product-rating i.active {
            color: rgb(235, 113, 0);
        }

        color: rgb(235, 113, 0);

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
            background-color: #f9f9f9 !important;
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
            height: 60px;
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
            color: rgb(235, 113, 0);
        }

        div.progress_bar_review .col-lg-2 {
            flex: 0 0 12.666667%;
            max-width: 12.666667%;
        }

        .single-review__image img {
            height: 50px;
            width: 50px;
        }

        .single-review__image {
            flex-basis: 50px;
        }

        .review_text_content small {
            font-size: 70%;
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

        .rating-box {
            position: relative;
            vertical-align: middle;
            font-size: 1.5rem;
            font-family: FontAwesome;
            display: inline-block;
            color: rgb(235, 113, 0);
        }

        .rating-box:before {
            content: "\f006 \f006 \f006 \f006 \f006";
        }

        .rating-box .rating {
            position: absolute;
            left: 0;
            top: 0;
            white-space: nowrap;
            overflow: hidden;
            color: rgb(235, 113, 0);
        }

        .rating-box .rating:before {
            content: "\f005 \f005 \f005 \f005 \f005";
        }
    </style>
@endpush



@section('content')
    <div class="pt-80 review_main_content">
        <div class="container pb-80">

            <div class="row mb-80">
                <div class="col-lg-12 text-center">
                    <h1 class="h2 font-weight-bold"><span class="gold">{{ $rating_details->sum('total_rating') }}</span>
                        <span class="h2 font-weight-bold text-uppercase mx-2">Customer Reviews</span></h1>

                    <p class="review_text text-uppercase">ALL REVIEWS ARE FROM CUSTOMERS WHO HAVE MADE A VERIFIED PURCHASE
                    </p>
                    <div class="divider-custom">
                        <div class="divider-custom-line"></div>
                        <div class="divider-custom-icon">
                            <i class="fa fa-circle" aria-hidden="true"></i>
                        </div>
                        <div class="divider-custom-line"></div>
                    </div>
                </div>
            </div>


            <div class="row mb-20">
                <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="text-center">
                        <p class="h2 font-weight-bold">{{ round($avg_rating, 1) }}</p>
                        @php
                            $r = (round($avg_rating, 1) * 100) / 500;
                            $rating_percentage = $r * 100;
                        @endphp
                        <div class="rating-box">
                            <div class="rating" style="width:{{ $rating_percentage }}%;"></div>
                        </div>
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
                                        <span>{{ $list->rating }} <i class="fa fa-star active star fa-1x"
                                                aria-hidden="true"></i>
                                    </div>
                                    @php
                                        $perc = number_format($list->percentage, 2);
                                    @endphp
                                    <div class="col-lg-6 col-md-6 col-4">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $perc }}%;" aria-valuenow="25" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-5">
                                        <span class="font-weight-bold mx-2">{{ $list->total_rating }}</span>
                                        <span>({{ number_format($list->percentage, 2) }}) %</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-4 col-md-4 mt-md-0 mt-sm-50 mt-lg-0">
                            <div class="d-flex mt-4">
                                <div class="review_image_content">
                                    <img src="{{ asset('front/assets/images/icon.png') }}" class="img-fluid review_img"
                                        alt="review" title="review">
                                </div>
                                <div class="review_text_content mx-2">
                                    <span class="h3">2 YERAS</span><br />
                                    <small>COLLECTING REVIEWS</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 my-4">
                    <div class="divider-custom">
                        <div class="divider-custom-line"></div>
                        <div class="divider-custom-icon">
                            <i class="fa fa-circle" aria-hidden="true"></i>
                        </div>
                        <div class="divider-custom-line"></div>
                    </div>
                </div>
            </div>



            <div class="row">

                <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <form action="{{ route('review') }}" method="get" id="filterForm">
                            <div class="card-body">

                                <div class="d-flex justify-content-between bottom_border mb-3">
                                    <span class="h5">Filters</span>
                                    <i class="ion-android-funnel"></i>
                                </div>
                                <p>Date</p>
                                <div class="form-check my-2">
                                    <input class="form-check-input filter_date" value="latest" name="filter" type="radio"
                                        {{ request()->get('filter') == 'latest' ? 'checked' : '' }} data-order="latest"
                                        id="latest">
                                    <label class="form-check-label mx-2" for="latest">
                                        Latest
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter_date" value="oldest" name="filter" type="radio"
                                        {{ request()->get('filter') == 'oldest' ? 'checked' : '' }} data-order="oldest"
                                        id="oldest">
                                    <label class="form-check-label mx-2" for="oldest">
                                        Oldest
                                    </label>
                                </div>
                                <p class="bottom_top mt-4">Category</p>
                                <div id="category_rating">
                                    @forelse ($category as $item)
                                        <div class="form-check">
                                            <input class="form-check-input filter_category" value="{{ $item->slug }}"
                                                type="checkbox" value="{{ $item->slug }}" name="category[]"
                                                @if (in_array($item->slug, explode(',', request()->get('category', '')))) checked @endif>
                                            <label class="form-check-label mx-2">
                                                {{ $item->name }}
                                            </label>
                                            <span class="digit">{{ $item->total_reviews }}</span>
                                        </div>
                                    @empty
                                        <p>Category Review Not Found</p>
                                    @endforelse
                                </div>
                                <p class="bottom_top mt-4">Rating</p>
                                <div id="rating_info">
                                    @forelse ($rating_details as $details)
                                        <div class="form-check">
                                            <input class="form-check-input filter_rating" type="checkbox" name="rating[]"
                                                value="{{ $details->rating }}"
                                                @if (in_array($details->rating, explode(',', request()->get('rating', '')))) checked @endif>
                                            <label class="form-check-label mx-2">
                                                {{ $details->rating_title }} ({{ $details->rating }}) <i
                                                    class="fa fa-star active star fa-1x" aria-hidden="true"></i>
                                            </label>
                                            <span class="digit">{{ $details->total_rating }}</span>
                                        </div>
                                    @empty
                                        <p>Rating Not Found</p>
                                    @endforelse
                                </div>
                            </div>
                            <div class="m-3">
                                {{-- <button type="submit" class="btn btn-success mr-2">Filter</button> --}}
                                <button type="buton" class="reset_btn btn btn-dark">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9 mt-md-50 mt-sm-50 mt-lg-0">
                    <div class="row">
                        @forelse ($reviews as $key=> $review)
                            @php
                                $img_url = $review->product->defaultimage->image_url ?? '';
                                $img_alt = $review->product->defaultimage->image_alt ?? '';
                                $img = asset('storage/' . $img_url);
                                $category = $review->product->category->name ?? '';
                                $name = isset($review->user) ? $review->user->name : $review->name;
                                $published_date = date('d.m.Y', strtotime($review->created_at));
                                $user_url = 'https://ui-avatars.com/api/?name=' . $name;
                            @endphp
                            <div class="col-12 col-lg-12 col-md-12 col-sm-12 mb-25">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="single-review mb-0">
                                            <div class="single-review__image">
                                                <img src="{{ $user_url ?? asset('front/assets/images/blank.png') }}"
                                                    class="img-fluid" alt="{{ $name }}"
                                                    title="{{ $name }}">
                                            </div>
                                            <div class="single-review__content">
                                                <!--=======  rating  =======-->
                                                <div class="shop-product__rating">
                                                    <span class="product-rating">
                                                        @for ($i = 0; $i < $review->rating; $i++)
                                                            <i class="fa fa-star active star fa-1x"
                                                                aria-hidden="true"></i>
                                                        @endfor
                                                        @for ($i = 0; $i < 5 - $review->rating; $i++)
                                                            <i class="fa fa-star-o fa-1x" aria-hidden="true"></i>
                                                        @endfor
                                                        <small class="mx-2 font-italic">{{ $review->rating }}/5</small>
                                                        <span class="">Published: {{ $published_date }}</span>
                                                    </span>
                                                </div>
                                                <span>{{ ucwords($name) }}</span>
                                                <!--=======  End of message  =======-->
                                            </div>
                                        </div>
                                        <div class="review_content d-flex">
                                            <img src="{{ $img ?? asset('front/assets/images/blank.png') }}"
                                                title="{{ $img_alt }}" alt="{{ $img_alt }}"
                                                class="img-fluid product_img mr-4">
                                            <div class="my-lg-0 my-md-0 my-3">
                                                <div class="message">
                                                    <b>{{ $review->product->name ?? '' }}</b>
                                                </div>
                                                <div class="message mt-2">
                                                    {{ $review->message ?? '' }}
                                                </div>
                                            </div>
                                        </div>
                                        @if ($review->product)
                                            <a class="lezada-button float-right mt-20"
                                                href="{{ route('product.view', ['slug' => $review->product->slug ?? '']) }}">View
                                                Product</a>
                                        @endif
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
        var filter = {
            rating: @json(explode(',', request()->get('rating'))),
            category: @json(explode(',', request()->get('category'))),
            order: @json(request()->get('filter'))
        };

        $(document).on('click', ".filter_rating", function() {
            var checked = $(this).val();
            if ($(this).is(':checked')) {
                filter.rating.push(checked);
            } else {
                filter.rating.splice($.inArray(checked, filter.rating), 1);
            }
            filterResult(filter);
        });

        $(document).on('click', ".filter_category", function() {
            var checked = $(this).val();
            if ($(this).is(':checked')) {
                filter.category.push(checked);
            } else {
                filter.category.splice($.inArray(checked, filter.category), 1);
            }
            filterResult(filter);
        });

        $(document).on('click', ".filter_date", function() {
            filter.order = $(this).val();
            filterResult(filter);
        });

        function filterResult(filterobj) {
            const params = {};
            const url = `{{ route('review') }}`;

            if (filterobj.category.length) {
                params.category = filterobj.category.join(",");
            }

            if (filterobj.rating.length) {
                params.rating = filterobj.rating.join(",");
            }

            if (filterobj.order) {
                params.filter = filterobj.order;
            }

            const query = $.param(params);
            window.location.href = `${url}?${query}`;
        }



        $(document).on("click", ".reset_btn", function(e) {
            e.preventDefault();
            var url = '{{ route('review') }}';
            var link = url + "?filter=" + 'latest';
            window.location.href = link;
        });
    </script>
@endpush
