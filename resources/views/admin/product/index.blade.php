@extends('admin.layouts.app')

@section('title', $title)

@push('css')
  <link rel="stylesheet" href="{{ asset('assets/plugins/mohithg-switchery/dist/switchery.min.css') }}">
@endpush

@push('js')
  <script src="{{ asset('assets/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
@endpush

@section('content')

  @component('component.heading',
      [
          'page_title' => $title,
          'icon' => 'fa fa-shopping-cart',
          'action' => route('admin.product.create'),
          'action_icon' => 'fa fa-plus',
          'text' => 'Add Product',
      ])
  @endcomponent

  <div class="col mb-2">

    <div class="d-flex justify-content-end align-items-center ">
      <a href="{{ route('admin.export.excel', ['export' => 'product']) }}" class="btn btn-success btn-sm">
        <i class="fas fa-file-export"></i> Best Selling Product Excel
      </a>
      <a href="{{ route('admin.export.pdf', ['export' => 'product']) }}" class="btn btn-warning btn-sm mx-2">
        <i class="fa fa-file-pdf"></i> Best Selling Product PDF
      </a>
    </div>
  </div>



  @php
    $Category = App\Category::get();
    $subCategory = App\Model\SubCategory::get();
    $category_id = Request::get('category_id');
    $sub_category_id = Request::get('sub_category_id');

    $filter_category = $Category->where('id', $category_id)->first();
    $filter_sub_category = $subCategory->where('id', $sub_category_id)->first();
  @endphp
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body ">
          <form method="GET">
            <div class="row">
              <div class="col-md-6 d-flex ">
                {{-- <select name="category_id" id="category_id" class="form-control">
                  <option value="">Select Category</option>
                  @foreach ($Category as $item)
                    <option value="{{ $item->id }}" @if ($category_id != null && $category_id == $item->id) {{ 'selected' }} @endif>{{ $item->name }}</option>
                  @endforeach
                </select> --}}

                <select class="form-control category-select2" name="category_id" id="category_id" data-url="{{ route('admin.get.category') }}" data-placeholder="Select Category." data-msg-required="Product category is required.">
                  <option value="" selected>Select Category</option>
                  @if (isset($filter_category))
                    <option value="{{ $filter_category->id }}" selected>{{ $filter_category->name }}</option>
                  @endif
                </select>
                &nbsp;
                <select class="form-control sub-category-select2" name="sub_category_id" id="sub_category_id" data-url="{{ route('admin.get.sub-category') }}" data-target="#category_id" data-placeholder="Select Sub Category."
                  data-msg-required="Product Sub category is required.">
                  <option value="" selected>Select Sub Category</option>
                  @if (isset($filter_sub_category))
                    <option value="{{ $filter_sub_category->id }}" selected>{{ $filter_sub_category->name }}</option>
                  @endif
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
                <th style="width:10%" data-orderable="false">Status</th>
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
    $(document).ready(function() {
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
          "data": function(d) {
            var category_id = $('#category_id').val();
            var sub_category_id = $('#sub_category_id').val();
            console.log(category_id, sub_category_id);
            return $.extend({}, d, {
              'category_id': category_id,
              'sub_category_id': sub_category_id
            });
          }
        },
        "order": [
          [0, "asc"]
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

      categorySelect2 = $(".category-select2");
      subCategorySelect2 = $(".sub-category-select2");

      categorySelect2.select2({
        // allowClear: true,
        ajax: {
          url: categorySelect2.data("url"),
          data: function(params) {
            return {
              search: params.term,
              id: $(categorySelect2.data("target")).val(),
            };
          },
          dataType: "json",
          processResults: function(data) {
            return {
              results: data.data.map(function(item) {
                return {
                  id: item.id,
                  text: item.name,
                  otherfield: item,
                };
              }),
            };
          },
          cache: true,
          delay: 250,
        },
        placeholder: "Select Category",
        theme: "bootstrap4",
        // minimumInputLength: 1,
      });

      subCategorySelect2.select2({
        // allowClear: true,
        ajax: {
          url: subCategorySelect2.data("url"),
          data: function(params) {
            return {
              search: params.term,
              id: $(subCategorySelect2.data("target")).val(),
            };
          },
          dataType: "json",
          processResults: function(data) {
            return {
              results: data.data.map(function(item) {
                return {
                  id: item.id,
                  text: item.name,
                  otherfield: item,
                };
              }),
            };
          },
          cache: true,
          delay: 250,
        },
        placeholder: "Select Sub Category",
        theme: "bootstrap4",
        // minimumInputLength: 1,
      });

    });
  </script>
@endpush
