<div class="modal fade" id="addcategory" role="dialog" aria-labelledby="addcategory" aria-hidden="true">
    <div class="modal-dialog" permission="document">
        <form name="optionvalueForm" id="optionvalueForm" method="post"
            data-exists="{{ route('admin.optionvalue.exists' ,['id' => $optionvalue->id??null ]) }}"
            action="{{route('admin.optionvalue.store') }} ">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                    Add Attribute Vlaue </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="form-errors"></div>
                    <div class="form-group m-form__group">
                        <label for="option_id" class="form-control-label">Attribute : <i
                                class="text-danger">*</i></label>
                        <select name="option_id" data-rule-required="false" data-placeholder="Select Attribute"
                            data-url="{{ route('admin.get.option') }}" id="option_id" class="form-control">
                            <option value="">Select option</option>
                        </select>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="form-errors"></div>
                    <div class="form-group m-form__group">
                        <label for="option_value" class="form-control-label">Attribute value: <i
                                class="text-danger">*</i></label>
                        <input type="text" class="form-control" id="option_value"
                            name="option_value"
                            data-msg-remote="Please enter unique opton value" maxlength="190">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light  " data-dismiss="modal"><i
                            class="ik ik-x"></i>Close</button>
                    <button type="submit" class="btn btn-success  shadow" id="next"><i
                            class="ik ik-check-circle">
                        </i>Save</button>
                </div>

            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function ($) {

        let $rolePermission = $('#option_id');

        $rolePermission.select2({
            theme: 'bootstrap4',
            ajax: {
                url: function () {
                    return $(this).data('url')
                },
                data: function (params) {
                    return {
                        search: params.term,
                    };
                },
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data.data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.name,
                                otherfield: item,
                            };
                        }),
                    }
                },
                //cache: true,
                delay: 250
            },
        })

        $('#optionvalueForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                option_value: {
                    required: true,
                    remote: {
                        url: $('#optionvalueForm').data('exists'),
                        type: "post",
                        data : {
                            option : function(){
                                return $('#option_id').val();
                            },
                        },
                    }
                }
            },
            messages: {
                name: {
                    remote: "Please enter unique option value",
                }
            },
            errorPlacement: function (error, element) {
                // $(element).addClass('is-invalid')
                error.appendTo(element.parent()).addClass('text-danger');
            }
        });

    });

</script>
