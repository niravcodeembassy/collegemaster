@extends('admin.layouts.app')

@section('content')
    <div class="row d-flex mb-2">
        <div class="d-flex justify-content-end align-items-center col">
            <div>

                <a href="javascript:void(0)"
                   class="btn call-modal btn-secondary btn-sm mr-3"
                   data-url="{{ route('admin.optionvalue.create') }}"
                   data-target-modal="#addcategory">
                    <i class="fa fa-plus"></i> Add
                </a>


                <a href="{{ route('admin.website-setting') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>

            </div>
        </div>
    </div>

    <div class="row mt-3">

        <div class="col-lg-4">
            <h4>Attributes Value</h4>
            <p class="text-muted">
               Here you can specify all the option value that will be apper in product valriation
            </p>

        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-valign-middle" id="optionvlauetable" data-url="{{ route('admin.optionvalue.list') }}" style="width: 100%;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width:1%">No</th>
                                    <th style="width:25%" data-orderable="true">Title</th>
                                    <th style="width:25%" data-orderable="false">Attribute</th>
                                    <th style="width:5%" data-orderable="false">Status</th>
                                    <th style="width:3%" class="text-center" data-orderable="false">Action</th>
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
            $('#optionvlauetable').DataTable({
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                "lengthMenu": [10, 25, 50],
                "responsive": true,
                // "iDisplayLength": 2,
                "ajax": {
                    "url": $('#optionvlauetable').attr('data-url'),
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
                        "data": "option"
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
