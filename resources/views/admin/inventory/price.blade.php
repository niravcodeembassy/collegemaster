@extends('admin.layouts.app')

@section('title', $title)

@section('content')
  @component('component.heading',
      [
          'page_title' => 'Inventory ',
          'icon' => 'fa fa-clipboard',
          'tagline' => 'Lorem ipsum dolor sit amet.',
          'action' => route('admin.inventory.index'),
          'action_icon' => 'fa fa-arrow-left',
          'text' => 'Back',
      ])
  @endcomponent
  <form action="{{ route('admin.inventory.bulk.update_all') }}" method="POST" name="save_inventory" id="save_inventory">
    @csrf

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-block">
            <h3>Bulk Edit</h3>
          </div>
          <div class="card-block p-0 table-border-style">
            <div class="table-responsive">
              <table class="table table-inverse">
                <thead class="bg-light">
                  <tr>
                    <th>Variants</th>
                    <th>MRP </th>
                    <th>Offer Price</th>
                    <th>Quantity</th>
                  </tr>
                </thead>
                <tbody>
                  <input type="hidden" name="option" value="{{ $combination }}">
                  <tr>
                    <td>
                      <div class="feeds-widget">
                        <div class="feed-item border-0">
                          <a href="#">
                            <div class="feeds-body">
                              <h4 class="font-weight-normal f-18 text-primary mb-0"> </h4>
                              @foreach ($combination->toArray() as $index => $value)
                                <small>
                                  <strong> <span> {{ $index }} : {{ $value }} </span></strong>
                                </small></br>
                              @endforeach
                            </div>
                          </a>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control w-75" name="mrp_price" data-rule-required="true" data-msg-required="MRP Price is required." data-rule-number="true" value="" placeholder="">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control w-75 " name="offer_price" data-rule-required="false" data-msg-required="Offer Price is required." data-rule-number="true" value="" placeholder="">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control w-75" name="inventory_quantity" data-rule-number="true" value="" placeholder="">
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-success shadow"> Save</button>
        </div>
      </div>
    </div>
  </form>

@endsection
@push('js')
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>
@endpush
@push('css')
  <style>
    .custom-input {
      height: 35px;
      border: 1px solid grey !important;
    }
  </style>
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      // var table = $('#order-table').DataTable();

      $('#save_inventory').validate({
        debug: false,
        ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
        rules: {},
        messages: {},
        errorPlacement: function(error, element) {
          error.appendTo(element.parent()).addClass('text-danger');
        },
        submitHandler: function(e) {
          return true;
        }
      });
    });
  </script>
@endpush
