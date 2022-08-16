@extends('admin.layouts.app')
@section('title', 'Finance')

@section('breadcrumbs')
  {{-- @include('component.heading',[
'page_title' => 'Payment',
'icon' =>null
])
@endsection --}}

@section('content')

  <div class="container-fluid">
    <form action="{{ route('admin.payment.store') }}" method="POST" name="mailsetupform" id="mailsetupform" enctype="multipart/form-data">
      @csrf()

      <div class="row">

        @include('component.error')

        <div class="col-sm-4">
          <h5 class=""><strong>Payment</strong></h5>
          <p class="text-muted">Here you can define your payment credentials</p>
        </div>

        <div class="col-sm-8 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-none">
                <div class="form-row">
                  <div class="col ">
                    <div class="form-group border-checkbox-section">
                      <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input class="border-checkbox custom-check custom-control-input" type="checkbox" id="paypal" data-target="#paypal_section" data-off="#payumoney" {{ $mailsetup->paypal == 'Yes' ? 'checked' : '' }} name="paypal" value="paypal">
                        <label class="custom-control-label" for="paypal">Use Paypal For Payment</label>
                      </div>
                    </div>
                    <div class="form-group border-checkbox-section">

                      <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success ">
                        <input class="custom-control-input border-checkbox" type="checkbox" id="paypal_sandbox" data-target="#paypal_sandbox" {{ $mailsetup->paypal_sandbox == 'live' ? 'checked' : '' }} name="paypal_sandbox" value="sandbox">
                        <label class="custom-control-label" for="paypal_sandbox">PayPal Live Mode
                          <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top"
                            title="If the live mode is off then it will be working in test(sandbox) modeIf the live mode is off then it will be working in test(sandbox) modeIf the live mode is off then it will be working in test(sandbox) mode."></i>
                        </label>
                      </div>
                      {{-- <div class="border-checkbox-group border-checkbox-group-primary">
                                            <input class="border-checkbox" type="checkbox" id="paypal_sandbox"
                                                data-target="#paypal_sandbox"
                                                {{ $mailsetup->paypal_sandbox == 'sandbox' ? 'checked' :'' }}
                                                name="paypal_sandbox" value="sandbox">
                                            <label class="border-checkbox-label" for="paypal_sandbox">Paypal sandbox</label>
                                        </div> --}}
                    </div>
                  </div>
                </div>
                <div id="paypal_section d-none">
                  <div class="form-row">
                    <div class="col">
                      <div class="form-group">
                        <label for="paypal_client_id">Paypal client id <span class="text-danger">*</span></label>
                        <input id="paypal_client_id" {{ $mailsetup->paypal == 'No' ? 'readonly' : '' }} class="form-control" type="text" name="paypal_client_id" data-rule-required="true" data-msg-required="Paypal client id is required"
                          value="{{ $mailsetup->paypal_client_id ?? '' }}">
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col">
                      <div class="form-group">
                        <label for="paypal_secret">Paypal secret<span class="text-danger">*</span></label>
                        <input id="paypal_secret" {{ $mailsetup->paypal == 'No' ? 'readonly' : '' }} class="form-control" type="password" name="paypal_secret" data-rule-required="true" data-msg-required="Mail host is required"
                          value="{{ $mailsetup->paypal_secret ?? '' }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="d-none">
                <div class="form-row  ">
                  <div class="col border-checkbox-section">
                    <div class="form-group">
                      <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input class="border-checkbox custom-check custom-control-input" type="checkbox" {{ $mailsetup->payumoney == 'Yes' ? 'checked' : '' }} id="payumoney" data-off="#paypal" data-target="#payumoney_section" name="payumoney"
                          value="payumoney">
                        <label class="custom-control-label" for="payumoney">Use PayUmoney For Payment</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input class="border-checkbox custom-check custom-control-input" type="checkbox" id="payumoney_sandbox" {{ $mailsetup->payumoney_sandbox == 'live' ? 'checked' : '' }} name="payumoney_sandbox" value="sandbox">
                        <label class="custom-control-label" for="payumoney_sandbox">PayU Live Mode
                          <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="If the live mode is off then it will be working in test(sandbox) mode."></i>
                        </label>
                      </div>
                    </div>
                    {{-- <div class="form-group border-checkbox-section">
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            <input class="border-checkbox" type="checkbox" id="payumoney_sandbox"
                                                {{ $mailsetup->payumoney_sandbox == 'sandbox' ? 'checked' :'' }}
                                                name="payumoney_sandbox" value="sandbox">
                                            <label class="border-checkbox-label" for="payumoney_sandbox">PayUmoney
                                                sandbox</label>
                                        </div>
                                    </div> --}}
                  </div>
                </div>
                <div id="payumoney_section">
                  <div class="form-row">
                    <div class="col ">
                      <div class="form-group">
                        <label for="payu_key">Key <span class="text-danger">*</span></label>
                        <input id="payu_key" class="form-control" {{ $mailsetup->payumoney == 'No' ? 'readonly' : '' }} type="text" name="payu_key" data-rule-required="true" data-msg-required="Key is required"
                          value="{{ $mailsetup->payu_key ?? '' }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="col">
                      <div class="form-group">
                        <label for="payu_sult">Salt<span class="text-danger">*</span></label>
                        <input id="payu_sult" class="form-control" {{ $mailsetup->payumoney == 'No' ? 'readonly' : '' }} type="password" name="payu_sult" data-rule-required="true" value="{{ $mailsetup->payu_sult ?? '' }}">

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row ">
                <div class="col border-checkbox-section">
                  <div class="form-group">
                    <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-success">
                      <input class="border-checkbox custom-check custom-control-input" type="checkbox" {{ isset($mailsetup->cash) && $mailsetup->cash == 'Yes' ? 'checked' : '' }} id="cash" name="cash" value="razorcashpay">
                      <label class="custom-control-label" for="cash">Cash On Delivery</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-success">
                      <input class="border-checkbox custom-check custom-control-input" type="checkbox" {{ isset($mailsetup->stripe_enable) && $mailsetup->stripe_enable == 'Yes' ? 'checked' : '' }} id="stripe_enable" name="stripe_enable"
                        value="stripe_enable">
                      <label class="custom-control-label" for="stripe_enable">Stripe</label>
                    </div>
                  </div>
                </div>
              </div>
              <hr style="margin-right:-20px;margin-left:-20px;">

              <div>
                <div class="form-row  ">
                  <div class="col border-checkbox-section">
                    <div class="form-group">
                      <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-success">
                        <input class="border-checkbox custom-check custom-control-input" type="checkbox" {{ $mailsetup->stripe == 'Yes' ? 'checked' : '' }} id="stripe" data-off="#paypal,#payu" data-target="#stripe_section" name="stripe"
                          value="stripe">
                        <label class="custom-control-label" for="stripe">Change Key And Secret</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="stripe_section">
                  <div class="form-row">
                    <div class="col ">
                      <div class="form-group">
                        <label for="stripe_key">Key <span class="text-danger">*</span></label>
                        <input id="stripe_key" class="form-control" {{ $mailsetup->stripe == 'No' ? 'readonly' : '' }} type="text" name="stripe_key" data-rule-required="true" value="{{ $mailsetup->stripe_key ?? '' }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="col">
                      <div class="form-group">
                        <label for="stripe_secrete">Secret<span class="text-danger">*</span></label>
                        <input id="stripe_secrete" class="form-control" {{ $mailsetup->stripe == 'No' ? 'readonly' : '' }} type="password" name="stripe_secrete" data-rule-required="true" value="{{ $mailsetup->stripe_secrete ?? '' }}">
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <hr style="margin-right:-20px;margin-left:-20px;">

              <div class="">
                <div class="form-row">
                  <div class="col border-checkbox-section">
                    <div class="form-group">
                      <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-success">
                        <input class="border-checkbox custom-check custom-control-input" type="checkbox" {{ $mailsetup->razorpay == 'Yes' ? 'checked' : '' }} id="razorpay" data-off="#paypal" data-target="#razorpay_section" name="razorpay"
                          value="razorpay">
                        <label class="custom-control-label" for="razorpay">Razorpay </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-success">
                        <input class="border-checkbox custom-check custom-control-input" type="checkbox" id="razorpay_enable" data-off="#paypal,#payu" data-target="#razorpay_section" {{ $mailsetup->razorpay_enable == 'Yes' ? 'checked' : '' }}
                          name="razorpay_enable" value="sandbox">
                        <label class="custom-control-label" for="razorpay_enable">Change Key And Secret
                        </label>
                      </div>
                    </div>

                  </div>
                </div>
                <div id="razorpay_section">
                  <div class="form-row">
                    <div class="col ">
                      <div class="form-group">
                        <label for="razorpay_key">Key <span class="text-danger">*</span></label>
                        <input id="razorpay_key" class="form-control" {{ $mailsetup->Razorpay == 'No' ? 'readonly' : '' }} type="text" name="razorpay_key" data-rule-required="true" data-msg-required="Key is required"
                          value="{{ $mailsetup->razorpay_key ?? '' }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="col">
                      <div class="form-group">
                        <label for="razorpay_secrete">Secret<span class="text-danger">*</span></label>
                        <input id="razorpay_secrete" class="form-control" {{ $mailsetup->Razorpay == 'No' ? 'readonly' : '' }} type="password" name="razorpay_secrete" data-rule-required="true" value="{{ $mailsetup->razorpay_secrete ?? '' }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <hr style="margin-right:-20px;margin-left:-20px;">

              <div class="">
                <div class="form-row">
                  <div class="col border-checkbox-section">
                    <div class="form-group">
                      <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-success">
                        <input class="border-checkbox custom-check custom-control-input" type="checkbox" {{ $mailsetup->twilio == 'Yes' ? 'checked' : '' }} id="twilio" data-off="#paypal" data-target="#twilio_section" name="twilio"
                          value="twilio">
                        <label class="custom-control-label" for="twilio">Twilio </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-success">
                        <input class="border-checkbox custom-check custom-control-input" type="checkbox" id="twilio_enable" data-off="#paypal,#payu" data-target="#twilio_section" {{ $mailsetup->twilio_enable == 'Yes' ? 'checked' : '' }}
                          name="twilio_enable" value="sandbox">
                        <label class="custom-control-label" for="twilio_enable">Change Key And Secret
                        </label>
                      </div>
                    </div>

                  </div>
                </div>
                <div id="twilio_section">
                  <div class="form-row">
                    <div class="col ">
                      <div class="form-group">
                        <label for="twilio_auth_sid">SID <span class="text-danger">*</span></label>
                        <input id="twilio_auth_sid" class="form-control" {{ $mailsetup->twilio == 'No' ? 'readonly' : '' }} type="text" name="twilio_auth_sid" data-rule-required="true" data-msg-required="Sid is required"
                          value="{{ $mailsetup->twilio_auth_sid ?? '' }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="col">
                      <div class="form-group">
                        <label for="twilio_auth_token">Token<span class="text-danger">*</span></label>
                        <input id="twilio_auth_token" class="form-control" {{ $mailsetup->twilio == 'No' ? 'readonly' : '' }} type="password" name="twilio_auth_token" data-rule-required="true" value="{{ $mailsetup->twilio_auth_token ?? '' }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="col">
                      <div class="form-group">
                        <label for="twilio_whatsapp_form">Whatsapp Form<span class="text-danger">*</span></label>
                        <input id="twilio_whatsapp_form" class="form-control" {{ $mailsetup->twilio == 'No' ? 'readonly' : '' }} type="password" name="twilio_whatsapp_form" data-rule-required="true"
                          value="{{ $mailsetup->twilio_whatsapp_form ?? '' }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </div>
          <div class="row">
            <div class="col d-flex justify-content-end">
              <button type="submit" class="btn btn-success shadow" id="btn_save"><i class="ik ik-check-circle"></i>Update</button>
            </div>
          </div>
        </div>
      </div>


    </form>
  </div>

