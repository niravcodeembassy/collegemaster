@extends('admin.layouts.app')

@section('title', $title)

@push('css')
  {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/mohithg-switchery/dist/switchery.min.css') }}"> --}}
@endpush
@push('style')
  <style>
    tbody td {
      text-align: center;
    }

    .breadcrumb-item+.breadcrumb-item::before {
      content: "|";
    }

    ol.breadcrumb {
      background-color: #fff;
      margin-bottom: 0rem;
    }
  </style>
@endpush
@push('js')
  {{-- <script src="{{ asset('assets/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script> --}}
@endpush

@section('content')
  @component('component.heading',
      [
          'page_title' => 'Order',
          'icon' => 'fa fa-shopping-bag',
          'tagline' => 'Lorem ipsum dolor sit amet.',
          'action' => null,
          'action_icon' => 'fa fa-plus',
          'text' => '',
      ])
  @endcomponent


  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <ul class="nav">
            <li class="nav-item">
              <a class="btn btn-group-vertical ml-2 {{ $type === 'online' ? 'btn-primary' : 'btn-light' }}" href="{{ route('admin.order.index', ['type' => 'online']) }}" role="button">Online</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-group-vertical  mx-2 {{ $type === 'cod' ? 'btn-primary' : 'btn-light' }}" href="{{ route('admin.order.index', ['type' => 'cod']) }}" role="button">COD</a>
            </li>
            <li class="nav-item ">
              <a class="btn btn-group-vertical {{ $type === 'pending' ? 'btn-primary' : 'btn-light' }}" href="{{ route('admin.order.index', ['type' => 'pending']) }}" role="button">Online pending</a>
            </li>
          </ul>
          <div class="mt-2">
            <ol class="breadcrumb text-muted fw-bold">
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="order_placed" class="type text-primary">NEW</a>
              </li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="pick_not_receive" class="type">PIC NOT REC</a>
              </li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="work_in_progress" class="type">DESIGNING</a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="correction" class="type">CORRECTION </a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="customer_approval" class="type">APPROVAL</a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="printing" class="type">PRINTING</a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="delivered" class="type">COMPLETED</a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="refund" class="type">REFUND</a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="all" class="type">ALL</a></li>
            </ol>
          </div>
        </div>
        <div class="card-body p-0 ">
          <div class="dt-responsive">
            <table class="table w-100" id="order_table" data-url="{{ route('admin.order.list', ['type' => $type]) }}">
              <thead class="bg-light">
                <tr>
                  <th class="text-center nosort">Order No</th>
                  <th class="text-center">Date</th>
                  <th class="text-center">Customer</th>
                  <th class="text-center" data-orderable="false">Qty</th>
                  {{-- <th class="text-center">Payment Status</th> --}}
                  <th class="text-center">Order status</th>
                  <th class="text-center" data-orderable="false">Download Photos</th>
                  <th class="text-center">Total</th>
                  <th class="text-center" data-orderable="false">Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
      <!-- Language - Comma Decimal Place table end -->
    </div>
  </div>

@endsection
@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
@endpush
@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.28.0/moment.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
@endpush
@push('scripts')
  <script>
    $(document).ready(function() {
      var filter_type = 'order_placed';
      var table = $('#order_table').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        "ajax": {
          "url": $('#order_table').attr('data-url'),
          "dataType": "json",
          "type": "POST",
          "data": function(d) {
            return $.extend({}, d, {
              _token: "{{ csrf_token() }}",
              // 'delivery_status' :
              payment_status: $('#filter').val(),
              delivery_status: $('#delivery_status_filter').val(),
              from_date: $('#from_date').val(),
              to_date: $('#to_date').val(),
              filter_status: filter_type
            });
          }
        },
        "order": [
          [0, "desc"]
        ],
        "columns": [{
            "data": "orderNumber"
          },
          {
            "data": "created_at"
          },
          {
            "data": "customerName"
          },
          {
            "data": "qty"
          },
          // {
          //   "data": "paymentSatatus"
          // },
          {
            "data": "deliveryStatus"
          },
          {
            "data": "downloadPhoto"
          },
          {
            "data": "totalPrice"
          },
          {
            "data": "action"
          },
        ]
      });

      $('ol.breadcrumb li a').click(function(e) {
        e.preventDefault();
        $type = $(this).attr('data-type');
        $('li a').removeClass('text-primary');
        $(this).addClass('text-primary');
        filter_type = $type;
        table.draw();
      });
    });
  </script>
@endpush
