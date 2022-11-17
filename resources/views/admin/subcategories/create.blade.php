@extends('admin.layouts.app')
@push('style')
@endpush
@section('content')
    <div class="row d-flex">
        <div class="d-flex justify-content-between align-items-center col">
            <h4>Create Sub Category</h4>
            <a href="{{ route('admin.sub-category.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    <div class="row mt-2">


        <div class="col-md-12">
            <form action="{{ route('admin.sub-category.store') }}" id="categoriesForm" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row" x-data="slugdata()">
                    <div class="col-sm-12 col-md-7">
                        <div class="card ">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
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
                                            <input type="text" readonly x-model="slug(name)" name="slug" required
                                                id="slug" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea id="description" class="ckeditor form-control col-12" name="description" data-rule-required="false"
                                                data-msg-ckdata="Description is required." rows="3">
                                              </textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 clearfix">
                                        @include('component.imagepriview', [
                                            'height' => '200px',
                                            'label' => 'Image',
                                            'name' => 'images',
                                            'priview' => $category->image_src ?? null,
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <h6><strong>Search engine listing preview</strong></h6>

                                <p style="color: #999;">Add a title and decription to see how this sub category might appear
                                    in a search
                                    engine
                                    listing.</p>

                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="d-block w-100">Meta title <small class="float-right"
                                                    style="color: red; font-size: 12px;"></small></label>
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
                    <input id="url_handle" class="form-control" x-model="slug(name)" type="text" name="handle"
                      data-rule-required="true" data-msg-remote="Handle is already exist." data-rule-required="false">
                  </div>
                </div>
              </div> --}}
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
    <script src="https://cdn.ckeditor.com/ckeditor5/19.1.1/classic/ckeditor.js"></script>
    <script src="{{ asset('js/subcategory.js') }}"></script>
@endpush
@push('scripts')
    <script>
        function slugdata() {
            return {
                name: '',
                slug: function(text) {
                    return text.toString().normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim()
                        .replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-');
                }
            }
        }
    </script>
@endpush
