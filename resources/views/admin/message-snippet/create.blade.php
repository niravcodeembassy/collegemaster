@extends('admin.layouts.app')

@section('content')
  <div class="row mt-4">
    <div class="col-sm-12 col-md-4">
      <div class="cards">
        <div class="card-body p-0">
          <h4 class=""> Create Message </h4>
          <p class="text-muted">Hear you can create a Message</p>
        </div>
      </div>
    </div>

    <div class="col-sm-12 col-md-8 ">
      <form action="{{ route('admin.message-snippet.store') }}" id="snippetForm" method="post">
        @csrf
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Title <span class="text-danger">*</span></label>
                  <input type="text" name="title" id="title" required class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Description <span class="text-danger">*</span></label>
                  <textarea name="description" id="description" required rows="5" class="form-control"></textarea>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="float-right">
          <a href="{{ route('admin.message-snippet.index') }}" class="btn btn-default mr-2"> Cancel</a>
          <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Save</button>
        </div>
      </form>
    </div>
  </div>
@endsection


@push('scripts')
  <script>
    $(document).ready(function() {

      $('#snippetForm').validate({
        debug: false,
        ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
        errorPlacement: function(error, element) {
          // $(element).addClass('is-invalid')
          error.appendTo(element.parent()).addClass('text-danger');
        }
      });
    });
  </script>
@endpush
