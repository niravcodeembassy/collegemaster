@extends('admin.layouts.app')
@push('style')
@endpush
@section('content')
  <div class="row d-flex">
    <div class="d-flex justify-content-between align-items-center col">
      <h4>Create Blog</h4>
      <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back
      </a>
    </div>
  </div>
  <div class="row mt-2">


    <div class="col-md-12">
      <form action="{{ route('admin.blog.store') }}" id="blogForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row" x-data="slugdata()">
          <div class="col-sm-12 col-md-7">
            <div class="card ">
              <div class="card-body">
                <div class="row">

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Blog Title <span class="text-danger">*</span></label>
                      <input type="text" data-rule-remote="{{ route('admin.blog.exists') }}" name="title" x-model="title" id="title" data-msg-remote="Blog is already exist." required class="form-control">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Slug <span class="text-danger">*</span></label>
                      <input type="text" readonly x-model="slug(title)" name="slug" required id="slug" class="form-control">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="role">Tag <i class="text-danger"></i></label>
                      <select name="tag[]" data-rule-required="true" multiple data-url="{{ route('admin.get.tag') }}" data-placeholder="Select Tag" id="tag" class="form-control">
                        <option value="">Select Tag</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-row">
                      <div class="col">
                        <div class="form-group">
                          <label class="d-block w-100">Short Content </label>
                          <textarea class="form-control html-editor" rows="3" name="content"></textarea>
                        </div>
                      </div>
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

                  <div class="col-sm-12 clearfix ">
                    @include('component.imagepriview', ['height' => '200px', 'label' => 'Image', 'name' => 'images', 'priview' => $blog->image_src ?? null])
                  </div>

                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-5">
            <div class="card">
              <div class="card-body">
                <h6><strong>Search engine listing preview</strong></h6>

                <p style="color: #999;">Add a title and decription to see how this blog might appear in a search engine
                  listing.</p>

                <div class="form-row">
                  <div class="col">
                    <div class="form-group">
                      <label class="d-block w-100">Meta title <small class="float-right" style="color: red; font-size: 12px;"></small></label>
                      <input id="meta_title" class="form-control" type="text" name="meta_title">
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="col">
                    <div class="form-group">
                      <label class="d-block w-100">Meta Description </label>
                      <textarea class="form-control html-editor" rows="4" name="meta_description"></textarea>
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="col">
                    <div class="form-group">
                      <label for="meta_keyword">Meta keywords</label>
                      <textarea class="form-control html-editor" rows="4" name="meta_keywords"></textarea>
                    </div>
                  </div>
                </div>

                {{-- <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label for="url_handle">URL and handle <span class="text-danger">*</span></label>
                    <input id="url_handle" class="form-control" x-model="slug(title)" type="text" name="handle"
                      data-rule-required="true" data-msg-remote="Handle is already exist." data-rule-required="false">
                  </div>
                </div>
              </div> --}}
              </div>
            </div>
          </div>
        </div>

        <div class="float-right">
          <a href="{{ route('admin.blog.index') }}" class="btn btn-default mr-2 "> Cancel</a>
          <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Save</button>
        </div>

      </form>
    </div>



  </div>
@endsection

@push('css')
  <link rel="stylesheet" href="{{ asset('js/plugins/summernote/summernote-bs4.css') }}">
@endpush

@push('js')
  <script src="https://cdn.ckeditor.com/ckeditor5/19.1.1/classic/ckeditor.js"></script>
  <script src="{{ asset('js/plugins/summernote/summernote-bs4.min.js') }}"></script>
@endpush


@push('scripts')
  <script>
    ClassicEditor
      .create(document.querySelector('#description'))
      .catch(error => {
        console.error(error);
      });

    // $('#description').summernote({
    //   height:200
    // });

    function slugdata() {
      return {
        title: '',
        slug: function(text) {
          return text.toString().normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim()
            .replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-');
        }
      }
    }
    $(document).ready(function() {
      let $tag = $('#tag');

      $('#blogForm').validate({
        debug: false,
        ignore: 'input[type="file"],.select2-search__field,:hidden:not("textarea,file,.files,select,#images,.ck-editor__editable"),[contenteditable="true"]:not([name])',
        errorPlacement: function(error, element) {
          // $(element).addClass('is-invalid')
          error.appendTo(element.parent()).addClass('text-danger');
        }
      });

      $tag.select2({
        theme: 'bootstrap4',
        ajax: {
          url: function() {
            return $(this).data('url')
          },
          data: function(params) {
            return {
              search: params.term,
            };
          },
          dataType: 'json',
          processResults: function(data) {
            return {
              results: data.map(function(item) {
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
    });
  </script>
@endpush
