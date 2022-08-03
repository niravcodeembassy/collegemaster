<header class="header header-without-topbar header-sticky">
  <div class="header-bottom pt-md-20 pb-md-20 pt-sm-20 pb-sm-20 pt-20">
    <div class="container wide">
      <div class="header-bottom-container">
        <!--=======  logo with off canvas  =======-->
        <div class="logo-with-offcanvas d-flex">
          <!--=======  logo   =======-->
          <div class="logo">
            <a href="{{ url('/') }}">
              <img class="img-fluid" src="{{ asset('storage/' . $frontsetting->logo) }}" alt="At Auros">
            </a>
          </div>
          <!--=======  End of logo   =======-->
        </div>
        <div class="search_form d-none d-lg-block">
          <form>
            <input class="form-control mr-sm-2" type="text" placeholder="find something" aria-label="Search">
            <button type="submit"><i class="ion-ios-search-strong"></i></button>
          </form>
        </div>
        <div class="header-right-container mx-3">
          <!--=======  header right icons  =======-->
          <div class="header-right-icons d-flex justidy-content-end justidy-content-md-end align-items-center h-100 mx-2">
            <!--=======  single-icon  =======-->
            <!--=======  End of single-icon  btn btn btn-outline-secondary rounded-pill =======-->
            <!--=======  single-icon  =======-->
            @guest
              <div class="user-login">
                <a href="{{ route('register') }}" class="px-1 login_link">
                  <b>Join</b>
                </a>
              </div>
              <span class="">|</span>
              <div class="user-login">
                <a href="{{ route('login') }}" class="px-1 login_link">
                  <b>Sign In</b>
                </a>
              </div>
            @endguest
            <!--=======  End of single-icon  =======-->
            <!--=======  single-icon  =======-->
            @auth
              <div class="single-icon user-login">
                <a href="{{ route('profile.index') }}">
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
      <div class="">
        <div class="header-bottom-navigation">
          <div class="d-none d-lg-block  my-lg-2">
            <nav class="site-nav center-menu">
              <ul>
                @foreach ($forntcategory->where('name', '!=', 'All')->take(5) as $item)
                  <li class="menu-item-has-children mx-4">
                    <a href="{{ route('category.product', $item->slug) }}">{{ ucfirst($item->name) }}</a>
                    <ul class="sub-menu single-column-menu">
                      @foreach ($item->subCategory as $list)
                        <li>
                          <a href="{{ route('product.details', ['cat_slug' => $item->slug, 'product_subcategory_slug' => $list->slug, 'slug' => null]) }}">
                            {{ ucfirst($list->name) }}
                          </a>
                        </li>
                      @endforeach
                    </ul>
                  </li>
                @endforeach
                <li class="menu-item-has-children"><a href="{{ route('category.product', 'all') }}">All</a>
                  <ul class="sub-menu single-column-menu">
                    @foreach ($forntcategory as $item)
                      <li>
                        <a href="{{ route('category.product', $item->slug) }}">{{ ucfirst($item->name) }}</a>
                      </li>
                    @endforeach
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
      <div class="single-icon search d-lg-none d-flex justify-content-between">
        <a href="javascript:void(0)" id="offcanvas-about-icon" class="pt-5 mr-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img" focusable="false">
            <title>Menu</title>
            <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
          </svg>
        </a>
        <div class="search_form_mobile">
          <form>
            <input class="form-control mr-sm-2" type="text" placeholder="find something" aria-label="Search">
            <button type="submit"><i class="ion-ios-search-strong"></i></button>
          </form>
        </div>
        @include('frontend.layouts.category_ovelay')
      </div>
    </div>
</header>
