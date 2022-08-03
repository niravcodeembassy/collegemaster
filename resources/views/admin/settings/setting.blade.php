@extends('admin.layouts.app')
@push('style')
  <style type="text/css">
    .page-header .page-header-title i {
      float: left;
      width: 40px;
      height: 40px;
      border-radius: 5px;
      margin-right: 15px;
      vertical-align: middle;
      font-size: 22px;
      color: #fff;
      display: inline-flex;
      -webkit-justify-content: center;
      -moz-justify-content: center;
      -ms-justify-content: center;
      justify-content: center;
      -ms-flex-pack: center;
      -webkit-align-items: center;
      -moz-align-items: center;
      -ms-align-items: center;
      align-items: center;
      -webkit-box-shadow: 0 2px 12px -3px rgba(0, 0, 0, 0.5);
      -moz-box-shadow: 0 2px 12px -3px rgba(0, 0, 0, 0.5);
      box-shadow: 0 2px 12px -3px rgba(0, 0, 0, 0.5);
    }

    .settings li {
      font-size: 18px;
      font-weight: 400;
    }

    .settings li i {
      padding-right: 15px;

    }
  </style>
@endpush
@section('content')

  @component('component.heading',
      [
          'page_title' => '',
          'icon' => 'ik ik-navigation',
          'tagline' => 'Lorem ipsum dolor sit amet.',
          'action' => route('admin.website-setting'),
          'action_icon' => 'fa fa-arrow-left',
          'text' => 'Back',
      ])
  @endcomponent
  <div class="row mt-4">

    @include('admin.settings.sidebar', [
        'heading' => 'Setting',
        'description' => 'Here you can define all the information about tour site ',
    ])

    <div class="col-sm-12 col-md-8 ">
      <form action="{{ route('admin.settings.store') }}" id="settingsForm" enctype="multipart/form-data" method="post">
        @csrf
        <div class="card ">
          <div class="card-body">
            <div class="row ">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="store_name">Store name <span class="text-danger">*</span> </label>
                  <input required id="store_name" value="{{ $setting->response->store_name ?? '' }}" class="form-control" type="text" name="store_name">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="email">Email <span class="text-danger">*</span></label>
                  <input required id="email" class="form-control" value="{{ $setting->response->email ?? '' }}" type="text" name="email">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="contact">Contact Us <span class="text-danger">*</span></label>
                  <input required id="contact" value="{{ $setting->response->contact ?? '' }}" class="form-control" type="text" name="contact">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="country">Country <span class="text-danger">*</span></label>
                  <input required id="country" value="{{ $setting->response->country ?? '' }}" class="form-control" type="text" name="country">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="state">State <span class="text-danger">*</span></label>
                  <input required id="state" value="{{ $setting->response->state ?? '' }}" class="form-control" type="text" name="state">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="city">City <span class="text-danger">*</span></label>
                  <input required id="city" value="{{ $setting->response->city ?? '' }}" class="form-control" type="text" name="city">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="postal_code">Postal code <span class="text-danger">*</span></label>
                  <input required id="postal_code" value="{{ $setting->response->postal_code ?? '' }}" class="form-control" type="text" name="postal_code">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="address">Address</label>
                  <textarea class="form-control" name="address" id="address" rows="4">{{ $setting->response->address ?? '' }}</textarea>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="copyrights">Copyright <span class="text-danger">*</span></label>
                  <input required id="copyrights" value="{{ $setting->response->copyrights ?? '' }}" class="form-control" type="text" name="copyrights">
                </div>
              </div>
            </div>
            <hr>
            <div class="row">

              <div class="col-sm-12 col-md-2 clearfix ">
                @include('component.imagepriview', ['height' => '100px', 'label' => 'Logo', 'name' => 'logo', 'id' => 'logo', 'priview' => $setting->logo ?? null])
              </div>
              <div class="col-sm-12 col-md-2 clearfix ">
                @include('component.imagepriview', ['height' => '100px', 'label' => 'Favicon', 'name' => 'favicon', 'id' => 'favicon', 'priview' => $setting->favicon ?? null])
              </div>
            </div>
            <hr style="margin:15px -20px">
            <div class="row">
              <h5 class="pl-2 mb-3">SEO</h5>
              <br>
              <div class="col-sm-12">
                <div class="form-group">
                  <label class="form-label fs-6 fw-bolder mb-3" for="title">Meta Title <span class="text-danger">*</span></label>
                  <input required id="title" value="{{ $setting->response->meta_title ?? '' }}" class="form-control form-control-solid" type="text" name="meta_title">
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label class="form-label fs-6 fw-bolder mb-3" for="keyword">Meta Keyword <span class="text-danger">*</span></label>
                  <input required id="keyword" value="{{ $setting->response->meta_keywords ?? '' }}" class="form-control form-control-solid" type="text" name="meta_keywords">
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label class="form-label fs-6 fw-bolder mb-3" for="description">Meta Description <span class="text-danger">*</span></label>
                  <textarea class="form-control form-control-solid" name="meta_description" id="description" required rows="3">{{ $setting->response->meta_description ?? '' }}</textarea>
                </div>
              </div>
            </div>
            <hr style="margin: 15px -20px">
            <div class="row">
              <h5 class="pl-2 mb-3">Social Link</h5>
              <br>
              <div class="col-12  ">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fab fa-facebook-square"></i>
                    </span>
                  </div>
                  <input class="form-control" type="text" name="facebook" value="{{ $setting->response->facebook ?? '' }}" placeholder="Recipient's text" aria-label="Recipient's ">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fab fa-instagram"></i>
                    </span>
                  </div>
                  <input class="form-control" value="{{ $setting->response->instagram ?? '' }}" type="text" name="instagram" placeholder="Recipient's text" aria-label="Recipient's ">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fab fa-whatsapp"></i>
                    </span>
                  </div>
                  <input class="form-control" type="text" name="whatsapp" value="{{ $setting->response->whatsapp ?? '' }}" placeholder="Recipient's text" aria-label="Recipient's ">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fab fa-linkedin-in"></i>
                    </span>
                  </div>
                  <input class="form-control" type="text" value="{{ $setting->response->linkedin ?? '' }}" name="linkedin" placeholder="Recipient's text" aria-label="Recipient's ">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fab fa-twitter"></i>
                    </span>
                  </div>
                  <input class="form-control" type="text" name="twitter" value="{{ $setting->response->twitter ?? '' }}" placeholder="Recipient's text" aria-label="Recipient's ">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fab fa-pinterest"></i>
                    </span>
                  </div>
                  <input class="form-control" type="text" name="pinterest" value="{{ $setting->response->pinterest ?? '' }}" placeholder="Recipient's text" aria-label="Recipient's ">
                </div>
              </div>
            </div>
            <hr style="margin: 15px -20px">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="offertext">Category Selection <span class="text-danger">*</span></label>
                  <select class="form-control category-select2" multiple name="category[]" id="category" data-url="{{ route('admin.get.category') }}" data-rule-required="true" data-placeholder="Select Category."
                    data-msg-required="Category is required.">
                    @if (isset($setting->response->category) && !is_null($setting->response->category))
                      @foreach ($setting->response->category as $item)
                        <option value="{{ $item }}" selected>{{ \App\Category::find($item)->name }}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
              </div>
            </div>
            <hr style="margin: 15px -20px">
            <div class="row">
              <h5 class="pl-2 mb-3">website Review Link</h5>
              <div class="col-12">
                <div class="form-group">
                  <label for="offertext">Google Review <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="google_link" value="{{ $setting->response->google_link ?? '' }}" aria-label="Recipient's ">
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="offertext">Trust Pilot Review <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="pilot_link" value="{{ $setting->response->pilot_link ?? '' }}" aria-label="Recipient's ">
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="offertext">Esty Review <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="esty_link" value="{{ $setting->response->esty_link ?? '' }}" aria-label="Recipient's ">
                </div>
              </div>
            </div>


            <hr style="margin: 15px -20px">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="offertext">Offer Slide</label>
                  <textarea id="offertext" class="form-control" name="offertext" rows="3">{!! $setting->response->offertext ?? '' !!}</textarea>
                  <span class="text-sm">Seprate with ## </span>
                </div>
              </div>
            </div>
            <hr style="margin: 15px -20px">
            <div class="row">
              <h5 class="pl-2 mb-3"><strong>Shipping Charge For India</strong></h5><br>
              <div class="col-12">
                <div class="form-row d-none">
                  <div class="form-group">
                    <div class="form-radio">
                      <label for="" class="p-0">Shipping Charge</label>
                      <div class="radio radio-inline">
                        <label>
                          <input type="radio" class="shipping-charge" data-target=".amount" name="charge_type" checked value="amount">
                          <i class="helper"></i>Amount
                        </label>
                      </div>
                      <div class="radio radio-inline">
                        <label>
                          <input type="radio" name="charge_type" data-target=".percentage" class="shipping-charge" value="percentage" {{ $setting->charge_type == 'percentage' ? 'checked' : '' }}>
                          <i class="helper"></i>Percentage
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col amount">
                    <div class="form-group">
                      <label for="shipping_amount">Shipping Amount <span class="text-danger">*</span>
                      </label>
                      <input id="shipping_amount" value="{{ $setting->response->shipping_amount ?? '' }}" class="form-control" type="number" data-msg-required="Shipping amount required." name="shipping_amount">
                    </div>
                  </div>
                  <div class="col percentage d-none">
                    <div class="form-group">
                      <label for="shipping_percentage">Shipping Percentage (%) <span class="text-danger">*</span>
                      </label>
                      <input id="shipping_percentage" value="{{ $setting->shipping_percentage ?? '' }}" class="form-control" type="number" name="shipping_percentage" data-msg-required="Shipping percentage required.">
                    </div>
                  </div>
                </div>

                <h6><b>Free Shipping</b></h6>
                <hr>
                <div class="form-row">
                  <div class="col">
                    <div class="form-group">
                      <label for="free_shipping">Minimum Purchase Amount for Free Shipping</label>
                      <input id="free_shipping" value="{{ $setting->response->free_shipping ?? '' }}" class="form-control" type="number" name="free_shipping" data-rule-number="true">
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <hr style="margin: 15px -20px">

            <div class="row">
              <h5 class="mb-3"><strong>Standards and formats</strong></h5>
              <div class="form-row w-100">
                <div class="col">
                  <div class="form-group">
                    <label for="order_prefix">Prefix </label>
                    <input id="order_prefix" class="form-control" type="text" value="{{ $setting->response->order_prefix ?? '' }}" name="order_prefix">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="order_suffix">Suffix </label>
                    <input id="order_suffix" class="form-control" type="text" name="order_suffix" value="{{ $setting->response->order_suffix ?? '' }}">
                  </div>
                </div>
              </div>

              <div class="form-row w-100">
                <div class="col" style="color: gray">
                  <label><b>Your order ID will appear as #1001,#1002,#1003...</b></label>
                </div>
              </div><br>

              <div class="form-row w-100">
                <div class="col-6">
                  <div class="form-group">
                    <label for="invoice_prefix">Invoice Prefix </label>
                    <input id="invoice_prefix" class="form-control" type="text" name="invoice_prefix" value="{{ $setting->response->invoice_prefix ?? '' }}">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="last_number">Next Invoice Number </label>
                    <input id="last_number" class="form-control" type="text" name="last_number" readonly="true" value="{{ isset($setting->response->invoice_no) ? $setting->response->invoice_no + 1 : 1 }}">
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="invoiceformat">Invoice Format</label>
                    <p>
                      <label class="m-radio">
                        <input type="radio" class="forment" id="forment1" value="1" {{ !empty($setting) && optional($setting->response)->forment == '1' ? 'checked' : '' }} {{ empty($setting) ? 'checked' : '' }} name="forment"
                          value="0" checked="">
                        Number Based(00001)
                        <span></span>
                      </label><br>

                      <label class="m-radio">
                        <input type="radio" class="measurement" id="forment2" name="forment" value="2" {{ !empty($setting) && optional($setting->response)->forment == '2' ? 'checked' : '' }}>
                        Year Based(YYYY/00001)
                        <span></span>
                      </label><br>

                      <label class="m-radio">
                        <input type="radio" class="measurement " id="forment3" name="forment" value="3" {{ !empty($setting) && optional($setting->response)->forment == '3' ? 'checked' : '' }}>
                        00001-YY
                        <span></span>
                      </label><br>

                      <label class="m-radio">
                        <input type="radio" class="measurement " id="forment4" name="forment" value="4" {{ !empty($setting) && optional($setting->response)->forment == '4' ? 'checked' : '' }}>
                        00001/MM/YY
                        <span></span>
                      </label>
                    </p>
                  </div>
                </div>
              </div>

              <div class="form-row w-100">
                <div class="col ">
                  <div class="form-group">
                    <label for="term_condition">Predefined Terms & Condition</label>
                    <textarea class="form-control" id="term_condition" name="term_condition">{{ $setting->response->term_condition ?? '' }}</textarea><br>
                    <label>
                      <p class="text-danger" style="color: red;">Note: You can separate by ##(Double
                        Hash Sign) (E.X. Terms
                        1##Terms 2##Terms 3)</p>
                    </label>
                  </div>
                </div>
              </div>

            </div>
            <hr style="margin: 15px -20px">
            <div class="row">
              <h5 class="mb-3"><strong>Trust Pilot Details</strong></h5>
              <div class="form-row w-100">
                <div class="col">
                  <div class="form-group d-none">
                    <label for="term_condition">Script</label>
                    <input type="text" name="trust_script" class="form-control" id="trust_script" value="{{ $setting->response->trust_script ?? '' }}">
                  </div>
                  <div class="form-group">
                    <label for="caption">Have to show Trust Pilot ?</label>
                    <div class="material-switch">

                      <input id="is_active" name="is_active" type="checkbox" value="1" {{ isset($setting->response->is_active) && $setting->response->is_active == true ? 'checked' : '' }}>

                      <label for="is_active" class="badge-success"></label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="term_condition">Content</label>
                    <textarea class="form-control" id="trust_box" rows="4" name="trust_box">{{ $setting->response->trust_box ?? '' }}</textarea>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>
        <button type="submit" class="btn btn-success float-right"> <i class="fa fa-save"></i> Save </button>
      </form>
    </div>

  </div>
@endsection

@push('js')
  <script src="{{ asset('js/subcategory.js') }}"></script>
@endpush
@push('scripts')
  <script>
    $(document).ready(function() {

      $('#settingsForm').validate({
        debug: false,
        ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
        errorPlacement: function(error, element) {
          error.appendTo(element.parent()).addClass('text-danger');
        }
      });

      $('.shipping-charge').on('change', function() {
        var el = $(this);
        var target = $(el.data('target'));
        target.parent().children().addClass('hidden');
        target.removeClass('hidden');
      });;
    });
  </script>
@endpush
