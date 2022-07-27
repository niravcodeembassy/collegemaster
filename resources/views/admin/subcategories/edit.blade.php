@extends('admin.layouts.app')
@push('style')

@endpush
@section('content')
<div class="row mt-4">
  <div class="col-sm-12 col-md-5">
    <div class="cards">
      <div class="card-body p-0">
        <h4 class="">Edit Sub Category </h4>
        <p class="text-muted">Hear you can edit a category and upload image </p>
      </div>
    </div>
  </div>

  <div class="col-sm-12 col-md-7 ">
    <form action="{{ route('admin.sub-category.update' , $category->id ) }}" id="categoriesForm" method="post"
      enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="card ">
        <div class="card-body">
          <div class="row" x-data="slugdata()" x-init="init({{ json_encode($category) }})">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="category">category <span class="text-danger">*</span></label>
                <div class="input-group input-group-button">
                  <select class="form-control category-select2" name="category" id="category"
                    data-url="{{ route('admin.get.category') }}" data-rule-required="true"
                    data-placeholder="Select Category." data-msg-required="Category is required.">
                    <option value="" selected>Select Category</option>
                    @if ($category->category)
                    <option value="{{$category->category->id}}" selected>{{$category->category->name}}</option>
                    @endif
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Sub Category Name <span class="text-danger">*</span></label>
                <input type="text" name="name" data-url="{{ route('admin.sub-category.exists') }}"
                  data-id="{{ $category->id }}" x-model="name" value="{{ $category->name ?? '' }}" id="name" required
                  class="form-control">
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
                <textarea name="description" id="description" rows="2"
                  class="form-control">{{ $category->description ?? '' }}</textarea>
              </div>
            </div>

            <div class="col-sm-12 clearfix  d-none">
              @include('component.imagepriview',
              [ 'height' => '200px','label' => 'Image' ,'name' =>'images','priview' => $category->image_src ??
              null ])
            </div>


          </div>
        </div>
      </div>

      <div class="float-right">
        <a href="{{ route('admin.sub-category.index') }}" class="btn btn-default mr-2 ">
          Cancel</a>
        <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Save</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('js')
<script src="{{ asset('js/subcategory.js') }}"></script>
@endpush
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

</script>
@endpush
