@extends('admin.layouts.app')

@section('title' , $title)

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/mohithg-switchery/dist/switchery.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
@endpush

@section('content')
@component('component.heading' , [
    'page_title' => 'Discount',
    'icon' => 'fa fa-percent' ,
    'tagline' =>'Lorem ipsum dolor sit amet.' ,
    'action' => route('admin.discount.create') ,
    'action_icon' => 'fa fa-plus' ,
    'text' => 'Add'
])
@endcomponent

<div class="row">
    <div class="col-sm-12">
        <div class="card">
             <div class="card-body p-0 ">
                <div class="dt-responsive">
                    <table class="table w-100" id="dicountTable" data-url="{{ route('admin.discount.list') }}">
                        <thead class="bg-light">
                            <tr>
                                <th style="width:5%">#</th>
                                <th style="width:20%" class="text-center" data-orderable="false">Code</th>
                                <th style="width:20%" class="text" data-orderable="false">Start date</th>
                                <th style="width:20%" >End date</th>
                                <th style="width:20%" data-orderable="false">Used Coupon </th>
                                <th style="width:8%" data-orderable="false" class="text-left">Status</th>
                                <th style="width:15%" data-orderable="false" class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
             </div>
        </div>
        <!-- Language - Comma Decimal Place table end -->
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var table2 = $('#dicountTable').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#dicountTable').attr('data-url'),
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
                    "data": "code"
                },
                {
                    "data": "start_date"
                },
                {
                    "data": "end_date"
                },
                {
                    "data": "noOfUse"
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
