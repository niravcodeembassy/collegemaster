@extends('admin.layouts.app')

@section('title' , $title)

@section('content')

<div class="row d-flex mb-3">
    <div class="d-flex justify-content-end align-items-center col">
        <div>
            <a href="javascript:void(0)" class="btn call-modal btn-secondary btn-sm mr-3"
                data-url="{{ route('admin.hscode.create') }}" 
                data-target-modal="#addcategory">
                <i class="fa fa-plus"></i> Add
            </a>
            <a href="{{ route('admin.website-setting') }}" 
                class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="row">
    @include('component.error')

    <div class="col-sm-4">
        <h5 class=""><strong>HSN code</strong></h5>
        <p class="text-muted">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. </p>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-valign-middle " id="hscodeDataTable" data-url="{{ route('admin.hscode.list') }}" style="width: 100%;">
                   <thead class="bg-light">
                        <tr>
                            <th style="width:5%">#</th>
                            <th style="width:40%">Name</th>
                            <th style="width:5%" data-orderable="false" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Model -->

{{-- <div id="load-modal"></div> --}}

@endsection

@push('scripts')
    <script>
    $(document).ready(function () {
        var table = $('#hscodeDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#hscodeDataTable').attr('data-url'),
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
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
                    "data": "name"
                },
                {
                    "data": "action"
                }
            ]
        });
    });
    </script>
@endpush
