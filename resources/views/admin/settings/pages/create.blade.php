@extends('admin.layouts.app')

@section('title', $title)

@section('content')
  @component('component.heading',
      [
          'page_title' => 'Add Pages',
          'icon' => 'fa fa-file',
          'tagline' => 'Lorem ipsum dolor sit amet.',

          'action' => route('admin.pages.index'),
          'action_icon' => 'fa fa-arrow-left',
          'text' => 'Back',
      ])
  @endcomponent

  <form action="{{ route('admin.pages.store') }}" data-url="{{ route('admin.pages.slug') }}" method="POST" name="pageform" id="pageform" enctype="multipart/form-data">
    @csrf()

    <div class="row">

      @include('component.error')

      <div class="col-md-12">

        <div class="card">
          <div class="card-body">
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <h6><strong>Title <span class="text-danger">*</span></strong></h6>
                  <input id="title" class="form-control" type="text" name="title" data-rule-required="true" data-msg-required="Title is required">
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <h6><strong>short Content <span class="text-danger">*</span></strong></h6>
                  <textarea id="short_content" class="form-control col-12" name="short_content" rows="3">
                  </textarea>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <h6><strong>Content <span class="text-danger">*</span></strong></h6>
                  <textarea id="content" class="ckeditor form-control col-12" data-rule-ckdata="ck" name="content" data-rule-required="true" data-msg-ckdata="Title is required" rows="3">
                                    </textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h6><strong>Search engine listing preview</strong></h6>

            <p style="color: #999;">Add a title and decription to see how this products might appear in a search engine listing.</p>

            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label class="d-block w-100">Page title <small class="float-right" style="color: red; font-size: 12px;">0 of 70 characters used</small></label>
                  <input id="page_title" class="form-control" type="text" name="page_title">
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label class="d-block w-100">Meta Description <small class="float-right" style="color: red; font-size: 12px;">0 of 320 characters used</small></label>
                  <textarea class="form-control html-editor" rows="4" name="meta_description"></textarea>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label for="meta_keyword">Meta keywords</label>
                  <textarea class="form-control html-editor" rows="4" name="meta_keyword"></textarea>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label for="url_handle">URL and handle <span class="text-danger">*</span></label>
                  <input id="url_handle" class="form-control" type="text" name="url_handle" data-rule-required="true" data-msg-required="URL is required" data-rule-remote="{{ route('admin.pages.slug') }}" data-msg-remote="Handle is already exist."
                    data-rule-required="false">
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="col-md-6 clearfix ">
        @include('component.imagepriview', ['height' => '200px', 'label' => 'Image', 'name' => 'slider_image', 'priview' => $page->page_image ?? null])
      </div>
      {{-- <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col">
                                <h6 class="text-mute"><strong>Slider Image <span class="text-danger">*</span></strong> </h6> <hr>
                                <div class="text-center">
                                <img src="{{ asset('storage/default/default.png') }}" data-default="{{ asset('storage/default/picture.png') }}" class="w-100" id="preview">
                                </div><br>
                                <div class="form-group">
                                    <input type="file" name="slider_image" class="file-upload-default"
                                    data-rule-accept="jpg,png,jpeg" data-msg-accept="Only image type jpg/png/jpeg is allowed."
                                    data-rule-required="true" data-rule-filesize="5000000" id="featured_image"
                                    data-msg-required="Image is required." data-msg-filesize="File size must be less than 5mb"
                                    >
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse shadow-sm btn btn-primary" type="button">Upload</button>
                                        </span>
                                        <span class="input-group-append">
                                            <button class="file-upload-clear btn shadow-sm btn-danger" type="button">Clear</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          </div> --}}
    </div>

    <div class="row">
      <div class="col d-flex justify-content-end">
        <button type="submit" class="btn btn-success shadow" name="btn_save" id="btn_save"><i class="ik ik-check-circle">
          </i>Save</button>
      </div>
    </div>
  </form>
@endsection

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/26.0.0/classic/ckeditor.js"></script>

  <script type="text/javascript">
    ClassicEditor
      .create(document.querySelector('#content'),{
        heading: {
      options: [
        {
          model: "paragraph",
          title: "Paragraph",
          class: "ck-heading_paragraph",
        },
        {
          model: "heading1",
          view: "h1",
          title: "Heading 1",
          class: "ck-heading_heading1",
        },
        {
          model: "heading2",
          view: "h2",
          title: "Heading 2",
          class: "ck-heading_heading2",
        },
        {
          model: "heading3",
          view: "h3",
          title: "Heading 3",
          class: "ck-heading_heading2",
        },
      ],
    },
      })
      .catch(error => {
        console.error(error);
      });
    $(document).ready(function() {
      $('.file-upload-browse').on('click', function() {
        var file = $(this).parents().find('.file-upload-default');
        file.trigger('click');
      });

      $('.file-upload-clear').on('click', function() {
        $('.file-upload-default').val('');
        $('.file-upload-default').trigger('change');
      });

      $('.file-upload-default').on('change', function() {
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

      var readURL = function(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            $('#preview').attr('src', e.target.result)
          }
          reader.readAsDataURL(input.files[0]);
        }
      }

      $('#pageform').validate({
        debug: false,
        ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
        rules: {
          url_handle: {
            required: true,
            remote: {
              url: $('#pageform').attr('data-url'),
              type: "get",
              data: {
                _token: function() {
                  return window.Laravel.csrfToken;
                },
                url_handle: function() {
                  return $("#url_handle").val();
                },
                id: function() {
                  return $("#id").val();
                },
              }
            }
          },
        },
        messages: {
          url_handle: {
            remote: "Handle is already exist.",
          }
        },
        errorPlacement: function(error, element) {
          // $(element).addClass('is-invalid')
          error.appendTo(element.parent()).addClass('text-danger');
        },
        submitHandler: function(e) {
          return true;
        }
      });


      $('#title').on('keydown keyup', function(e) {
        // alert('keypress');
        var el = $(this);
        var textdata = el.val();
        var slug = convertToSlug(textdata);
        $('#url_handle').val(slug);

      });

      var convertToSlug = function convertToSlug(Text) {
        var data = Text
          .toLowerCase()
          .replace(/[^\w ]+/g, '')
          .replace(/ +/g, '-');
        return data
      }

    });
  </script>
@endpush
