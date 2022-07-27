@extends('admin.layouts.app')
@push('style')

@endpush
@section('content')
<div class="row d-flex">
  <div class="d-flex justify-content-between align-items-center col">
    <h4>Edit Category</h4>
    <a href="{{ route('admin.category.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back
    </a>
  </div>
</div>
<div class="row mt-2">


  <div class="col-md-12">
    <form action="{{ route('admin.category.update' , $category->id ) }}" id="categoriesForm" method="post"
      enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="row" x-data="slugdata()" x-init="init({{ json_encode($category) }})">
        <div class="col-sm-12 col-md-7">
          <div class="card ">
            <div class="card-body">
              <div class="row">

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name"
                      data-rule-remote="{{ route('admin.category.exists' ,['id' => $category->id ]) }}" x-model="name"
                      value="{{ $category->name ?? '' }}" data-msg-remote="Category is already exist." id="name"
                      required class="form-control">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Slug <span class="text-danger">*</span></label>
                    <input type="text" readonly x-model="slug(name)" value="{{ $category->slug ?? '' }}" name="slug"
                      required id="slug" class="form-control">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="description" rows="3"
                      class="form-control">{{ $category->description ?? '' }}</textarea>
                  </div>
                </div>

                <div class="col-sm-12 clearfix ">
                  @include('component.imagepriview',
                  [ 'height' => '200px','label' => 'Image' ,'name' =>'images','priview' => $category->image_src ??
                  null ])
                </div>


              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-5">
          <div class="card">
            <div class="card-body">
              <h6><strong>Search engine listing preview</strong></h6>

              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label class="d-block w-100">Meta title <small class="float-right"
                        style="color: red; font-size: 12px;"></small></label>
                    <input id="meta_title" class="form-control" type="text" name="meta_title"
                      value="{{$category->meta_title ?? ''}}">
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label class="d-block w-100">Meta Description </label>
                    <textarea class="form-control html-editor" rows="4"
                      name="meta_description">{{$category->meta_description ?? ''}}</textarea>
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label for="meta_keyword">Meta keywords</label>
                    <textarea class="form-control html-editor" rows="4"
                      name="meta_keywords">{{$category->meta_keywords ?? ''}}</textarea>
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label for="url_handle">URL and handle <span class="text-danger">*</span></label>
                    <input id="url_handle" class="form-control" type="text" name="handle" data-rule-required="true"
                      x-model="slug(name)" data-rule-required="false" value="{{$category->handle ?? ''}}">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="float-right">
        <a href="{{ route('admin.category.index') }}" class="btn btn-default mr-2 "> Cancel</a>
        <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Update</button>
      </div>

    </form>
  </div>



</div>
@endsection



@push('scripts')
<script>
  function slugdata() {
        return {
            name : '',
            slug : function(text) {
                return text.toString().normalize( 'NFD' ).replace( /[\u0300-\u036f]/g, '' ).toLowerCase().trim()
                        .replace(/\s+/g, '-') .replace(/[^\w\-]+/g, '') .replace(/\-\-+/g, '-');
            },
            init(category) {
                this.name = category.name;
                this.slug(this.name) ;
            }
        }
    }
    $(document).ready(function () {

            $('#categoriesForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                errorPlacement: function (error, element) {
                    // $(element).addClass('is-invalid')
                    error.appendTo(element.parent()).addClass('text-danger');
                }
            });

        });
</script>
@endpush
