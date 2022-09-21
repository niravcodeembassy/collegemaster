<footer>
  <div class="newsletter">
    <div class="container">
      <div class="row d-flex align-items-center">
        <div class="col-lg-2 col-md-4 text-center left pb-lg-0 pb-xl-0 pb-md-2 pb-1">
          <h3 class="text-uppercase text-center text-white p-0 m-0">
            NEWS LETTER
          </h3>
        </div>
        <div class="col-lg-4 col-md-8 left pb-lg-0 pb-xl-0 pb-2">
          <h4 class="text-uppercase px-md-3 px-sm-0 p-0 m-0">
            {{-- LIKED OUR PRODUCTS? GET PROMO CODES &amp; <br>COUPONS BY --}}
            SUBSCRIBING OUR NEWS LETTER
          </h4>
        </div>
        <div class="col-lg-6 col-md-12 right">
          <div class="signup-form">
            <form id="mc-form" action="{{ route('newsletter') }}" class="mc-form">
              <div class="form"><input type="email" placeholder="Your Email" required id="newsletter_email" data-rule-required="true" name="email">
                <input type="submit">
              </div>
              <div id="newsletterValidate"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="footer-top footer-container footer-one pt-70 pb-20 pt-sm-50">
    <div class="container-fluid">
      <div class="row clearfix footer_grid mx-xl-5 mx-2">
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 footer-single-widget review_widget">
          <!--=======  copyright text  =======-->
          <!--=======  logo  =======-->
          <div class="logo">
            <a href="{{ $frontsetting->google_link ?? '' }}" target="_blank">
              <img class="img-fluid mb-2" src="{{ asset('front/assets/images/website_icon/google.png') }}">
            </a>
            <a href="{{ $frontsetting->pilot_link ?? '' }}" target="_blank">
              <img class="img-fluid my-2" src="{{ asset('front/assets/images/website_icon/trust.png') }}">
            </a>
            <a href="{{ $frontsetting->esty_link ?? '' }}" target="_blank">
              <img class="img-fluid my-2" src="{{ asset('front/assets/images/website_icon/etsy.png') }}">
            </a>
          </div>
          <!--=======  End of logo  =======-->
          <!--=======  copyright text  =======-->
          <!--=======  End of copyright text  =======-->
          <!--=======  End of copyright text  =======-->
        </div>
        <div class="col-xl-1 col-lg-2 col-md-4 col-sm-6 footer-single-widget shop_widget">
          <h3 class="widget-title text-uppercase">Shop</h3>
          <!--=======  footer navigation container  =======-->
          <div class="footer-nav-container">
            <nav>
              <ul class="footer-links">
                @if (!is_null($frontsetting->category) && isset($frontsetting->category))
                  @php
                    $category = \App\Category::whereIn('id', $frontsetting->category)->get();
                  @endphp
                  @foreach ($category as $list)
                    <li>
                      <h4><a href="{{ route('category.product', ['slug' => $list->slug]) }}">
                          {{ $list->name }}
                        </a>
                      </h4>
                    </li>
                  @endforeach
                @endif
              </ul>
            </nav>
          </div>
          <!--=======  single widget  =======-->

          <!--=======  End of footer navigation container  =======-->
          <!--=======  single widget  =======-->
        </div>
        <div class="col-xl-1 col-lg-1 col-md-4 col-sm-4 footer-single-widget shop_widget">
          <h3 class="widget-title text-uppercase">ABOUT</h3>
          <!--=======  footer navigation container  =======-->
          <div class="footer-nav-container">
            <nav>
              <ul class="footer-links">
                <li>
                  <h4><a href="{{ route('page.about') }}">About us</a></h4>
                </li>
                <li>
                  <h4><a href="{{ route('blog') }}">Blog</a></h4>
                </li>
                <li>
                  <h4><a href="{{ route('contact-us.index') }}">Contact</a></h4>
                </li>
                <li>
                  <h4><a href="{{ route('page.story') }}">Our Story</a></h4>
                </li>
              </ul>
            </nav>
          </div>
          <!--=======  single widget  =======-->

          <!--=======  End of footer navigation container  =======-->
          <!--=======  single widget  =======-->
        </div>
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 footer-single-widget">
          <h3 class="widget-title text-uppercase">policies</h3>
          <!--=======  footer navigation container  =======-->
          <div class="footer-nav-container">
            <nav>
              <ul class="footer-links">
                <li>
                  <h4><a href="{{ route('page.policy') }}">Privacy Policy</a></h4>
                </li>
                <li>
                  <h4><a href="{{ route('page.photo') }}">Photos Policy</a></h4>
                </li>
                <li>
                  <h4><a href="{{ route('page.cookie') }}">Cookies Policy</a></h4>
                </li>
                <li>
                  <h4><a href="{{ route('page.returns') }}">Shipping & Returns Policy</a></h4>
                </li>
                <li>
                  <h4><a href="{{ route('page.term') }}">Terms & Conditions</a></h4>
                </li>
              </ul>
            </nav>
          </div>
          <!--=======  single widget  =======-->

          <!--=======  End of footer navigation container  =======-->
          <!--=======  single widget  =======-->
        </div>
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 footer-single-widget">
          <h3 class="widget-title text-uppercase"> help topics</h3>
          <!--=======  footer navigation container  =======-->
          <div class="footer-nav-container">
            <nav>
              <ul class="footer-links">
                <li>
                  <h4><a href="{{ route('page.order.place') }}">How To Place Order</a></h4>
                </li>
                <li>
                  <h4><a href="{{ route('page.send.photo') }}">How To Send Us Photos</a></h4>
                </li>
                <li>
                  <h4><a href="{{ route('page.photo.send') }}">How Many Photos To Send</a></h4>
                </li>
                <li>
                  <h4><a href="{{ route('page.save.change') }}">How To Send Us Changes</a></h4>
                </li>
                <li>
                  <h4><a href="{{ route('page.delivery.time') }}">Estimated Delivery Time</a></h4>
                </li>
              </ul>
            </nav>
          </div>

          <!--=======  single widget  =======-->

          <!--=======  End of footer navigation container  =======-->
          <!--=======  single widget  =======-->
        </div>
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 footer-single-widget">
          <!--=======  single widget  =======-->
          <div class="footer-subscription-widget">
            <h3 class="footer_heading reg-office text-uppercase">Registered Office:</h3>
            <p class="about marginB20">
              {{ $frontsetting->address ?? '' }}
            </p>
            <h3 class="footer_heading text-uppercase">Call Support:</h3>
            <p class="about marginB20">
              Call at
              <a href="tel:{{ $frontsetting->contact }}" class="" style="color: rgb(252, 88, 47);">{{ $frontsetting->contact }}</a><br>
              We are here to help you on all working days between 10:00 AM to
              07:00 PM
            </p>
            <h5 class="footer-title d-none">We Accept</h5>
            <ul class="footer-links d-none">
              <li><img src="{{ asset('front/assets/images/payment/payment_icon.png') }}" alt="Payment" class="img-responsive"></li>
            </ul>
            <div class="d-flex">
              <section class="f-50">
                <h3 class="footer_heading text-uppercase">Follow us</h3>
                <ul class="footer-links list-inline social-link">
                  @if ($frontsetting->facebook)
                    <li><a href="{{ $frontsetting->facebook }}"> <i class="fa fa-facebook"></i></a></li>
                  @endif
                  @if ($frontsetting->instagram)
                    <li><a href="{{ $frontsetting->instagram }}"> <i class="fa fa-instagram"></i></a></li>
                  @endif
                  @if ($frontsetting->whatsapp)
                    <li><a href="{{ $frontsetting->whatsapp }}"> <i class="fa fa-whatsapp"></i></a></li>
                  @endif
                  @if ($frontsetting->linkedin)
                    <li><a href="{{ $frontsetting->linkedin }}"> <i class="fa fa-linkedin"></i></a></li>
                  @endif
                  @if ($frontsetting->twitter)
                    <li><a href="{{ $frontsetting->twitter }}"> <i class="fa fa-twitter"></i></a></li>
                  @endif
                  @if ($frontsetting->pinterest)
                    <li><a href="{{ $frontsetting->pinterest }}"> <i class="fa fa-pinterest"></i></a></li>
                  @endif
                </ul>
              </section>
              <section class="f-50-logo">
                <a href="{{ route('front.home') }}">
                  <img class="img-fluid" src="{{ asset('storage/' . $frontsetting->logo) }}" alt="At Auros">
                </a>
              </section>
            </div>
          </div>
          <!--=======  End of single widget  =======-->
        </div>
      </div>
    </div>

    <!--=======  WHATSAPP D =======-->
    <div class="whatsapp-sec" style="z-index:90000">
      <a href="https://api.whatsapp.com/send?phone=919898142002" target="_blank">
        <img src="{{ asset('storage/setting/') }}/whatsapp.svg" class="whatsapp-img" />
      </a>
    </div>
    <!--=======  END WHATSAP  =======-->

  </div>
  <div class="footer site-footer footer-bottom">
    <div class="col-md-12">
      <p class="text-center text-white">
        {{ $frontsetting->copyrights }}
      </p>
    </div>
  </div>

