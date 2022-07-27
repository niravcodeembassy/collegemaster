@extends('admin.layouts.app')

@section('content')
<div class="row d-flex mb-2">
  <div class="d-flex justify-content-between align-items-center col">
    <h4>Tag</h4>
    <div>
      <a href="javascript:void(0)" class="btn call-modal btn-secondary btn-sm mr-3"
        data-url="{{ route('admin.tag.create') }}" data-target-modal="#addtag">
        <i class="fa fa-plus"></i> Add
      </a>
    </div>
  </div>
</div>

<div class="row mt-3">
  <div class="col-lg-4">
    <p class="text-muted">Create Tag of blog like ex.shop,stores</p>
  </div>
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body p-0">
        <table class="table table-valign-middle" id="tagtable" data-url="{{ route('admin.tag.dataList') }}"
          style="width: 100%;">
          <thead class="bg-light">
            <tr>
              <th style="width:1%">No</th>
              <th style="width:25%" data-orderable="true">Tag</th>
              <th style="width:10%" data-orderable="false">Status</th>
              <th style="width:10%" data-orderable="false">Action</th>
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
            let admin = $('#tagtable').DataTable({
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                "lengthMenu": [10, 25, 50],
                "responsive": true,
                // "iDisplayLength": 2,
                "ajax": {
                    "url": $('#tagtable').attr('data-url'),
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                    }
                },

                "order": [
                    [0, "desc"]
                ],
                "columns": [
                    {
                        "data": "id"
                    },
                    {
                        "data": "name"
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
