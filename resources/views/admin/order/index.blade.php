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

    .btn-active {
      background-color: #6576ff;
      border-color: #6576ff;
      box-shadow: none;
      color: white;
    }

    .btn-active:hover {
      color: white;
    }

    .btn-inactive:hover {
      color: black;
    }

    .btn-inactive {
      background-color: #e5e9f2;
      border-color: #e5e9f2;
      box-shadow: none;
      color: black;
    }

    span.order_count {
      display: contents;
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
    @if ($total_order > 0)
      <a href="{{ route('admin.export.excel', ['export' => 'order']) }}" class="btn btn-success btn-sm">
        <i class="fas fa-file-export"></i>Order Report Excel
      </a>
      <a href="{{ route('admin.export.pdf', ['export' => 'order']) }}" class="btn btn-warning btn-sm mx-2">
        <i class="fa fa-file-pdf"></i> Order Report Pdf
      </a>
    @endif
  @endcomponent
      
  @if ($refund_total_order > 0)
    <div class="col mb-2">
      <div class="d-flex justify-content-end align-items-center ">
        <a href="{{ route('admin.export.excel', ['export' => 'refund']) }}" class="btn btn-success btn-sm">
          <i class="fas fa-file-export"></i> Refund Report Excel
        </a>
        <a href="{{ route('admin.export.pdf', ['export' => 'refund']) }}" class="btn btn-warning btn-sm mx-2">
          <i class="fa fa-file-pdf"></i> Refund Report PDF
        </a>
      </div>
    </div>
  @endif

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <ul class="nav">
            <li class="nav-item">
              <a class="btn btn-group-vertical text-uppercase ml-2 {{ $type === 'online' ? 'btn-primary' : 'btn-light' }}" href="{{ route('admin.order.index', ['type' => 'online']) }}" role="button">Online</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-group-vertical text-uppercase mx-2 {{ $type === 'cod' ? 'btn-primary' : 'btn-light' }}" href="{{ route('admin.order.index', ['type' => 'cod']) }}" role="button">COD</a>
            </li>
            <li class="nav-item ">
              <a class="btn btn-group-vertical text-uppercase {{ $type === 'pending' ? 'btn-primary' : 'btn-light' }}" href="{{ route('admin.order.index', ['type' => 'pending']) }}" role="button">Online pending</a>
            </li>
          </ul>
          <div class="mt-2">
            <ol class="breadcrumb text-muted fw-bold">
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="order_placed" class="btn-group-vertical type btn btn-active">NEW <span class="order_count">({{ $order_count['order_placed'] }})</span></a>
              </li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="pick_not_receive" class="btn-group-vertical type btn btn-inactive">PIC NOT REC <span class="order_count">({{ $order_count['pick_not_receive'] }})</span></a>
              </li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="work_in_progress" class="btn-group-verticaltype btn btn-inactive">DESIGNING <span class="order_count">({{ $order_count['work_in_progress'] }})</span></a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="correction" class="btn-group-vertical type btn btn-inactive">CORRECTION <span class="order_count">({{ $order_count['correction'] }})</span></a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="customer_approval" class="btn-group-vertical type btn btn-inactive">APPROVAL <span class="order_count">({{ $order_count['customer_approval'] }})</span></a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="printing" class="btn-group-vertical type btn btn-inactive">PRINTING <span class="order_count">({{ $order_count['printing'] }})</span></a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="delivered" class="btn-group-vertical type btn btn-inactive">COMPLETED <span class="order_count">({{ $order_count['delivered'] }})</span></a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="refund" class="btn-group-vertical type btn btn-inactive">REFUND <span class="order_count">({{ $order_count['refund'] }})</span></a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0);" data-type="all" class="btn-group-vertical type btn btn-inactive">ALL <span class="order_count">({{ $total_count }})</span> </a></li>
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
                  <th class="text-center" data-orderable="false">Send Message</th>
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
            "data": "sendMessage"
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
        $('li a.btn-active').removeClass('btn-active').addClass('btn-inactive');
        $(this).removeClass('btn-inactive').addClass('btn-active');
        filter_type = $type;
        table.draw();
      });


      $(document).on('click', '.sendWhatsapp', function(e) {
        var id = $(this).data('id');
        var status = $(this).data('status');
        var link = $(this).data('url');

        $.ajax({
          type: "POST",
          url: link,
          data: {
            id: id,
            order_status: status
          }
        }).always(function(respons) {}).done(function(respons) {
          if (respons.success) {
            toast.fire({
              type: 'success',
              title: 'Success',
              text: respons.message
            });
          } else {
            toast.fire({
              type: 'info',
              title: 'Info',
              text: respons.message
            });
          }


        }).fail(function(respons) {

          toast.fire({
            type: 'error',
            title: 'Error',
            text: 'something went wrong please try again !'
          });

        });
      });

      $(document).on('click', '.sendSms', function(e) {
        var id = $(this).data('id');
        var status = $(this).data('status');
        var link = $(this).data('url');

        $.ajax({
          type: "POST",
          url: link,
          data: {
            id: id,
            order_status: status
          }
        }).always(function(respons) {}).done(function(respons) {
          if (respons.success) {
            toast.fire({
              type: 'success',
              title: 'Success',
              text: respons.message
            });
          } else {
            toast.fire({
              type: 'info',
              title: 'Info',
              text: respons.message
            });
          }


        }).fail(function(respons) {

          toast.fire({
            type: 'error',
            title: 'Error',
            text: 'something went wrong please try again !'
          });

        });
      });


    });
  </script>
@endpush
