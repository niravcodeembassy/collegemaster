@extends('admin.layouts.app')

@section('title' , $title)

@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/mohithg-switchery/dist/switchery.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('assets/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
@endpush


@section('content')
@component('component.heading',[

'page_title' => 'Manage Pages',
'icon' => 'fa fa-file' ,
'tagline' =>'Lorem ipsum dolor sit amet.' ,

'action' => route('admin.website-setting'),
'action_icon' => 'fa fa-arrow-left' ,
'text' => 'Back',


])
<a href="{{ route('admin.pages.create') }}" class="btn btn btn-secondary btn-sm ml-3">
  <i class="fa fa-plus "></i> Add Page
</a>
@endcomponent

<div class="row">
  <div class="col-md-12">
    <div class="card p-0">
      <table class="table w-100" id="pagesTable" data-url="{{ route('admin.pages.list') }}">
        <thead class="bg-light">
          <tr>
            <td style="width:5%">#</td>
            <td style="width:40%">Title</td>
            <td style="width:15%" data-orderable="false" class="text-center">Action</td>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">
  $(document).ready(function () {
          var table = $('#pagesTable').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#pagesTable').attr('data-url'),
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
                    "data": "title"
                },
                {
                    "data": "action"
                }
            ]
        });


            $(document).on('click' ,'.delete-confirm', function (e) {

                e.preventDefault();

                var el = $(this);
                var url = el.attr('href');
                var id = el.data('id');
                var refresh = el.closest('table');
                console.log(refresh);

                message.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-success shadow-sm mr-2',
                        cancelButton: 'btn btn-danger shadow-sm'
                    },
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                id : id ,
                                _method : 'DELETE'
                            }
                        }).always(function(respons){

                            table.ajax.reload();

                        }).done(function(respons){

                            message.fire({
                                type: 'success',
                                title: 'Success' ,
                                text: respons.message
                            });

                        }).fail(function(respons){

                            message.fire({
                                type: 'error',
                                title: 'Error',
                                text: 'something went wrong please try again !'
                            });

                        });
                    }
                });
            });

        });

</script>

<!-- <script>
    $(document).ready(function () {
        var table = $('#advanced_table').DataTable();
        var table = $('#order-table').DataTable();

        var sw = $('.js-switch').toArray();
        sw.forEach(function(html) {
          var switchery = new Switchery(html);
        });



    });
</script> -->
@endpush
