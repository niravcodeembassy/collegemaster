<div class="modal fade" id="addcategory" role="dialog" aria-labelledby="addcategory" aria-hidden="true">
    <div class="modal-dialog" permission="document">
        <form name="savepermissionsForm" id="savepermissionsForm" method="post"
            data-exists="{{ route('admin.permission.exists' ,['id' => $permission->id??null ]) }}"
            action="{{route('admin.permission.store')}}">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{(isset($permission)) ? 'Edit Permission':'Add permission'}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="form-errors"></div>
                    <div class="form-group m-form__group">
                        <label for="parent_id" class="form-control-label">Modules: <i
                                class="text-danger">*</i></label>
                        <select name="parent_id" data-rule-required="false" data-placeholder="Select Permission"
                            data-url="{{ route('admin.get.permission' ,['parent' => true]) }}"
                            id="parent_id" class="form-control">
                            <option value="">Select permission</option>
                        </select>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="form-errors"></div>
                    <div class="form-group m-form__group">
                        <label for="permissions_name" class="form-control-label">Permissions Name: <i
                                class="text-danger">*</i></label>
                        <input type="text" class="form-control" id="permissions_name" name="permissions_name"
                            value="{{ $permission->description ?? '' }}"
                            data-msg-remote="Please enter unique permission" maxlength="190">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default  " data-dismiss="modal"><i
                            class="ik ik-x"></i>Close</button>
                    <button type="submit" class="btn btn-success  shadow" id="next"><i
                            class="ik ik-check-circle">
                        </i>{{(isset($permission)) ? 'Update':'Save'}}</button>
                </div>

            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function ($) {

        let $rolePermission = $('#parent_id');

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
                        results: data.map(function (item) {
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

        $('#savepermissionsForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                permissions_name: {
                    required: true,
                    remote: {
                        url: $('#savepermissionsForm').data('exists'),
                        type: "post",
                    }
                }
            },
            messages: {
                name: {
                    remote: "Please enter unique permission",
                }
            },
            errorPlacement: function (error, element) {
                // $(element).addClass('is-invalid')
                error.appendTo(element.parent()).addClass('text-danger');
            }
        });

    });

</script>
