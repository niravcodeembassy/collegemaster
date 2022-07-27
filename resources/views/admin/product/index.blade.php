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
    'page_title' => $title,
    'icon' => 'fa fa-shopping-cart' ,
    'action' => route('admin.product.create') ,
    'action_icon' => 'fa fa-plus' ,
    'text' => 'Add Product'
])@endcomponent

@php
    $Category = App\Category::get();
    $category_id = Request::get('category_id');
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body ">
                <form  method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($Category as $item)
                                    <option value="{{$item->id}}" @if($category_id != null && $category_id == $item->id) {{ "selected" }} @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-secondary btn-sm shadow">Filter</button>
                            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary btn-sm shadow">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body p-0">
                <table class="table w-100" id="bannderTable" data-url="{{ route('admin.product.list') }}">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" data-orderable="true">Product Details</th>
                            <th style="width:15%" class="text-center">Category</th>
                            <th style="width:15%" class="text-center">Sub Category</th>
                            <th style="width:10%"  data-orderable="false">Status</th>
                            <th style="width:15%" data-orderable="false" class="text-center">Action</th>
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
    $(document).ready(function () {
        $('#bannderTable').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#bannderTable').attr('data-url'),
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    var category_id = $('#category_id').val();
                    return $.extend({}, d, {
                        'category_id' : category_id
                    });
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [{
                    "data": "title"
                },
                {
                    "data": "category"
                },
                {
                    "data": "subcategory"
                },
                {
                    "data": "status"
                },
                {
                    "data": "option"
                }
            ]
        });
    });

</script>
@endpush
