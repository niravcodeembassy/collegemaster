@extends('admin.layouts.app')

@section('title', $title)

@push('css')
  <link rel="stylesheet" href="{{ asset('assets/plugins/mohithg-switchery/dist/switchery.min.css') }}">
@endpush

@push('js')
  <script src="{{ asset('assets/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
@endpush

@section('content')
  @component('component.heading',
      [
          'page_title' => 'Customers',
          'icon' => '',
          'tagline' => 'Lorem ipsum dolor sit amet.',
      ])
    @if ($total_user > 0)
      <a href="{{ route('admin.export.excel', ['export' => 'customer']) }}" class="btn btn-success btn-sm">
        <i class="fas fa-file-export"></i> Customer Report Excel
      </a>
    @endif
  @endcomponent

  <div class="row">
    <div class="col-md-12">
      <div class="card p-0">
        <table class="table w-100" id="CustomerTable" data-url="{{ route('admin.customer.list') }}">
          <thead class="bg-light">
            <tr>
              <th style="width:12%" data-orderable="true">Name</th>
              <th style="width:15%" data-orderable="false">E-mail</th>
              <th style="width:15%">Mobile No</th>
              <th style="width:10%" data-orderable="true">Country</th>
              <th style="width:10%" data-orderable="true">Date</th>
              <th style="width:10%" data-orderable="true">Time</th>
              <th style="width:10%" data-orderable="true">Order</th>
              <th style="width:10%" data-orderable="true">Like</th>
              <th style="width:10%" data-orderable="false">Status</th>
              <th style="width:10%" data-orderable="false" class="text-center">Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div id="load-modal"></div>
@endsection

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      var table = $('#CustomerTable').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        "lengthMenu": [10, 25, 50],
        "responsive": true,
        // "iDisplayLength": 2,
        "ajax": {
          "url": $('#CustomerTable').attr('data-url'),
          "dataType": "json",
          "type": "POST",
          "data": function(d) {
            return $.extend({}, d, {});
          }
        },
        "order": [
          [4, "desc"]
        ],
        "columns": [{
            "data": "name"
          },
          {
            "data": "email"
          },
          {
            "data": "phone"
          },
          {
            "data": "country"
          },
          {
            "data": "created_at"
          },
          {
            "data": "time"
          },
          {
            "data": "order_status"
          },
          {
            "data": "wishlist"
          },
          {
            "data": "status"
          },
          {
            "data": "action"
          }
        ]
      });
    });
  </script>
@endpush
