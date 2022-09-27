@extends('frontend.layouts.app')

@php
$schema_organization = Schema::organizationSchema();
$schema_local = Schema::localSchema();

$schema_organization = json_encode($schema_organization, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$schema_local = json_encode($schema_local, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

$schema = [$schema_organization, $schema_local];
@endphp

@push('css')
  <link href="{{ asset('front/assets/css/auth.css') }}" rel="stylesheet" type="text/css" />
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
      {{-- <img class="position-absolute fixed-top ms-auto w-50 h-100 z-index-0 d-none d-sm-none d-md-block border-radius-section border-top-end-radius-0 border-top-start-radius-0 border-bottom-end-radius-0"
        src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved8.jpg" alt="image"> --}}

      <div class="col-6 image_content d-lg-flex d-none w-50 z-index-0 d-sm-none d-md-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center">
          <img src="{{ asset('front/assets/images/pattern-lines.svg') }}" alt="pattern-lines" class="position-absolute opacity-4 start-0">
          <div class="position-relative">
            <img class="max-width-500 w-100 position-relative z-index-2" src="{{ asset('front/assets/images/chat.png') }}" alt="image">
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
                    <label>First Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input type="text" name="name" class="form-control form-control-lg" placeholder="First Name *" id="customername" required="">
                    </div>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label>Email <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input type="email" class="form-control form-control-lg" placeholder="Email *" required="">
                    </div>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label>Mobile Number <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input type="text" name="mobile" class="form-control form-control-lg" min="10" max="10" placeholder="Mobile Number *" name="mobile" id="mobile" required="">
                    </div>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label>Subject <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <textarea rows="3" placeholder="Subject *" class="form-control" name="subject" id="subject"></textarea>
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
