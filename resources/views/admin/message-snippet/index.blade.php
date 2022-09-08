@extends('admin.layouts.app')

@section('title', $title)

@section('content')
  <div class="row d-flex mb-2">
    <div class="d-flex justify-content-between align-items-center col">
      <h4>{{ $title }}</h4>
      <div>
        <a href="{{ route('admin.message-snippet.create') }}" class="btn btn-secondary btn-sm">
          <i class="fa fa-plus"></i> Add
        </a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body p-0">
          <table class="table table-valign-middle" id="snippetTable" data-url="{{ route('admin.message-snippet.dataList') }}" style="width: 100%;">
            <thead class="bg-light">
              <tr>
                <th style="width:1%">No</th>
                <th style="width:25%" data-orderable="true">Title</th>
                <th style="width:10%" data-orderable="false">Status</th>
                <th style="width:10%" class="text-center" data-orderable="false">Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      var table = $('#snippetTable').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        "lengthMenu": [10, 25, 50],
        "responsive": true,
        // "iDisplayLength": 2,
        "ajax": {
          "url": $('#snippetTable').attr('data-url'),
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
            "data": "id"
          },
          {
            "data": "title"
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
