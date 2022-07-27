@extends('admin.layouts.app')

@section('title' , $title)

@push('css')
{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/mohithg-switchery/dist/switchery.min.css') }}"> --}}
@endpush
@push('style')
<style>
    tbody td {
        text-align: center;
    }
</style>
@endpush
@push('js')
{{-- <script src="{{ asset('assets/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script> --}}
@endpush

@section('content')
@component('component.heading' , [
'page_title' => 'Order',
'icon' => 'fa fa-shopping-bag' ,
'tagline' =>'Lorem ipsum dolor sit amet.' ,
'action' => null ,
'action_icon' => 'fa fa-plus' ,
'text' => ''
])
@endcomponent

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <ul class="nav">
                    <li class="nav-item ">
                        <a href="{{ route('admin.order.index' , ['type' => "online" ]) }}"
                            class="nav-link p-0 px-2 {{ $type === 'online' ? 'text-primary' : '' }}">Online</a>
                    </li>                    
                    <li class="nav-item  ">
                        <a href="{{ route('admin.order.index',['type'=>'cod']) }}"
                            class="nav-link p-0 px-2 {{ $type === 'cod' ? 'text-primary' : '' }}">COD</a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{ route('admin.order.index' , ['type' => "pending" ]) }}"
                            class="nav-link p-0 px-2 {{ $type === 'pending' ? 'text-primary' : '' }}">Online pending</a>
                    </li>                    
                </ul>
            </div>
            <div class="card-body p-0 ">
                <div class="dt-responsive">
                    <table class="table w-100" id="order_table"
                        data-url="{{ route('admin.order.list',['type' => $type]) }}">
                        <thead class="bg-light">
                            <tr>
                                <th class=" text-center nosort">Order No</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Customer</th>
                                <th class="text-center" data-orderable="false">Qty</th>
                                <th class="text-center">Payment status</th>
                                <th class="text-center">Order status</th>
                                <th class="text-center">Total</th>
                                <th class="text-center" data-orderable="false">Action</th>
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
@push('css')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
@endpush
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.28.0/moment.min.js"></script>
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js">
</script>
@endpush
@push('scripts')
<script>
    $(document).ready(function () {
        var table = $('#order_table').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "ajax": {
                "url": $('#order_table').attr('data-url'),
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    return $.extend({}, d, {
                        _token: "{{csrf_token()}}",
                        // 'delivery_status' :
                        payment_status: $('#filter').val(),
                        delivery_status: $('#delivery_status_filter').val(),
                        from_date: $('#from_date').val(),
                        to_date: $('#to_date').val(),
                    });
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [

                {
                    "data": "orderNumber"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "customerName"
                },
                {
                    "data": "qty"
                },
                {
                    "data": "paymentSatatus"
                },

                {
                    "data": "deliveryStatus"
                },
                {
                    "data": "totalPrice"
                },
                {
                    "data": "action"
                },

            ]
        });
    });
</script>
@endpush
