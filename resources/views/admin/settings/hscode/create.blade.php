<div class="modal fade" id="addcategory" tabindex="-1" role="dialog" aria-labelledby="addbrand" aria-hidden="true">

  <div class="modal-dialog  modal-md" role="document">
    <form action="{{ route('admin.hscode.store') }}" method="POST" id="hscodeform" name="hscodeform" enctype="multipart/form-data">
      @csrf()

      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Add HSN code</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" data-msg-required="hscode is required.">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input id="name" class="form-control" data-rule-remote="{{ route('admin.hscode.exists') }}" data-msg-remote="HSN code is already exists" type="text" name="name" data-rule-required="true">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="percentage">Percentage <span class="text-danger">*</span></label>
                    <input id="percentage" class="form-control" value="{{ $hscode->percentage ?? '' }}" data-rule-number="true" type="text" name="percentage" min="0" max="100" data-rule-required="true">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="ik ik-x"></i>Close
          </button>
          <button type="submit" class="btn btn-success shadow"><i class="ik ik-check-circle">
            </i>Success
          </button>
        </div>

      </div>
    </form>
  </div>
</div>
<script>
  $(document).ready(function() {

    $('#hscodeform').validate({
      debug: false,
      ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
      rules: {},
      messages: {},
      errorPlacement: function(error, element) {
        error.appendTo(element.parent()).addClass('text-danger');
      },
      submitHandler: function(e) {
        return true;
      }
    })

  });
</script>
