@extends('admin.layouts.app')

@section('title', $title)

@section('content')
  @component('component.heading',
      [
          'page_title' => '',
          'icon' => '',
          'tagline' => 'Lorem ipsum dolor sit amet.',
          'action' => route('admin.discount.index'),
          'action_icon' => 'fa fa-arrow-left',
          'text' => 'Back',
      ])
  @endcomponent
  <div class="section">

    <form action="{{ route('admin.discount.store') }}" id="discountforms" name="discountforms" method="POST" data-url="{{ route('admin.discount.checkDiscountCode') }}">
      @csrf()

      <div class="row">
        @include('component.error')
        <div class="col-sm-4">
          <h5 class=""><strong>Discount</strong></h5>
          <p class="text-muted">Offering discounts can be a powerful marketing strategy for your store. you can create discount codes where you can offer your customers a fixed value, percentage, or shipping discount on products.</p>
        </div>

        <div class="col-sm-8">
          <div class="card">
            <div class="card-body">
              <h6 class="text-mute"><strong>Code</strong> </h6>
              <hr>
              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label for="discount_code">Discount code <span class="text-danger">*</span></label>
                    <a href="javascript:void(0);" class="float-right pb-2 text-primary generate-code" role="button">Generate code</a>
                    <input id="discount_code" class="form-control text text-uppercase" type="text" name="discount_code" data-rule-required="true">
                  </div>
                  <p class="text-help-block text-muted">Customers will enter this discount code at checkout.</p>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-4">

        </div>

        <div class="col-sm-8">
          <div class="card">
            <div class="card-body">
              <h6 class="text-mute"><strong>Options</strong> </h6>
              <hr>
              <div class="form-row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="discount_type"> Discount type <span class="text-danger">*</span> </label>
                    <div class="form-group">
                      <div class="form-radio">
                        <div class="radio radio-inline d-none">
                          <label>
                            <input type="radio" data-target=".amount" name="discount_type" class="shipping-charge" value="amount">
                            <i class="helper"></i>Fixed amount
                          </label>
                        </div>

                        <div class="radio radio-inline">
                          <label>
                            <input type="radio" data-target=".percentage" class="shipping-charge" name="discount_type" value="percentage" checked="">
                            <i class="helper"></i>Percentage
                          </label>
                        </div>

                      </div>
                    </div>

                    {{-- <select id="discount_type" class="form-control " name="discount_type">
                                            <option value="">Select Discoutn Type</option>
                                            <option  value="percentage">Percentage</option>
                                            <option  value="amount">Fixed amount</option>
                                        </select> --}}

                  </div>
                </div>
                <div class="col discount-type-option">
                  <div class="percentage">
                    <div class="form-group">
                      <label for="percentage">Discount in percentage <i class="text-danger">*</i></label>
                      <input type="text" id="percentage" name="percentage" class="form-control" data-rule-required="true" min="0.1" max="100" data-msg-min="Please enter a value greater than zero." placeholder="Discount in percentage (%)">
                    </div>
                  </div>
                  <div class="d-none amount">
                    <div class="form-group">
                      <label for="amount">Discount in amount <i class="text-danger">*</i></label>
                      <input type="text" id="amount" name="amount" class="form-control" data-rule-required="true" min="1" placeholder="Discount in amount">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row ">
        <div class="col-sm-4">

        </div>

        <div class="col-sm-8 ">
          <div class="card ">
            <div class="card-body">

              <h6 class="text-mute"><strong>Applies to</strong> </h6>
              <hr>
              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input applies-to" name="applies_to" value="entire_order" checked="checked">
                      <span class="custom-control-label">&nbsp;Entire order</span>
                    </label>
                  </div>
                  <div class="form-group">
                    <label class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input applies-to" data-target=".applies-to-product" name="applies_to" value="product">
                      <span class="custom-control-label">&nbsp;Product</span>
                    </label>
                  </div>
                  <div class="applies-to-option">
                    <div class="d-none applies-to-product">
                      <label for="applies_to_product"> Discount Product <span class="text-danger">*</span></label>
                      <div class="form-group">
                        <select class="form-control discount-product-select2" style="width:100%;" name="applies_to_product[]" multiple id="applies_to_product" data-url="{{ route('admin.get.search.product') }}"
                          data-placeholder="Select Discount Product." data-rule-required="true" data-msg-required="Discount Product is required.">
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group d-none">
                    <label class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input applies-to" name="applies_to" data-target=".applies-to-category" value="category">
                      <span class="custom-control-label">&nbsp;Category</span>
                    </label>
                  </div>
                  {{-- <div class="applies-to-option">
                                   <div class="d-none applies-to-category">
                                       <label for="applies_to_category"> Discount category <span class="text-danger">*</span> </label>
                                       <div class="form-group">
                                           <select class="form-control category-select2" style="width:100%;" name="applies_to_category[]" id="applies_to_category" data-url="{{ route('admin.get.subcategory') }}" data-rule-required="true" data-placeholder="Select Product Category." multiple  data-msg-required="Product category is required." >
                                           </select>
                                       </div>
                                   </div>
                               </div> --}}

                </div>
              </div>
              {{-- <div class="form-row">
                            <div class="applies-to-option">
                                <div class="col-12 d-none applies-to-product">
                                    <label for="applies_to_proudct"> Discount Product<span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select id="applies_to_proudct" style="width:100%;" class="form-control " name="applies_to_proudct">
                                            <option value="percentage">Percentage</option>
                                            <option value="amount">Fixed amount</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 d-none applies-to-category">
                                    <label for="applies_to_category"> Discount category<span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select id="applies_to_category"  style="width:100%;" class="form-control" name="applies_to_category">
                                            <option  value="">Percentage</option>
                                            <option  value="">Fixed amount</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-4">

        </div>

        <div class="col-sm-8">
          <div class="card">
            <div class="card-body">

              <h6 class="text-mute"><strong>Minimum requirement</strong> </h6>
              <hr>
              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input minimum-requirement" name="minimum_requirement" value="none" checked="checked">
                      <span class="custom-control-label">&nbsp;None</span>
                    </label>
                  </div>
                  <div class="form-group">
                    <label class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input minimum-requirement" name="minimum_requirement" value="purchase_amount" data-target=".purchase-amount">
                      <span class="custom-control-label">&nbsp;Minimum purchase amount</span>
                    </label>
                  </div>

                  <div class="minimum-requirement-option">
                    <div class="d-none purchase-amount">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Purchase amount" name="min_purchase_amount" id="min_purchase_amount" aria-describedby="helpId" placeholder="" data-rule-required="true">
                      </div>
                    </div>
                  </div>

                </div>
              </div>


            </div>
          </div>
        </div>

      </div>

      <div class="row">

        <div class="col-sm-4">
        </div>

        <div class="col-sm-8">
          <div class="card">
            <div class="card-body">

              <h6 class="text-mute"><strong>Active dates</strong></h6>
              <hr>

              <div class="form-row date-form-row">
                <div class="col">
                  <div class="form-group">
                    <label for="start_date">Start date <span class="text-danger">*</span></label>
                    <div class="form-group">
                      <div class="input-group date" id="start_date" data-target-input="nearest" style="margin-bottom: 0px;">
                        <input type="text" class="form-control datetimepicker-input" id="start_date" name="start_date" onkeydown="return false;" data-target="#start_date" data-rule-required="true" />
                        <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <div class="form-group">
                    <label for="end_date">End date <span class="text-danger">*</span></label>
                    <div class="form-group">
                      <div class="input-group date" id="end_date" data-target-input="nearest" style="margin-bottom: 0px;">
                        <input type="text" class="form-control datetimepicker-input" id="end_date" name="end_date" onkeydown="return false;" data-target="#end_date" data-rule-required="true" />
                        <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>


      <div class="row">
        <div class="col d-flex justify-content-end">
          <button type="submit" class="btn btn-success shadow">Save</button>
        </div>
      </div>
    </form>
  </div>

@endsection


@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
@endpush

@push('js')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
  <script src="{{ asset('js/discount.js') }}"></script>
@endpush

@push('scripts')
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('#discountforms').validate({
        debug: false,
        ignore: '.select2-search__field,:hidden:not("textarea,.files")',
        rules: {
          discount_code: {
            required: true,
            remote: {
              url: $('#discountforms').attr('data-url'),
              type: 'POST',
              data: {
                _token: function() {
                  return window.Laravel.csrfToken;
                },
                form_field: function() {
                  return $("#discount_code").val();
                },
                id: function() {
                  return $("#id").val();
                },
              }
            }
          }
        },
        messages: {
          discount_code: {
            remote: "Please enter unique discount code",
          }
        },
        errorPlacement: function(error, element) {
          // $(element).addClass('is-invalid')
          console.log(error, element);

          error.appendTo(element.parent()).addClass('text-danger');
          if (element.parent('.input-group').length) {
            console.log(error, element);

            error.insertAfter(element.parent());
          }
        },
        submitHandler: function(e) {
          return true;
        }
      });
    });
  </script>
@endpush
