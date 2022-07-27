<div class="modal fade" id="addtag" role="dialog" aria-labelledby="addtag" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="saveTagForm" id="saveTagForm" method="post"
      data-exists="{{ route('admin.tag.exists' ,['id' => $tag->id??null ]) }}"
      action=" @if(isset($tag)) {{ route('admin.tag.update',$tag->id)  }} @else {{route('admin.tag.store')}} @endif">
      @csrf

      @if(isset($tag))
      @method('PATCH')
      @endif

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{(isset($tag)) ? 'Edit Tag':'Add Tag'}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-errors"></div>
          <div class="form-group m-form__group">
            <label for="tag_name" class="form-control-label">Tag Name: <i class="text-danger">*</i></label>
            <input type="text" class="form-control" id="tag_name" name="tag_name" value="{{ $tag->tag_name ?? '' }}"
              data-msg-remote="Please enter unique tag" maxlength="190">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default " data-dismiss="modal"><i class="ik ik-x"></i>Close</button>
          <button type="submit" class="btn btn-success  shadow" id="next"><i class="ik ik-check-circle">
            </i>{{(isset($tag)) ? 'Update':'Save'}}</button>
        </div>

      </div>
    </form>
  </div>
</div>


<script type="text/javascript">
  jQuery(document).ready(function ($) {
        $('#saveTagForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                tag_name: {
                    required: true,
                    remote: {
                        url: $('#saveTagForm').data('exists'),
                        type: "post",
                    }
                }
            },
            messages: {
                name: {
                    remote: "Please enter unique tag",
                }
            },
            errorPlacement: function (error, element) {
                // $(element).addClass('is-invalid')
                error.appendTo(element.parent()).addClass('text-danger');
            }
        });
    });
</script>
