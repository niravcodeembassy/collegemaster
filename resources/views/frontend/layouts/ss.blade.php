<footer>
  <div class="newsletter">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h2 class="text-uppercase Vogue header_title text-center text-white">
            GET OUR LATEST OFFERS IN YOUR INBOX
          </h2>
        </div>
        <div class="col-sm-4 py-2 py-lg-0 py-md-0 left">
          <h4>
            LIKED OUR PRODUCTS? GET PROMO CODES &amp; <br>COUPONS BY
            SUBSCRIBING!
          </h4>
        </div>
        <div class="col-sm-8 right">
          <div class="signup-form">
            <form id="mc-form" action="{{ route('newsletter') }}" class="mc-form">
              <div class="form"><input type="email" placeholder="Your Email" required id="newsletter_email"
                  data-rule-required="true" name="email">
                <input type="submit">
              </div>
              <div id="newsletterValidate"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-top">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="logo">
            <a href="{{ url('/') }}">
              <img class="img-fluid" src="{{ asset('storage/'.$frontsetting->logo ) }}" alt="At Auros">
            </a>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <h4 class="footer-title mob-accordion">
            ABOUT
          </h4>
          <ul class="footer-links mob-accordion-data">
            <li><a href="{{ route('page.about') }}">About us</a></li>
            <li><a href="{{ route('blog') }}">Blog</a></li>
            <li><a href="{{ route('contact-us.index') }}">Contact</a></li>
          </ul>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <h4 class="footer-title mob-accordion">
            USEFUL LINKS
          </h4>
          <ul class="footer-links mob-accordion-data">
            <li><a href="{{ route('page.policy') }}">Privacy Policy</a></li>
            <li><a href="{{ route('page.returns') }}">Shipping & Returns Policy</a></li>
            <li><a href="{{ route('page.term') }}">Term and Conditions</a></li>
            <li><a href="{{ route('page.faq') }}">FAQ</a></li>
          </ul>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <h4 class="footer-title reg-office">Registered Office:</h4>
          <p class="about marginB20"><strong>MEMORY WALL</strong><br>
            {{$frontsetting->address ?? ''}}
          </p>
          <h4 class="footer-title">Call Support:</h4>
          <p class="about marginB20">
            Call at
            <a href="/tel:+918200324798" class="" style="color: rgb(252, 88, 47);">{{ $frontsetting->contact}}</a><br>
            We are here to help you on all working days between 10:00 AM to
            07:00 PM
          </p>
          <h4 class="footer-title d-none">We Accept</h4>
          <ul class="footer-links d-none">
            <li><img src="/images/payment_icon.png" alt="Payment" class="img-responsive"></li>
          </ul>
          <h4 class="footer-title">FOLLOW US</h4>
          <ul class="footer-links list-inline social-link">
            @if ($frontsetting->facebook)
            <li><a href="{{$frontsetting->facebook}}"> <i class="fa fa-facebook"></i></a></li>
            @endif
            @if ($frontsetting->instagram)
            <li><a href="{{$frontsetting->instagram}}"> <i class="fa fa-instagram"></i></a></li>
            @endif
            @if ($frontsetting->whatsapp)
            <li><a href="{{$frontsetting->whatsapp}}"> <i class="fa fa-whatsapp"></i></a></li>
            @endif
            @if ($frontsetting->linkedin)
            <li><a href="{{$frontsetting->linkedin}}"> <i class="fa fa-linkedin"></i></a></li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="footer site-footer footer-bottom">
    <div class="col-md-12">
      <p class="text-center text-white">
        {{$frontsetting->copyrights}}
      </p>
    </div>
  </div>
</footer>
@push('script')
<script>
  $(document).ready(function () {
                    $('#mc-form').validate({
                      errorClass: "text-danger",
                        errorPlacement: function(error, element) {
                            error.appendTo($('#newsletterValidate'));
                        },
                        submitHandler: function(form ,event) {

                            event.preventDefault();
                            var datastring = $(form).serialize();
                            var url = $(form).attr('action');

                            $.ajax({
                                type: "POST",
                                url: url,
                                data: datastring
                            }).always(function(res){
                                $('#newsletter_email').val(null);
                            }).done(function(res){
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
