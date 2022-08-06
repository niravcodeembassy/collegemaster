@extends('admin.layouts.app')

@section('title', $day_of_deal->title)



@section('content')

  @component('component.heading',
      [
          'page_title' => 'Deal Of Day',
          'icon' => 'ik ik-navigation',
          'tagline' => 'Lorem ipsum dolor sit amet.',
          'action' => route('admin.website-setting'),
          'action_icon' => 'fa fa-arrow-left',
          'text' => 'Back',
      ])
    {{-- <a href="{{route('admin.offerbanner.create')}}" class="btn btn-outline-dark btn-rounded ml-3">
<i class="ik ik-plus "></i> Add Offer Banner
</a> --}}
  @endcomponent
  <div class="row">
    <div class="col-md-12">

      <div class="card p-3">

        <form action="{{ route('admin.dealofday.update') }}" name="deal_form" id="deal_form" method="post" enctype="multipart/form-data">
          @csrf

          <div class="row mb-2">
            <div class="col-4">

              <div class="form-row">
                @include('component.imagepriview', [
                    'height' => '200px',
                    'label' => 'Image',
                    'name' => 'banner_image',
                    'id' => 'banner_image',
                    'priview' => env('APP_URL') . '/storage/' . $day_of_deal->bg_img ?? null,
                ])
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="title">Title</label>
                <input id="title" class="form-control" type="text" value="{{ $day_of_deal->title }}" name="title">
              </div>
              <div class="form-group">
                <label for="button_name">Button Name</label>
                <input id="button_name" class="form-control" type="text" value="{{ $day_of_deal->btn_name }}" name="button_name">
              </div>
              <div class="form-group">
                <label for="button_url">Button URL</label>
                <input id="button_url" class="form-control" type="text" value="{{ $day_of_deal->btn_url }}" name="button_url">
              </div>
              <div class="form-row date-form-row">
                <div class="col">
                  <div class="form-group">
                    <label for="status">Active <span class="text-danger">*</span></label>

                    <input type="radio" name="status" @if ($day_of_deal->status == 1) {{ 'checked' }} @endif value="1">

                    <label for="status">Disable <span class="text-danger">*</span></label>

                    <input type="radio" name="status" @if ($day_of_deal->status == 0) {{ 'checked' }} @endif value="0">

                  </div>
                </div>

                @php

                  $date = date_create($day_of_deal->end_time);

                @endphp
                <div class="col">
                  <div class="form-group">
                    <label for="end_date">End date <span class="text-danger">*</span></label>
                    <div class="form-group">
                      <div class="input-group date" id="end_date" data-target-input="nearest" style="margin-bottom: 0px;">
                        <input type="text" class="form-control datetimepicker-input" id="end_date" name="end_date" onkeydown="return false;" value="{{ date_format($date, 'd/m/Y H:i:s') }}" data-target="#end_date" data-rule-required="true" />
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
          <div class="row">
            <div class="col-12">
              <div class="form-group mb-3">
                <div class="input-group input-group-button">
                  <select class="form-control buy-together-select2" name="deal_product" id="deal_product" data-url="{{ route('admin.get.search.product') }}" data-placeholder="Select Related Products." data-rule-required="false"
                    data-msg-required="Product category is required.">
                    <option value="">Select Deal Products</option>
                    @if ($day_of_deal->product_id)
                      <option value="{{ $day_of_deal->product->id }}" selected>{{ $day_of_deal->product->name }}</option>
                    @endif
                  </select>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="id" value="{{ $day_of_deal->id }}">
          <hr>
          <div class="form-group">
            <button type="submit" class="btn btn-success shadow float-right"><i class="ik ik-check-circle"></i>Update</button>
          </div>
        </form>

      </div>
    </div>
  </div>

@endsection

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {

      $.validator.addMethod('filesize', function(value, element, param) {
        if (element.files.length) {
          return this.optional(element) || (element.files[0].size <= param)
        }
        return true;
      });


      $('#middle_banner').validate({
        debug: false,
        ignore: '.select2-search__field,:hidden:not("textarea,.files")',
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

    });
  </script>
@endpush

@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
@endpush

@push('js')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#deal_form').validate({
        debug: false,
        ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
        rules: {},
        messages: {},
        errorPlacement: function(error, element) {
          error.appendTo(element.parent()).addClass('text-danger');
        },
        submitHandler: function(e) {
          e.submit()
        }
      })

      dealproductSelect2 = $('.buy-together-select2')

      dealproductSelect2.select2({
        allowClear: true,
        theme: 'bootstrap4',
        ajax: {
          url: dealproductSelect2.data('url'),
          data: function(params) {
            return {
              search: params.term,
              id: $(dealproductSelect2.data('target')).val()
            };
          },
          dataType: 'json',
          processResults: function(data) {
            return {
              results: data.data.map(function(item) {
                return {
                  id: item.id,
                  text: item.name,
                  otherfield: item,
                };
              }),
            }
          },
          cache: true,
          delay: 250
        },
        placeholder: 'Select buy together product',
        // minimumInputLength: 1,
      });

      $('#title').on('keydown keyup', function(e) {
        // alert('keypress');
        var el = $(this);
        var textdata = el.val();
        var slug = convertToSlug(textdata);
        $('#meta_slug').val(slug);

      });

    });


    var convertToSlug = function convertToSlug(Text) {
      var data = Text
        .toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-');
      return data
    }

    $('#end_date').datetimepicker({
      format: 'DD-MM-YYYY',
      keepOpen: false,
      showClear: true,
      showClose: true,
      icons: {
        time: "fa fa-clock",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
      },
      useCurrent: false, //Important! See issue #1075 ,
    });
  </script>
@endpush
