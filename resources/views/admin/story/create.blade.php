@extends('admin.layouts.app')

@section('title', $title)

@section('content')
  @component('component.heading',
      [
          'page_title' => 'Create Story',
          'icon' => 'fa fa-plus',
          'tagline' => 'Lorem ipsum dolor sit amet.',
          'action' => route('admin.story.index'),
          'action_icon' => 'fa fa-arrow-left',
          'text' => 'Back',
      ])
  @endcomponent

  <form action="{{ route('admin.story.store') }}" enctype="multipart/form-data" method="POST" name="product_form" id="story_form" autocomplete="off">
    @csrf
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Title <span class="text-danger">*</span></label>
                  <input type="text" name="title" id="title" required class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Video URL <span class="text-danger">*</span></label>
                  <input type="text" name="video_url" id="video_url" required class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group min">
                  <div class="form-group">
                    <label>Description</label>
                    <textarea id="description" class="ckeditor form-control col-12" name="description" data-rule-required="false" data-msg-ckdata="Description is required." rows="5">
                    </textarea>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label fs-6 fw-bolder mb-3">Story Image</label>
                <div class="input-images"></div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="float-right">
      <a href="{{ route('admin.story.index') }}" class="btn btn-default mr-2 "> Cancel</a>
      <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Save</button>
    </div>
  </form>


@endsection
@push('css')
  <link rel="stylesheet" href="{{ asset('css/image-uploader.min.css') }}">
@endpush

@push('js')
  <script src="{{ asset('js/image-uploader.min.js') }}"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/19.1.1/classic/ckeditor.js"></script>
@endpush


@push('scripts')
  <script>
    ClassicEditor
      .create(document.querySelector('#description'))
      .catch(error => {
        console.error(error);
      });

    $(document).ready(function() {
      $('.input-images').imageUploader({
        extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg'],
        mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
        imagesInputName: 'images',
        maxSize: 2 * 1024 * 1024,
      });

      $('#story_form').validate({
        debug: false,
        ignore: 'input[type="file"],.select2-search__field,:hidden:not("textarea,file,.files,select,#images,.ck-editor__editable"),[contenteditable="true"]:not([name])',
        errorPlacement: function(error, element) {
          // $(element).addClass('is-invalid')
          error.appendTo(element.parent()).addClass('text-danger');
        }
      });
    });
  </script>
@endpush
