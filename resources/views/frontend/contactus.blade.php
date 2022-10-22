@extends('frontend.layouts.app')

@section('title')
  {{ $title }}
@endsection

@php
  $schema_organization = Schema::organizationSchema();
  $schema_local = Schema::localSchema();
  $review_schema = Schema::reviewSchema();

  $schema_review = json_encode($review_schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  $schema_organization = json_encode($schema_organization, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  $schema_local = json_encode($schema_local, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

  $schema = [$schema_organization, $schema_local, $schema_review];
@endphp

@push('css')
  <link href="{{ asset('front/assets/css/auth.css') }}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{ asset('front/assets/build/css/intlTelInput.css') }}">
@endpush

@section('schema')
  @foreach ($schema as $key => $list)
    <x-schema>
      {!! $list !!}
    </x-schema>
  @endforeach
@endsection

@section('content')
  <div class="auth-header min-vh-100">
    <div>


      <div class="col-6 image_content d-lg-flex d-none w-50 z-index-0 d-sm-none d-md-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center">
          <img src="{{ asset('front/assets/images/pattern-lines.svg') }}" alt="pattern-lines" title="pattern-lines" class="position-absolute opacity-4 start-0">
          <div class="position-relative">
            <img class="max-width-500 w-100 position-relative z-index-2" src="{{ asset('front/assets/images/chat.png') }}" alt="image" title="image">
          </div>
          <div class="mx-auto text_content">
            <h4 class="text-white font-weight-bolder">Your journey starts here</h4>
            <p class="text-white">Just as it takes a company to sustain a product, it takes a community to sustain a protocol.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-7 d-flex justify-content-center mt-lg-0 mt-4 flex-column">
          <div class="card d-flex blur justify-content-center p-4 shadow-lg my-sm-0 my-sm-6 mt-8 mb-5">
            <div class="text-center">
              <h3 class="text-gradient">Contact us</h3>
              <p class="mb-0" style="color:#67748e">
                For further questions, including partnership opportunities, please email
                {{ $contact->email ?? '' }}
                or contact using our contact form.
              </p>
            </div>

            <form id="contact-form" class="auth_form" method="post" autocomplete="off" action="{{ route('contact-us.stroe') }}">
              @csrf
              <div class="card-body pb-2">
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
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label>First Name </label>
                    <div class="input-group">
                      <input type="text" name="name" class="form-control form-control-lg" placeholder="First Name" id="customername">
                    </div>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label>Email </label>
                    <div class="input-group">
                      <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" data-rule-email="true">
                    </div>
                  </div>

                  <div class="col-md-12 mb-3">
                    <input type="hidden" id="code" name="country_code" value="+1">
                    <label>Mobile Number </label>
                    <div class="input-group">
                      <input type="text" class="form-control form-control-lg telephone" placeholder="Mobile Number" name="mobile" id="mobile">
                      <label id="mobile-error" class="error text-danger" for="phone"></label>
                    </div>
                  </div>

                  <div class="col-md-12 mb-3">
                    <label>Subject </label>
                    <div class="input-group">
                      <textarea rows="3" placeholder="Subject" class="form-control" name="subject" id="subject"></textarea>
                    </div>
                  </div>
                  <div class="col-md-12 mb-2">
                    <label>Message</label>
                    <div class="input-group">
                      <textarea rows="3" placeholder="Message" class="form-control" name="message" id="message"></textarea>
                    </div>
                  </div>
                  <div class="col-md-12 mt-2">
                    {!! app('captcha')->display() !!}
                    <span class="captcha text-danger" style="display:none">captcha is required.</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 text-center">
                    <button type="submit" class="auth_btn btn text-uppercase text-white bg-gradient-primary  w-100 mt-4 mb-0">
                      Send Message
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  {!! NoCaptcha::renderJs() !!}
@endsection

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
  <script src="{{ asset('front/assets/build/js/intlTelInput.min.js') }}"></script>
  <script src="{{ asset('front/assets/build/js/intlTelInput-jquery.min.js') }}"></script>
@endpush

@push('script')
  <script>
    $(".alert").delay(4000).slideUp(200, function() {
      $(this).alert('close');
    });

    var input = document.querySelector("#mobile");
    let iti = window.intlTelInput(input, {
      formatOnDisplay: true,
      autoPlaceholder: "polite",
      initialDialCode: true,
      americaMode: false,
      separateDialCode: true,
      preferredCountries: ["us"],
    });


    $('#mobile').on('countrychange', function(e) {
      var Code = iti.getSelectedCountryData().dialCode;
      $('#code').val("+" + Code);
    });

    $('form').on('submit', function(e) {
      if (grecaptcha.getResponse() == "") {
        e.preventDefault();
        $(".captcha").show();
        var countryCode = iti.getSelectedCountryData().dialCode;
        $('#code').val("+" + countryCode);
      } else {
        $('form').submit();
      }
    });


    // $('#mobile').keyup(function() {
    //   var mobile_no = $(this).val();
    //   var country_code = iti.getSelectedCountryData().dialCode;
    //   var phone = "+" + country_code + "" + mobile_no;
    //   var regex = /^\+(?:[0-9] ?){6,14}[0-9]$/;
    //   if (regex.test(phone)) {
    //     $('#mobile-error').text('');
    //     return true;
    //   } else {
    //     $('#mobile-error').text('Please Enter Valid Mobile No');
    //     return false;
    //   }
    // });

    $.validator.addMethod('customphone', function(value, element, params) {
      var code = iti.getSelectedCountryData().dialCode;
      var phone = "+" + code + "" + value;
      return params.test(phone);
    }, "Please Enter Valid Mobile No");

    jQuery.validator.addClassRules("telephone", {
      customphone: /^\+(?:[0-9] ?){6,14}[0-9]$/,
    });

    // jQuery.validator.addMethod("lettersonly", function(value, element) {
    //   return this.optional(element) || /^[a-z]+$/i.test(value);
    // }, "Letters only please");

    $("#contact-form").validate({
      debug: false,
      rules: {
        // name: {
        //   lettersonly: true
        // },
      },
      errorPlacement: function(error, element) {
        if (element.parent('.iti ').length) {
          error.insertAfter(element.parent()).addClass('text-danger');
        } else {
          error.appendTo(element.parent()).addClass('text-danger')
        }
      },
    });
  </script>
@endpush
