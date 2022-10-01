@extends('admin.layouts.app')

@section('title', $title)

@php
$aside = false;
@endphp



@section('content')
  <form action="{{ route('admin.inventory.store') }}" method="post">
    @csrf
    @component('component.heading',
        [
            'page_title' => 'Inventory',
            'icon' => 'ik ik-clipboard',
            'tagline' => 'Lorem ipsum dolor sit amet.',
            // 'action' => route('admin.inventory.create') ,
            'action_icon' => 'ik ik-plus',
            'text' => 'Create',
        ])
      <button class="showHideBulkEdit d-none btn btn-secondary btn-sm btn-rounded mr-3" type="submit"> <i class="fa fa-edit"></i> Bulk Edit</button>
      <button class="btn float-right btn-sm btn-info mx-2" data-target="#my-filter" data-toggle="collapse" aria-expanded="false" aria-controls="my-filter" type="button"><i class="fa fas fa-filter"></i> Filter</button>
      <button class="btn float-right btn-sm btn-primary" data-target="#my-collapse" data-toggle="collapse" aria-expanded="false" aria-controls="my-collapse" type="button"><i class="fa fas fa-filter"></i></button>



      {{-- <button class="btn btn-icon btn-rounded shadow btn-facebook right-sidebar-toggle" type="button"> <i class="ik ik-filter ik-1x"></i></button> --}}
    @endcomponent

    <div class="row">

      <div class="col-sm-12 " style="margin-bottom: 25px; ">
        <div class="row">
          <div class="col-12 ">
            <div id="my-filter" style="width: 100%;" class="collapse">
              <div class="card mb-0">
                <div class="card-body repeater">
                  <div class="form-row">
                    <div class="col-12 col-sm-4">
                      <div data-repeater-list="product_variants">
                        <div class="repeter-list" data-repeater-item>
                          <div class="form-row mt-15">
                            <div class="col-12">
                              <div class="form-group">
                                <label for="option_name">Option name</label>
                                <select name="option_name" id="option_name" class="form-control optionnameselect2 text-lowercase" data-rule-required="true" data-placeholder="Select Option name" data-url="{{ route('admin.get.option') }}">
                                  <option value=""></option>
                                </select>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group" data-rule-required="true">
                                <label for="input">variation</label>

                                <select id="variants_name" data-rule-required="true" data-target=".optionnameselect2" data-url="{{ route('admin.get.optionvalue') }}" name="variants_name" data-msg-required="Variation is required." style="width: 100%;"
                                  class="form-control text-lowercase variants_tags">
                                </select>

                              </div>
                            </div>
                            <div class="col-12">
                              <div class="mb-3">
                                <button type="button" data-repeater-delete class="btn social-btn btn-delelt-item btn-danger btn-sm shdow" value="Delete"><i class="fa fa-trash  text-white"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                          <hr>
                        </div>
                      </div>
                      <div class="col row mt-15">
                        <button type="button" data-repeater-create class="btn add-item-btn btn-success btn-sm shdow" value="Delete"><i class="fa  fa-plus-circle"></i> Add Option</button>
                        <button class="btn btn-secondary btn-sm btn-rounded mx-2 mr-3" type="submit"></i>Filter</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="my-collapse" style="width: 100%;" class="collapse">
              <div class="card mb-0">
                <div class="card-body">
                  <div class="form-row">
                    <div class="col-12 col-sm-4">
                      <select class="form-control input-sm category-select2" name="category" id="category" data-url="{{ route('admin.get.category') }}" data-rule-required="true" style="width: 100%;" data-placeholder="Select Product Category."
                        data-msg-required="Product category is required.">
                        <option value="" selected>Select Category</option>
                      </select>
                    </div>
                    <div class=" col-12 col-sm-4 ">
                      <a name="applyfilter" id="applyfilter" class="btn btn applyfilter btn-group-vertical btn-primary" href="#" role="button">Apply</a>
                      <a name="clearfilter" id="clearfilter" class="btn btn clearfilter btn-group-vertical btn-default" href="#" role="button">Clear</a>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card p-0">
          <table class="table w-100" id="bannderTable" data-url="{{ route('admin.inventory.list') }}">
            <thead class="bg-light">
              <tr>
                <th data-orderable="false" style="width:2%">
                  <div class="checkbox-zoom zoom-primary m-0">
                    <label class="m-0">
                      <input type="checkbox" id="checkAll">
                      <span class="cr m-0">
                        <i class="cr-icon ik ik-check txt-primary"></i>
                      </span>
                    </label>
                  </div>
                </th>
                <th class="text-center" data-orderable="true">Title</th>
                <th style="width:20%">Category</th>
                <th style="width:10%" data-orderable="true">Quantity</th>
                <th style="width:30%" data-orderable="false" class="text-center">Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </form>
