<header class="header header-without-topbar header-sticky">
    <!--=======  header bottom  =======-->
    <div class="header-bottom pt-md-20 pb-md-20 pt-sm-20 pb-sm-20">
        <div class="container wide">
            <!--=======  header bottom container  =======-->
            <div class="header-bottom-container">
                <!--=======  logo with off canvas  =======-->
                <div class="logo-with-offcanvas d-flex">
                    <!--=======  logo   =======-->
                    <div class="logo">
                        <a href="{{ url('/') }}">
                            <img class="img-fluid" src="{{ asset('storage/'.$frontsetting->logo) }}" alt="At Auros">
                        </a>
                    </div>
                    <!--=======  End of logo   =======-->
                </div>
                <!--=======  End of logo with off canvas  =======-->

                <!--=======  header bottom navigation  =======-->
                <div class="header-bottom-navigation">
                    <div class="site-main-nav d-none d-lg-block">
                        <nav class="site-nav center-menu">
                            <ul>
                                <li class="">
                                    <a href="{{ url('/') }}">Home</a>
                                </li>
                                <li class="menu-item-has-children"><a href="javascript:void(0)">Shop</a>
                                    <ul class="sub-menu single-column-menu">
                                      <li><a href="{{ route('category.product' , 'all') }}"> All</a></li>
                                        @foreach($forntcategory as $item)
                                        <li>
                                            <a
                                                href="{{ route('category.product' , $item->slug) }}">{{ ucfirst($item->name) }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="">
                                    <a href="{{ route('contact-us.index') }}">Contact Us</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!--=======  End of header bottom navigation  =======-->
                <!--=======  headeer right container  =======-->
                <div class="header-right-container">
                    <!--=======  header right icons  =======-->
                    <div class="header-right-icons d-flex justify-content-end align-items-center h-100">
                        <!--=======  single-icon  =======-->
                        {{-- <div class="single-icon search">
                            <a href="javascript:void(0)" id="search-icon">
                                <i class="ion-ios-search-strong"></i>
                            </a>
                        </div> --}}

                        <!--=======  End of single-icon  =======-->
                        <!--=======  single-icon  =======-->
                        @auth
                        <div class="single-icon user-login">
                            <a href="{{ route('profile.index') }}">
                                <i class="ion-android-person"></i>
                            </a>
                        </div>
                        @else
                        <div class="single-icon user-login">
                            <a href="{{ route('login') }}">
                                <i class="ion-android-person"></i>
                            </a>
                        </div>
                        @endauth

                        <!--=======  End of single-icon  =======-->
                        <!--=======  single-icon  =======-->
                        @auth
                        <div class="single-icon wishlist">
                            <a href="{{ route('wishlist.index') }}" id="offcanvas-wishlist-icon">
                                <i class="ion-android-favorite-outline"></i>
                            </a>
                        </div>
                        @endauth
                        <!--=======  End of single-icon  =======-->
                        <!--=======  single-icon  =======-->
                        {{-- @auth --}}
                        @if(!request()->route()->named('cart.view') && !request()->route()->named('checkout'))
                            <div class="single-icon cart">
                                <a href="javascript:void(0)" id="offcanvas-cart-icon">
                                    <i class="ion-ios-cart"></i>
                                    <span class="count cart-count">{{ $cartList->count() ?? 0 }}</span>
                                </a>
                            </div>
                        @endif
                        {{-- @endauth --}}
                        <!--=======  End of single-icon  =======-->
                    </div>
                    <!--=======  End of header right icons  =======-->
                </div>
                <!--=======  End of headeer right container  =======-->
            </div>
            <!--=======  End of header bottom container  =======-->
            <!-- Mobile Navigation Start Here -->
            <div class="site-mobile-navigation d-block d-lg-none">
                <div id="dl-menu" class="dl-menuwrapper site-mobile-nav">
                    <!--Site Mobile Menu Toggle Start-->
                    <button class="dl-trigger hamburger hamburger--spin">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                    <!--Site Mobile Menu Toggle End-->
                    <ul class="dl-menu dl-menu-toggle">
                        <li class="">
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li>
                            <a href="#">Shop</a>
                            <ul class="dl-submenu">
                                @foreach ($forntcategory as $item)
                                <li>
                                    <a
                                        href="{{ route('category.product' , $item->slug) }}">{{ ucfirst($item->name) }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('contact-us.index') }}">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Mobile Navigation End Here -->
        </div>
    </div>
    <!--=======  End of header bottom  =======-->
</header>