</footer>


<!--=====  End of footer area  ======-->
<!--=============================================
                 =            overlay items         =
                 =============================================-->
<!--=======  about overlay  =======-->

<!--=======  End of about overlay  =======-->
<!--=======  wishlist overlay  =======-->

<!--=======  End of wishlist overlay  =======-->

<!--=======  cart overlay  =======-->
<div class="cart-overlay" id="cart-overlay">
  <div class="cart-overlay-close inactive"></div>
  <div class="cart-overlay-content">
    <!--=======  close icon  =======-->
    <span class="close-icon" id="cart-close-icon">
      <a href="javascript:void(0)">
        <i class="ion-android-close"></i>
      </a>
    </span>
    <!--=======  End of close icon  =======-->
    <!--=======  offcanvas cart content container  =======-->
    <div class="offcanvas-cart-content-container">
      <h3 class="cart-title">Cart</h3>
      <div class="cart-product-wrapper" id="cart-product-wrapper">
        @include('frontend.cart.cart_overlay', ['cartList' => $cartList])
      </div>
    </div>
    <!--=======  End of offcanvas cart content container   =======-->
  </div>
</div>
<!--=======  End of cart overlay  =======-->

<!--=======  search overlay  =======-->
{{-- <div class="search-overlay" id="search-overlay">
  <!--=======  close icon  =======-->
  <span class="close-icon search-close-icon">
    <a href="javascript:void(0)" id="search-close-icon">
      <i class="ti-close"></i>
    </a>
  </span>
  <!--=======  End of close icon  =======-->
  <!--=======  search overlay content  =======-->
  <div class="search-overlay-content">
    <div class="input-box">
      <form action="https://live.hasthemes.com/html/3/lezada-preview/lezada/index.html">
        <input type="search" placeholder="Search Products...">
      </form>
    </div>
    <div class="search-hint">
      <span># Hit enter to search or ESC to close</span>
    </div>
  </div>
  <!--=======  End of search overlay content  =======-->
</div> --}}
<!--=======  End of search overlay  =======-->
<!--=====  End of overlay items  ======-->



@push('script')
  <script>
    $(document).ready(function() {
      $('#mc-form').validate({
        errorClass: "text-danger",
        errorPlacement: function(error, element) {
          error.appendTo($('#newsletterValidate'));
        },
        submitHandler: function(form, event) {

          event.preventDefault();
          var datastring = $(form).serialize();
          var url = $(form).attr('action');

          $.ajax({
            type: "POST",
            url: url,
            data: datastring
          }).always(function(res) {
            $('#newsletter_email').val(null);
          }).done(function(res) {
            $.toast({
              position: 'top-right',
              text: res.message,
              loader: false,
            })
          });
        }
      });
    });
  </script>
@endpush
