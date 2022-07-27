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
    'page_title' => 'Contact us',
    'icon' => 'ik ik-phone' ,
    'tagline' =>'Lorem ipsum dolor sit amet.' ,
    //'action' =>'' ,
    //'action_icon' => '' ,
    //'text' => ''
])

@endcomponent

<div class="row">
    <div class="col-md-12">
        <div class="card p-0">
            <table class="table w-100" id="ContactTable" data-url="{{ route('admin.contact.list') }}">
                <thead class="bg-light">
                    <tr>
                        <th data-orderable="true">Name</th>
                        <th style="width:20%" data-orderable="false">Email</th>
                        <th style="width:20%" >Telephone</th>
                        <th style="width:20%" data-orderable="false">Subject</th>
                        <th style="width:25%" data-orderable="false" class="text-center">Action</th>
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
        var table = $('#ContactTable').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#ContactTable').attr('data-url'),
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
                    "data": "name"
                },
                {
                    "data": "email"
                },
                {
                    "data": "phone"
                },
                {
                    "data": "subject"
                },
                {
                    "data": "action"
                }
            ]
        });
    });
   
</script>
@endpush