@endsection


@push('js')
  <script src="{{ asset('js/variation.js') }}"></script>
  <script src="{{ asset('js/repeater.js') }}"></script>
@endpush

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {

      var table = $('#bannderTable').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        "lengthMenu": [10, 25, 50],
        "responsive": true,
        // "iDisplayLength": 2,
        "language": {
          "searchPlaceholder": "Product Name"
        },
        "ajax": {
          "url": $('#bannderTable').attr('data-url'),
          "dataType": "json",
          "type": "POST",
          "data": function(d) {
            return $.extend({}, d, {
              category: $('#category').val(),
              sub_category: $('#sub_category').val()
            });
          }
        },
        "order": [
          [0, "desc"]
        ],
        "columns": [{
            "data": "chckbox"
          },
          {
            "data": "title"
          },
          {
            "data": "category"
          },
          {
            "data": "status"
          },
          {
            "data": "option"
          }
        ]
      });

      categorySelect2 = $('.category-select2')
      subCategorySelect2 = $('.sub-category-select2')

      categorySelect2.select2({
        allowClear: true,
        ajax: {
          url: categorySelect2.data('url'),
          data: function(params) {
            return {
              search: params.term,
              id: $(categorySelect2.data('target')).val()
            };
          },
          dataType: 'json',
          cache: true,
          delay: 250,
          processResults: function(data) {
            return {
              results: data.data.map(function(item) {
                return {
                  id: item.id,
                  text: item.name,
                  otherfield: item,
                };
              }),
            }
          },
          cache: true,
          delay: 250
        },
        placeholder: 'Select Category',
        width: '100%',
        theme: 'bootstrap4'
        // minimumInputLength: 1,
      });


      $('.applyfilter , .clearfilter').on('click', function(e) {

        if ($(this).is('#applyfilter')) {
          table.ajax.reload();
        } else {
          categorySelect2.val(null).trigger('change')
          subCategorySelect2.val(null).trigger('change')
          table.ajax.reload();
        }

      });

      categorySelect2.on('select2:select', function(e) {
        var el = $(this);
        subCategorySelect2.val(null).trigger('change');
      })


      $(".right-sidebar-toggle").on("click", function(e) {
        this.classList.toggle('active');
        $('.wrapper').toggleClass('right-sidebar-expand');
        return false;
      });

      $(document).on('click', '.option-btn', function() {

        var el = $(this);
        var qty = $(el.attr('data-target'));
        var url = el.attr('data-url');

        if (!qty.val()) {
          return true;
        }

        $.ajax({
          type: "GET",
          url: url,
          data: {
            qty: qty.val()
          }
        }).always(function(respons) {}).done(function(respons) {

          message.fire({
            type: 'success',
            title: 'Success',
            text: respons.message
          });

          qty.val('');
          table.ajax.reload();

        }).fail(function(respons) {
          message.fire({
            type: 'error',
            title: 'Error',
            text: 'something went wrong please try again !'
          });
        });;


      });


      $(document).on('click', ".is_check", function() {

        var checked = $('.is_check').length;
        var is_checked = $('input[name="ids[]"]:checked').length;

        if (is_checked == checked && is_checked > 1) {
          $("#checkAll").prop('checked', true);
          $('.showHideBulkEdit').removeClass('d-none');
        } else {
          $("#checkAll").prop('checked', false);
          $('.showHideBulkEdit').addClass('d-none');
        }
        (is_checked > 0) ? $('.showHideBulkEdit').removeClass('d-none'): $('.showHideBulkEdit')
          .addClass('d-none');


      });

      $("#checkAll").click(function() {

        var is_checked = $('input[name="ids[]"]:checked').length;

        $('input:checkbox').not(this).prop('checked', this.checked);
        $('.showHideBulkEdit').addClass('d-none');
        if ($(this).prop('checked')) {
          $('.showHideBulkEdit').removeClass('d-none');
        }

      });


    });
  </script>
@endpush
