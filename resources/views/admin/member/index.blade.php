@extends('admin.layouts.app')

@section('title', $title)

@section('content')
  <div class="row d-flex mb-2">
    <div class="d-flex justify-content-between align-items-center col">
      <h4>{{ $title }}</h4>
      <div>
        <a href="{{ route('admin.team.create') }}" class="btn btn-secondary btn-sm">
          <i class="fa fa-plus"></i> Add
        </a>
      </div>
    </div>
  </div>




  <div class="row">
    <div class="col-md-12">
      <div class="card p-0">
        <table class="table w-100" id="teamTable" data-url="{{ route('admin.team.list') }}">
          <thead class="bg-light">
            <tr>
              <th style="width:25%" data-orderable="true">Name</th>
              <th style="width:20%">Designation</th>
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
    $(document).ready(function() {
      var table = $('#teamTable').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        "lengthMenu": [10, 25, 50],
        "responsive": true,
        // "iDisplayLength": 2,
        "ajax": {
          "url": $('#teamTable').attr('data-url'),
          "dataType": "json",
          "type": "POST",
          "data": function(d) {
            return $.extend({}, d, {});
          }
        },
        "order": [
          [0, "desc"]
        ],
        "columns": [{
            "data": "title"
          },
          {
            "data": "designation"
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
