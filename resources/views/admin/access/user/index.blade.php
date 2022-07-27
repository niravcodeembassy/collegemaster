@extends('admin.layouts.app')

@section('content')
<div class="row d-flex mb-2">
    <div class="d-flex justify-content-between align-items-center col">
        <h4>Users</h4>
        <a href="{{ route('admin.user.create') }}" class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i> Add </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Hello
            </div>
            <div class="card-body p-0">
                <table class="table table-valign-middle" id="roletable" data-url="{{ route('admin.user.dataList') }}" style="width: 100%;">
                        <thead class="bg-light">
                            <tr>
                                <th style="width:25%" data-orderable="true">Name</th>
                                <th style="width:10%" data-orderable="true">Email</th>
                                <th style="width:20%" data-orderable="false">Roles</th>
                                <th style="width:10%" data-orderable="true">Status</th>
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
                    "data": {}
                },
          
                "order": [
                    [0, "desc"]
                ],
                "columns": [
                    {
                        "data": "name"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "roels"
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
