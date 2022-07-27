<div class="modal fade" id="addcategory" tabindex="-1" role="dialog" aria-labelledby="addbrand" aria-hidden="true">
        <div class="modal-dialog  modal-md" role="document">
            <form action="{{ route('admin.hscode.update' , ['hscode' => $hscode->id ]) }}" method="POST" id="hscodedform" name="hscodedform" enctype="multipart/form-data">
                @csrf()
                @method('PUT')

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" >Edit HSN code</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"  data-msg-required="HSN code is required." >&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input id="name" class="form-control" value="{{ $hscode->name ??  '' }}"
                                                   data-rule-remote="{{ route('admin.hscode.exists' , ['id' => $hscode->id] ) }}"
                                                   data-msg-remote="hscode is already exists"
                                                   type="text" name="name"
                                                data-rule-required="true">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="percentage">Percentage <span class="text-danger">*</span></label>
                                            <input id="percentage" class="form-control" value="{{ $hscode->percentage ??  '' }}"
                                                    data-rule-number="true"
                                                   type="text" name="percentage"
                                                   min="1" max="100"
                                                data-rule-required="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-sm-12">
                                <div class="form-row">
                                    <div class="col-12 w-50">
                                        <div class="text-left">
                                            <img src="{{ $brand->brand_image }}"
                                                data-default="{{ $brand->brand_image }}" class="w-70"
                                                id="preview">
                                        </div><br>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="file" name="slider_image" class="file-upload-default"
                                                data-rule-accept="jpg,png,jpeg"
                                                data-msg-accept="Only image type jpg/png/jpeg is allowed."
                                                data-rule-required="flase" data-rule-filesize="5000000" id="featured_image"
                                                data-msg-required="Image is required."
                                                data-msg-filesize="File size must be less than 5mb">
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control file-upload-info" disabled=""
                                                    placeholder="Upload Image">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse shadow-sm btn btn-primary"
                                                        type="button">Upload</button>
                                                </span>
                                                <span class="input-group-append">
                                                    <button class="file-upload-clear btn shadow-sm btn-danger"
                                                        type="button">Clear</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="ik ik-x"></i>Close</button>
                        <button type="submit" class="btn btn-success shadow"><i class="ik ik-check-circle">
                            </i>Success</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <script>

    $(document).ready(function () {

        $('#hscodedform').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {},
            messages: {},
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (e) {
                return true;
            }
        })

    });
</script>
