@extends('admin.layouts.app')

@section('title' , $title)

@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/mohithg-switchery/dist/switchery.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('assets/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
@endpush

@section('content')
<div class="row d-flex mb-2">
  <div class="d-flex justify-content-between align-items-center col">
    <h4>{{ $title }}</h4>
    <div>
      <a href="{{ route('admin.review.create') }}" class="btn btn-secondary btn-sm">
        <i class="fa fa-plus"></i> Add
      </a>
    </div>
  </div>
</div>




<div class="row">
  <div class="col-md-12">
    <div class="card p-0">
      <table class="table w-100" id="CustomerTable" data-url="{{ route('admin.review.list') }}">
        <thead class="bg-light">
          <tr>
            <th data-orderable="true">Product</th>
            <th data-orderable="true">Name</th>
            <th style="width:20%" data-orderable="false">E-mail</th>
            <th style="width:5%">Star</th>
            <th style="width:5%" data-orderable="false">Status</th>
            <th style="width:12%" data-orderable="false" class="text-center">Action</th>
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
  $(document).ready(function () {
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
                "data": function (d) {
                    return $.extend({}, d, {});
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [
                {
                    "data": "product"
                },
                {
                    "data": "name"
                },
                {
                    "data": "email"
                },
                {
                    "data": "review"
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
