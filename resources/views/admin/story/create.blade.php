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
          <div class="card-body repeater">

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
                <div class="form-group">
                  <label>Instagram Handle <span class="text-danger">*</span></label>
                  <input type="text" name="instagram_handle" id="instagram_handle" required class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Instagram Handle URL <span class="text-danger">*</span></label>
                  <input type="text" name="instagram_handle_url" id="instagram_handle_url" required class="form-control">
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

            @foreach (range(1, 5) as $key => $post)
              <div class="row mb-5">
                <div class="col-4">
                  <h6 class="text-mute"><strong>POST</strong> </h6>
                  <hr>
                  <div class="form-row">
                    @include('component.imagepriview', [
                        'height' => '200px',
                        'label' => 'Image',
                        'name' => 'post_image_' . $key,
                        'id' => 'post_image_' . rand(0, 1111111),
                        'priview' => $post->image_url ?? null,
                    ])
                  </div>
                </div>
                <div class="col">
                  <h6 class="text-mute"><strong>Details</strong> </h6>
                  </h6>
                  <hr>
                  <div class="form-group">
                    <label for="caption_{{ $key }}">Caption</label>
                    <input id="caption_{{ $key }}" class="form-control" type="text" name="caption[{{ $key }}]">
                  </div>
                  <div class="form-group">
                    <label for="url_{{ $key }}">Url</label>
                    <input id="url_{{ $key }}" class="form-control" type="text" value="" name="url[{{ $key }}]">
                  </div>
                </div>
              </div>
            @endforeach

            {{-- <div class="col-md-12">
              <div class="form-group">
                <label class="form-label fs-6 fw-bolder mb-3">Story Image</label>
                <div class="input-images"></div>
              </div>
            </div> --}}
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js" integrity="sha512-foIijUdV0fR0Zew7vmw98E6mOWd9gkGWQBWaoA1EOFAx+pY+N8FmmtIYAVj64R98KeD2wzZh1aHK0JSpKmRH8w==" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
@endpush


@push('scripts')
  <script>
    ClassicEditor
      .create(document.querySelector('#description'))
      .catch(error => {
        console.error(error);
      });

    $('.repeater').repeater({
      show: function() {
        $(this).slideDown(function() {

        });
      },
      ready: function(setIndexes) {

      }
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
