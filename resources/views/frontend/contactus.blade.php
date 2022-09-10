@extends('frontend.layouts.app')
@section('content')
  <div class=" breadcrumb-area   pt-20 pb-20 mb-100" style="background-color: #f5f5f5;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="breadcrumb-title">Contact Us</h1>

          <!--=======  breadcrumb list  =======-->

          <ul class="breadcrumb-list">
            <li class="breadcrumb-list__item"><a href="{{ route('front.home') }}">HOME</a></li>
            <li class="breadcrumb-list__item breadcrumb-list__item--active">contact us</li>
          </ul>

          <!--=======  End of breadcrumb list  =======-->

        </div>
      </div>
    </div>
  </div>
  <div class="section-title-container mb-50">
    <div class="container">

    </div>
  </div>
  <div class="icon-box-area mb-100 mb-sm-70">
    <div class="container">
      <div class="row no-gutters">
        <div class="col-md-4">
          <div class="single-icon-box single-icon-box--color-center-iconbox  single-icon-box--color-center-iconbox--green">
            <div class="icon-box-icon">
              <i class="ti-mobile"></i>
            </div>
            <div class="icon-box-content">
              <h3 class="title">PHONE</h3>
              <p class="content">Phone : {{ $contact->contact ?? '' }}</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="single-icon-box single-icon-box--color-center-iconbox single-icon-box--color-center-iconbox--yellow">
            <div class="icon-box-icon">
              <i class="ti-location-pin"></i>
            </div>
            <div class="icon-box-content">
              <h3 class="title">ADDRESS</h3>
              <p class="content" style="white-space: pre-line;">{{ $contact->address ?? '' }}</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="single-icon-box single-icon-box--color-center-iconbox single-icon-box--color-center-iconbox--blue">
            <div class="icon-box-icon">
              <i class="ti-email"></i>
            </div>
            <div class="icon-box-content">
              <h3 class="title">EMAIL</h3>
              <p class="content">{{ $contact->email ?? '' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="contact-form-area mb-60">
    <div class="container">
      <div class="row mb-5">
        <div class="col-lg-12 mb-5">
          <div class="section-title section-title--one text-left">
            <h1>Get in touch</h1>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8">
          @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>Succeess</strong>
              <p>{{ Session::get('success') }}</p>
            </div>

            <script>
              $(".alert").alert();
            </script>
          @endif
          <div class="lezada-form contact-form">
            <form id="contact-form" action="{{ route('contact-us.stroe') }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-4 mb-40">
                  <input type="text" name="name" placeholder="First Name *" id="customername" required="">
                </div>
                <div class="col-md-4 mb-40">
                  <input type="email" name="email" placeholder="Email *" id="customerEmail" required="">
                </div>
                <div class="col-md-4 mb-40">
                  <input type="text" name="mobile" min="10" max="10" placeholder="Mobile Number *" name="mobile" id="mobile" required="">
                </div>
                <div class="col-lg-12 mb-40">
                  <input type="text" placeholder="Subject" required name="subject" id="subject">
                </div>
                <div class="col-lg-12 mb-40">
                  <textarea cols="30" rows="10" placeholder="Message" name="message" id="message"></textarea>
                </div>
                <div class="col-lg-6 mb-lg-0 mb-40">
                  {!! app('captcha')->display() !!}
                </div>
                <label class="captcha text-danger" style="display:none">This field is required.</label>
                <div class="col-lg-12 text-right">
                  <button type="submit" data-sitekey="6LchyE0aAAAAABk2zPeUNVWNceekKtmUlK8YJ5Zw" data-callback='onSubmit' class="g-recaptcha lezada-button lezada-button--medium" data-action='submit'>Submit</button>
                </div>
              </div>
            </form>
          </div>
          <p class="form-messege pt-10 pb-10 mt-10 mb-10"></p>
        </div>
      </div>
    </div>
  </div>
  {!! NoCaptcha::renderJs() !!}
@endsection

@push('script')
  <script>
    $(".alert").delay(4000).slideUp(200, function() {
      $(this).alert('close');
    });

    $('form').on('submit', function(e) {
      if (grecaptcha.getResponse() == "") {
        e.preventDefault();
        $(".captcha").show();
      } else {
        $('form').submit();
      }
    });
  </script>
@endpush
