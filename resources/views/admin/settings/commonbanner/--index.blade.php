@extends('admin.layouts.app')

@section('content')
<div class="row d-flex mb-2">
    <div class="d-flex justify-content-between align-items-center col">
        <h4>{{ $title }}</h4>
        <div>
            <a href="{{ route('admin.category.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus-circle"></i> Create
            </a>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-lg-5">
        <p class="text-muted">
            The Role Permissions Manager allows you to set which roles can access which documents and with what
            permissions (read, write, submit, etc.).
        </p>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-valign-middle" id="roletable" data-url="{{ route('admin.category.dataList') }}"
                    style="width: 100%;">
                    <tdead  class="bg-light">
                        <tr>
                            <td style="width:1%">No</td>
                            <td style="width:25%" data-orderable="true">Title</td>
                            <td style="width:10%" data-orderable="false">Status</td>
                            <td style="width:10%" data-orderable="false">Action</td>
                        </tr>
                    </tdead>
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
        let admin = $('#roletable').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#roletable').attr('data-url'),
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