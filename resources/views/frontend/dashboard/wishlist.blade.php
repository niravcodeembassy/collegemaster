@extends('frontend.layouts.app')

@push('style')

@endpush

@push('css')

@endpush

@section('content')

    @include('frontend.layouts.banner',[
        'pageTitel' => $title ?? '',
    ])
    <section class="section-b-space">
        <div class="container ">
        <div class="row mt-80 mb-80">
            @include('frontend.dashboard.sidebar')
            <div class="col-lg-9">
                <div class="dashboard-right">
                    <h3>WISHLIST</h3>
                    <div class="dashboard">
                        @if (isset($buytogetherproducts) && $buytogetherproducts->count()  > 0 )
                        <div class="row product-isotope shop-product-wrap ">
                            @foreach ($buytogetherproducts as $product)
                                <!--=======  single product  =======-->
                                <div class="col-12 col-md-6 col-sm-6 mb-45 sale col-lg-4">
                                    <div class="single-product">
                                        <!--=======  single product image  =======-->
                                        @php
                                            $priceData = Helper::productPrice($product);
                                        @endphp
                                        <div class="single-product__image">

                                            <a class="image-wrap" href="{{ route('product.details' , ['slug' => $product->slug ]) }}">
                                                @foreach ($product->images->take(2) as $item)
                                                    <img src="{{ $item->variant_image }}" class="img-fluid" alt="{{ $item->image_alt ?? '' }}">
                                                @endforeach
                                            </a>

                                            @auth
                                            <div class="single-product__floating-icons">
                                                <span class="wishlist">
                                                    @if ($product->wish_lists_id)
                                                        <a href="javascript:void(0)"
                                                            class="has-wish-lists bg-danger"
                                                            data-remove="true"
                                                            data-url="{{ route('wishlist.add.remove',['variant_id' => $product->variant_id]) }}" >
                                                            <i class="ion-android-favorite-outline text-white"></i>
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0)"
                                                            class="has-wish-lists"
                                                            data-url="{{ route('wishlist.add.remove',['variant_id' => $product->variant_id]) }}" >
                                                            <i class="ion-android-favorite-outline"></i>
                                                        </a>
                                                    @endif
                                                </span>
                                            </div>

                                            @endauth

                                        </div>

                                        <!--=======  End of single product image  =======-->

                                        <!--=======  single product content  =======-->

                                        <div class="single-product__content">
                                            <div class="title">
                                                <h3>
                                                    <a href="{{ route('product.details' , ['slug' => $product->slug ,'variant' => $product->variant_id]) }}">{{  $product->name  }}</a>
                                                </h3>
                                                <a href="{{ route('product.details' , ['slug' => $product->slug,'variant' => $product->variant_id]) }}">
                                                    VIEW PRODUCT
                                                </a>
                                            </div>
                                            <div class="price">
                                                @if ($priceData->offer_price)
                                                    <span class="main-price discounted">{{ $priceData->offer_price }}</span>
                                                @endif
                                                <span class="main-price">{{ $priceData->price  }}</span>
                                            </div>
                                        </div>

                                        <!--=======  End of single product content  =======-->
                                    </div>

                                </div>
                                <!--=======  End of single product  =======-->
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="col-lg-12 d-flex justify-content-center mt-30">
                                {{ $buytogetherproducts->links() }}
                            </div>
                        </div>
                        @else
                            <h4>You have no wishlist</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

@endsection
