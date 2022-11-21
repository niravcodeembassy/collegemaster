<header class="header header-without-topbar header-sticky">
    <div class="header-bottom pt-md-20 pb-md-20 pt-sm-20 pb-sm-20 pt-20">
        {{-- <div class="main_category">
      <div class="offer_info text-center mx-sm-2">
        <a href="{{ $frontsetting->offer_info_link ?? '' }}" class="offer_info_link py-1"><span class="offer_info_text">{{ $frontsetting->offer_info ?? '' }}</span></a>
      </div>
    </div> --}}
        <div class="container wide mt-lg-0 mt-md-0 mt-3">
            <div class="header-bottom-container">
                <!--=======  logo with off canvas  =======-->
                <div class="logo-with-offcanvas d-flex">
                    <!--=======  logo   =======-->

                    @php
                        $url = request()->segment(1) == null ? url('/') : url(app()->getlocale());
                        $category = \App\Category::whereNull('is_active')
                            ->where('name', '!=', 'All')
                            ->with([
                                'subCategory' => function ($q) {
                                    $q->whereNull('is_active');
                                },
                            ])
                            ->get();
                        $active_category = null;
                        if (\Request::route()->getName() == 'category.product') {
                            $slug = request()->route('slug');
                            $active_category = \App\Category::with('subCategory')
                                ->where('slug', $slug)
                                ->select('id', 'image', 'slug', 'name', 'description', 'meta_title', 'meta_description', 'meta_keywords')
                                ->firstOrFail();
                        }
                        if (\Request::route()->getName() == 'product.details') {
                            $slug = \Request::route('product_subcategory_slug');
                            $subCategory = \App\Model\SubCategory::where('slug', $slug)->firstOrFail();
                            $active_category = \App\Category::findOrFail($subCategory->category_id);
                        }
                        $categoryList = \App\Category::whereNull('is_active')
                            ->withCount([
                                'products' => function ($q) {
                                    $q->where('is_active', 'Yes');
                                },
                            ])
                            ->with([
                                'subCategory' => function ($q) {
                                    $q->whereNull('is_active');
                                },
                            ])
                            ->whereNull('is_active')
                            ->get();
                        $AllProductCount = \App\Model\Product::where('is_active', 'Yes')->count();
                    @endphp
                    <div class="logo">
                        <a href="{{ route('front.home') }}">
                            <img class="img-fluid" src="{{ asset('storage/' . $frontsetting->logo) }}" alt="At Auros"
                                title="At Auros">
                        </a>
                    </div>
                    <!--=======  End of logo   =======-->
                </div>

                <div class="search_form d-none d-lg-block">
                    <form method="get" action="{{ route('category.product', 'all') }}" id="search_form">
                        <input class="form-control mr-sm-2" name="term" value="{{ request('term', null) }}"
                            data-provide="typeahead" type="text" data-url="{{ route('live.search') }}"
                            id="live_search" placeholder="Find Something You'll Love!" aria-label="Search">
                        <input type="hidden" name="flag" value="false">
                        <div class="d-flex justify-content-between main_div">
                            <button type="button" id="search_btn" class="{{ request('term') ? '' : 'd-none' }}"><i
                                    class="fa fa-close"></i></button>
                            <button type="submit"><i class="ion-ios-search-strong"></i></button>
                        </div>
                    </form>
                </div>
                <div class="header-right-container ml-3">
                    <!--=======  header right icons  =======-->
                    <div class="header-right-icons d-flex align-items-center h-100 mx-2">
                        <!--=======  single-icon  =======-->
                        <!--=======  End of single-icon  btn btn btn-outline-secondary rounded-pill =======-->
                        <!--=======  single-icon  =======-->
                        <div class="user-login mr-3">
                            <a href="{{ route('blog') }}" class="px-1 login_link font-weight-bold">
                                Blog
                            </a>
                        </div>
                        @guest
                            <div class="user-login">
                                <a href="{{ route('register') }}" class="px-1 login_link font-weight-bold">
                                    Join
                                </a>
                            </div>
                            <span class="">|</span>
                            <div class="user-login">
                                <a href="{{ route('login') }}" class="px-1 login_link font-weight-bold">
                                    Login
                                </a>
                            </div>
                        @endguest
                        <!--=======  End of single-icon  =======-->
                        <!--=======  single-icon  =======-->
                        @auth
                            <div class="single-icon user-login">
                                <a href="{{ route('orders.list') }}">
                                    <i class="ion-android-person"></i>
                                </a>
                            </div>
                            <div class="single-icon wishlist">
                                <a href="{{ route('wishlist.index') }}" id="offcanvas-wishlist-icon">
                                    <i class="ion-android-favorite-outline"></i>
                                </a>
                            </div>
                        @endauth
                        <!--=======  End of single-icon  =======-->
                        <!--=======  single-icon  =======-->

                        @if (!request()->route()->named('cart.view') &&
                            !request()->route()->named('checkout'))
                            <div class="single-icon cart">
                                <a href="javascript:void(0)" id="offcanvas-cart-icon">
                                    <i class="ion-ios-cart"></i>
                                    <span class="count cart-count">{{ $cartList->count() ?? 0 }}</span>
                                </a>
                            </div>
                        @endif
                        <!--=======  End of single-icon  =======-->
                    </div>
                    <!--=======  End of header right icons  =======-->
                </div>
            </div>
            <div class="single-icon search d-lg-none py-2 d-flex justify-content-between">
                <a href="javascript:void(0)" id="offcanvas-about-icon" class="pt-5 mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                        role="img" focusable="false">
                        <title>Menu</title>
                        <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"
                            d="M4 7h22M4 15h22M4 23h22"></path>
                    </svg>
                </a>
                <div class="search_form_mobile">
                    <form method="get" action="{{ route('category.product', 'all') }}">
                        <input class="form-control mr-sm-2" name="term" value="{{ request('term', null) }}"
                            data-provide="typeahead" type="text" data-url="{{ route('live.search') }}"
                            id="live_search_mobile" placeholder="Find Something You'll Love!" aria-label="Search">
                        <input type="hidden" name="flag" value="false">
                        <div class="d-flex justify-content-between main_div">
                            <button type="button" id="search_mobile_btn"
                                class="{{ request('term') ? '' : 'd-none' }}"><i class="fa fa-close"></i></button>
                            <button type="submit submit_btn"><i class="ion-ios-search-strong"></i></button>
                        </div>
                    </form>
                </div>
                @include('frontend.layouts.category_ovelay')
                {{-- @include('frontend.product.partial.overlay') --}}
            </div>
        </div>


        <div class="main_category  d-none d-lg-block">
            <div class="container wide">
                <div class="header-bottom-navigation text-center d-none d-lg-block mt-lg-2 ">
                    <nav class="site-nav">

                        <button class="left_scroll d-xl-none d-lg-block" onclick="leftScroll()"><i
                                class="fa fa-angle-left fa-lg" aria-hidden="true"></i></button>
                        <ul class="main_list" id="category_scroll">

                            @foreach ($category->skip(0)->take(10) as $item)
                                <li class="menu-item-has-children">
                                    <a href="{{ route('category.product', $item->slug) }}"
                                        class="category_link">{{ ucfirst($item->name) }}</a>
                                    @if ($item->subCategory->count() > 0)
                                        <ul class="sub-menu single-column-menu">
                                            @foreach ($item->subCategory as $list)
                                                <li>
                                                    <a
                                                        href="{{ route('product.details', ['cat_slug' => $item->slug, 'product_subcategory_slug' => $list->slug, 'slug' => null]) }}">
                                                        {{ ucfirst($list->name) }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                            <li class="menu-item-has-children"><a href="{{ route('category.product', 'all') }}"
                                    class="category_link">Other</a>
                                @if ($category->skip(10)->count() > 0)
                                    <ul class="sub-menu single-column-menu">
                                        @foreach ($category->skip(10) as $item)
                                            <li>
                                                <a
                                                    href="{{ route('category.product', $item->slug) }}">{{ ucfirst($item->name) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        </ul>
                        <button class="right_scroll d-xl-none d-lg-block" onclick="rightScroll()"><i
                                class="fa fa-angle-right fa-lg" aria-hidden="true"></i></button>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
