<div class="modal fade edit-layout-modal pr-0" id="editLayoutItem" tabindex="-1" role="dialog"
    aria-labelledby="editLayoutItemLabel" aria-hidden="true" >
    <form
        action="{{ route('admin.variation.variation_add_save' , [ 'product_id' => $product->id  ]) }}" id="variantformeditform" method="post" enctype="multipart/form-data" data-id="{{ $productvariant->id }}">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLayoutItemLabel">Add Variant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="form-row">

                        <div class="col-md-12 px-sm-3 px-2">

                            <h6 class="text-mute"><strong>Variation</strong></h6>
                            <hr>

                            @if ($productvariant->option->count() > 0)

                                @foreach ($productvariant->option as $key => $combination_item)
                                    <div class="form-group">

                                       <label for="option_{{$key}}">{{ $combination_item->name }} <span class="text-danger">*</span></label>

                                        <input id="option_{{$key}}" class="form-control"
                                            value="" type="text" name="option[]"
                                            data-rule-required="true"
                                            data-msg-required="{{ $combination_item->name }} is required.">
                                    </div>
                                    <input type="hidden" name="option_id[]" value="{{ $combination_item->id }}">
                                @endforeach

                            @endif
                            <br>
                            <h6 class="text-mute"><strong>Pricing</strong></h6>
                            <hr>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="mrp_price">MRP  <span class="text-danger">*</span> </label>
                                    <input id="mrp_amount" class="form-control" data-rule-required="true"
                                        data-msg-required="MRP  is required." data-rule-number="true" type="text"
                                        value="" name="mrp_amount">
                                </div>

                                <div class="form-group col">
                                    <label for="offer_price">Offer Price</label>
                                    <input id="offer_price" name="offer_price" data-rule-required="false"
                                        data-rule-number="true" class="form-control" type="text" name=""
                                        value="">
                                </div>
                            </div>

                            <br>
                            <h6 class="text-mute"><strong>Inventory</strong></h6>
                            <hr>


                            <div class="form-group">
                                <label for="inventory_quantity">Quantity <span class="text-danger">*</span></label>
                                <input id="my-input" class="form-control" data-rule-required="true"
                                    data-msg-required="Quantity is required." type="text" id="quantity"
                                    name="inventory_quantity" value="1">
                            </div>

                        </div>
                        <div class="col px-3">
                            <div class="card">
                                <div class="card-body border">

                                    <div class="form-group">
                                        <div class="text-center">
                                            <img src="{{ asset('storage/default/default.png') }}"
                                                data-default="{{ asset('storage/default/default.png') }}" class="w-100"
                                                style="height: 220px;object-fit: cover;" id="preview">
                                                <input type="hidden" id="image_id" name="image_id" value="">
                                        </div><br>
                                    </div>

                                    <div class="form-group">
                                        <input type="file" name="slider_image" class=" d-none   file-upload-default"
                                            data-rule-accept="jpg,png,jpeg"
                                            data-msg-accept="Only image type jpg/png/jpeg is allowed."
                                            data-rule-required="false" data-rule-filesize="5000000" id="featured_image"
                                            data-msg-required="Image is required."
                                            data-msg-filesize="File size must be less than 5mb">
                                        {{-- <div class="input-group mb-2"> --}}
                                        <div class="justify-content-center d-flex mb-2">
                                            {{-- <input type="text" class="form-control " disabled=""
                                                placeholder="Upload Image">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse shadow-sm btn btn-primary"
                                                    type="button">Upload</button>
                                            </span> --}}
                                            <button type="button" class="btn shadow btn-info " data-toggle="modal" data-target="#my-modal">Select Image</button>




                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger shadow" data-dismiss="modal"> <i class="ik ik-x"></i>
                        Close </button>
                    <button type="submit" class="btn btn-success shadow"> <i class="ik ik-check-circle"></i> Update
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $.validator.addMethod('filesize', function (value, element, param) {
        if (element.files.length) {
            return this.optional(element) || (element.files[0].size <= param)
        }
        return true;
    }, 'File size must be less than 5mb.');

    $(document).ready(function () {

        $(document).on('click', '.file-upload-browse', function () {
            var file = $(this).parents().find('.file-upload-default');
            file.trigger('click');
        });

        $(document).on('click', '.file-upload-clear', function () {
            $('.file-upload-default').val('');
            $('.file-upload-default').trigger('change');
        });

        $(document).on('change', '.file-upload-default', function () {
            var el = $(this);
            var preview = $('#preview');

            if (el.val() && el.valid()) {
                readURL(this);
                el.parent().find('.form-control').val(el.val().replace(/C:\\fakepath\\/i, ''));
                return true;
            }

            preview.attr('src', preview.data('default'));
            el.val('');
            el.parent().find('.form-control').val(el.val().replace(/C:\\fakepath\\/i, ''));
        });

        var readURL = function (input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview').attr('src', e.target.result)
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#variantformeditform').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {},
            messages: {},
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (form , e) {

                e.preventDefault();

                var url  = $(form).attr('action');

                var id = $(form).data('id');

                var data = new FormData(document.getElementById('variantformeditform'));

                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    processData: false,
                    contentType: false,
                }).always(function(res){

                })
                .done(function(res){

                    $('.row.layout-wrap').prepend(res.html);
                    $('#editLayoutItem').modal('toggle');
                    message.fire({
                        type: 'success',
                        title: 'Success' ,
                        text: res.message
                    });

                }).fail(function(res){
                    message.fire({
                        type: 'error',
                        title: 'Error',
                        text: 'something went wrong please try again !'
                    });
                });


                console.log( data);
            }
        });

    });

</script>
