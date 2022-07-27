@extends('admin.layouts.app')
@push('style')

@endpush
@section('content')
<div class="row mt-4">
    <div class="col-sm-12 col-md-5">
        <div class="cards">
            <div class="card-body p-0">
                <h4 class=""> Create Sub Category </h4>
                <p class="text-muted">Hear you can create a category and upload image </p>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-7 ">
        <form action="{{ route('admin.sub-category.store') }}" id="categoriesForm" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="card ">
                <div class="card-body">
                    <div class="row" x-data="slugdata()">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="category">category <span class="text-danger">*</span></label>
                                <div class="input-group input-group-button">
                                    <select class="form-control category-select2" name="category" id="category"
                                        data-url="{{ route('admin.get.category') }}" data-rule-required="true"
                                        data-placeholder="Select Category."
                                        data-msg-required="Category is required.">
                                        <option value="" selected>Select Category</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Sub Category Name <span class="text-danger">*</span></label>
                                <input type="text" data-url="{{ route('admin.sub-category.exists') }}"
                                    name="name" x-model="name" id="name" required class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Slug <span class="text-danger">*</span></label>
                                <input type="text" readonly x-model="slug(name)" name="slug" required id="slug"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="description" rows="2" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-sm-12 clearfix d-none">
                            @include('component.imagepriview',
                            [ 'height' => '200px','label' => 'Image' ,'name' =>'images','priview' =>
                            $category->image_src ?? null ])
                        </div>


                    </div>
                </div>
            </div>
            <div class="float-right">
                <a href="{{ route('admin.sub-category.index') }}" class="btn btn-default mr-2 "> Cancel</a>
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
            name: '',
            slug: function (text) {
                return text.toString().normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim()
                    .replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-');
            }
        }
    }
</script>
@endpush
