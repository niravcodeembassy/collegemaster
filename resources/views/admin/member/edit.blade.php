@extends('admin.layouts.app')

@section('content')
  <div class="row mt-4">
    <div class="col-sm-12 col-md-4">
      <div class="cards">
        <div class="card-body p-0">
          <h4 class=""> Edit Member </h4>
          <p class="text-muted">Hear you can edit a team member</p>
        </div>
      </div>
    </div>

    <div class="col-sm-12 col-md-8 ">
      <form action="{{ route('admin.team.update', $team->id) }}" id="teamForm" method="post" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Title <span class="text-danger">*</span></label>
                  <input type="text" name="title" value="{{ $team->title ?? '' }}" id="title" required class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Designation</label>
                  <input type="text" name="designation" value="{{ $team->designation ?? '' }}" id="designation" class="form-control">
                </div>
              </div>

              <div class="col-md-12 ">
                @include('component.imagepriview', ['height' => '200px', 'label' => 'Image', 'name' => 'images', 'priview' => $team->image_src ?? null])
              </div>

            </div>
          </div>
        </div>
        <div class="float-right">
          <a href="{{ route('admin.team.index') }}" class="btn btn-default mr-2 "> Cancel</a>
          <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Update</button>
        </div>
      </form>
    </div>
  </div>
@endsection


@push('scripts')
  <script>
    $(document).ready(function() {

      $('#teamForm').validate({
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
