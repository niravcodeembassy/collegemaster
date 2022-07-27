@extends('admin.layouts.app')

@section('content')
<div class="row d-flex mb-2">
  <div class="d-flex justify-content-between align-items-center col">
    <h4>{{ $title }}</h4>
    <div>
      <a href="{{ route('admin.blog.create') }}" class="btn btn-secondary btn-sm">
        <i class="fa fa-plus"></i> Add
      </a>
    </div>
  </div>
</div>

<div class="row mt-3">
  {{-- <div class="col-lg-4">
    <p class="text-muted">
      The Role Permissions Manager allows you to set which roles can access which documents and with what
      permissions (read, write, submit, etc.).
    </p>
  </div> --}}
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body p-0">
        <table class="table table-valign-middle" id="blogtable" data-url="{{ route('admin.blog.dataList') }}"
          style="width: 100%;">
          <thead class="bg-light">
            <tr>
              <th style="width:1%">No</th>
              <th style="width:25%" data-orderable="true">Title</th>
              <th style="width:25%" data-orderable="true">Created At</th>
              <th style="width:10%" data-orderable="false">Status</th>
              <th style="width:10%" class="text-center" data-orderable="false">Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

  </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
  $(document).ready(function () {
        let admin = $('#blogtable').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#blogtable').attr('data-url'),
                "dataType": "json",
                "type": "POST",
            },

            "order": [
                [0, "desc"]
            ],
            "columns": [
                {
                    "data": "id"
                },
                {
                    "data": "title"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "status"
                },
                {
                    "data": "action"
                },
            ]
        });
    });
</script>
@endpush