@endsection

@push('js')
  <script type="text/javascript">
    $('#mailsetupform').validate({
      debug: false,
      ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
      rules: {},
      messages: {},
      errorPlacement: function(error, element) {
        // $(element).addClass('is-invalid')
        error.appendTo(element.parent()).addClass('text-danger');
      },
      submitHandler: function(e) {
        return true;
      }
    })
    $(document).ready(function() {

      $('.border-checkbox').on('change', function() {

        var el = $(this);
        console.log(el);
        var off = el.data('off');

        if (el.is('#paypal')) {
          if (el.prop('checked') == true) {
            $(off).prop('checked', false);
          } else {
            $(off).prop('checked', true);
          }

        }

        if (el.is('#payumoney')) {
          if (el.prop('checked') == true) {
            $(off).prop('checked', false);
          } else {
            $(off).prop('checked', true);
          }
        }

        if (el.is('#stripe')) {
          if (el.prop('checked') == true) {
            $(off).prop('checked', false);
          } else {
            $(off).prop('checked', true);
          }
        }

        if (el.is('#razorpay')) {
          if (el.prop('checked') == true) {
            $(off).prop('checked', false);
          } else {
            $(off).prop('checked', true);
          }
        }

        var target = el.data('target');

        if (target == undefined) {
          return false;
        }

        if (el.prop("checked")) {
          $(':input', target).removeAttr('readonly');
        } else {
          $('input', target).attr('readonly', true);
        }

      });

    });
  </script>
@endpush
