@extends('admin.layouts.app')

@section('content')
  <div class="row mt-4">
    <div class="col-sm-12 col-md-4">
      <div class="cards">
        <div class="card-body p-0">
          <h4 class=""> Edit Review </h4>
          <p class="text-muted">Hear you can create a review for product</p>
        </div>
      </div>
    </div>

    <div class="col-sm-12 col-md-8 ">
      <form action="{{ route('admin.review.update', ['review' => $review->id]) }}" id="reviewsForm" method="post">
        @csrf @method('PUT')
        <div class="card">
          <div class="card-body">
            <div class="row">

              <div class="col-md-12">
                <div class="form-group">
                  <label>Product <span class="text-danger">*</span></label>
                  <div class="input-group input-group-button">
                    <select class="form-control" name="product" id="product" data-url="{{ route('admin.get.search.product') }}" data-rule-required="true" data-placeholder="Select Product." data-msg-required="Product is required.">
                      <option value="" selected>Select Product</option>
                      @if ($review->product)
                        <option value="{{ $review->product->id }}" selected>{{ $review->product->name }}</option>
                      @endif
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>User </label>
                  <div class="input-group input-group-button">
                    <select class="form-control" name="user" id="user" data-url="{{ route('admin.get.customer') }}"data-placeholder="Select User.">
                      <option value="" selected>Select User</option>
                      @if ($review->user)
                        <option value="{{ $review->user->id }}" selected>{{ $review->user->name }}</option>
                      @endif
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" name="name" id="name" value="{{ $review->name ?? '' }}" class="form-control">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>email</label>
                  <input type="text" name="email" id="email" value="{{ $review->email ?? '' }}" class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Message</label>
                  <textarea name="message" id="message" rows="2" class="form-control">{{ $review->message ?? '' }}</textarea>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Rating</label>
                  <input type="text" name="rating" id="rating" value="{{ $review->rating ?? '' }}" data-rule-number="true" class="form-control">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="created_date">Created Date</label>
                  <div class="form-group">
                    <div class="input-group date" id="created_date" data-target-input="nearest" style="margin-bottom: 0px;">
                      <input type="text" class="form-control datetimepicker-input" id="created_date" name="created_date" onkeydown="return false;" value="{{ date_format($review->created_at, ' d/m/Y H:i:s') }}" data-target="#created_date" />
                      <div class="input-group-append" data-target="#created_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="float-right">
          <a href="{{ route('admin.review.index') }}" class="btn btn-default mr-2 "> Cancel</a>
          <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Update</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
@endpush

@push('js')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {

      let user = $('#user');
      let product = $("#product");

      $('#reviewsForm').validate({
        debug: false,
        ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
        errorPlacement: function(error, element) {
          // $(element).addClass('is-invalid')
          error.appendTo(element.parent()).addClass('text-danger');
        }
      });
      user.select2({
        theme: 'bootstrap4',
        ajax: {
          url: function() {
            return $(this).data('url')
          },
          data: function(params) {
            return {
              search: params.term,
            };
          },
          dataType: 'json',
          processResults: function(data) {
            return {
              results: data.map(function(item) {
                return {
                  id: item.id,
                  text: item.name,
                  otherfield: item,
                };
              }),
            }
          },
          //cache: true,
          delay: 250
        },
      });

      product.select2({
        allowClear: true,
        ajax: {
          url: product.data('url'),
          data: function(params) {
            return {
              search: params.term || '',
              id: $(product.data('target')).val(),
              page: params.page || 1
            };
          },
          dataType: 'json',
          processResults: function(data) {
            return {
              results: data.results.map(function(item) {
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
        placeholder: 'Select discount product',
        theme: 'bootstrap4'
      });

      $('#created_date').datetimepicker({
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

    });
  </script>
@endpush
