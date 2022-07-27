@extends('admin.layouts.app')

@section('title' , $title)

@section('content')
@component('component.heading' , [
'page_title' => 'Add Product',
'icon' => 'fa fa-shopping-cart' ,
'action' => route('admin.product.index') ,
'action_icon' => 'fa fa-arrow-left' ,
'text' => 'Back'
])
@endcomponent

<form action="{{ route('admin.product.store') }}" enctype="multipart/form-data" method="POST" name="product_form"
  id="product_form" autocomplete="off">
  @csrf
  <div class="row">
    @include('component.error')
    <div class="col-sm-8 ">
      <div class="card">
        <div class="card-body">
          <h6 class="text-mute"><strong>Product Details</strong> </h6>
          <hr>
          <div class="form-group">
            <label for="title">Product Title <span class="text-danger">*</span> </label>
            <input id="title" class="form-control" type="text" name="title"
              data-msg-required="Product title is required." data-rule-required="true">
          </div>

          <div class="form-group min">
            <div class="form-group">
              <label for="short_content">Short Description </label>
              <textarea id="short_content" class="ckeditor form-control col-12" name="short_content"
                data-rule-required="false" data-msg-ckdata="Description is required." rows="3">
                            </textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="form-group">
              <label for="content">Full Description <span class="text-danger">*</span> </label>
              <textarea id="content" class="ckeditor form-control col-12" name="content" data-rule-required="true"
                data-msg-ckdata="Content is required." rows="3">
                            </textarea>
            </div>
          </div>
          <div class="form-group min">
            <div class="form-group">
              <label for="content">Additional Description </label>
              <textarea id="additional_description" data-rule-required="false"
                data-msg-ckdata="Additional Description is required." class="ckeditor form-control col-12"
                name="additional_description" rows="2">
              </textarea>
            </div>
          </div>
        </div>
      </div>

      {{-- Pricing --}}
      <div class="card">
        <div class="card-body tax-row">

          <h6 class="text-mute"><strong>Pricing</strong></h6>
          <hr>

          <div class="form-row">

            <div class="col">
              <div class="form-group">
                <label for="mrp_amount">MRP <span class="text-danger">*</span> </label>
                <input id="mrp_amount" class="form-control" type="text" name="mrp_amount" data-rule-required="true"
                  data-msg-required="MRP  is required." data-rule-number="true">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="offer_price">Offer Price </label>
                <input id="offer_price" class="form-control" type="text" name="offer_price" data-rule-required="false">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="sku">SKU </label>
                <input id="sku" class="form-control" value="{{ $product->sku ?? '' }}" type="text" name="sku"
                  data-rule-required="false">
              </div>
            </div>
            <div class="col">
              <div class="form-group ">
                <label for="taxable_percentage">HSN Code</label>
                <select class="form-control hsncode-select2" name="taxable_percentage" id="taxable_percentage"
                  data-url="{{ route('admin.get.taxable_percentage') }}" data-rule-required="false"
                  data-placeholder="Select HSN Code">
                  <option value="" selected>Select HSN code</option>
                </select>
              </div>
            </div>
            <div class="d-none">
              <div class="form-group">
                <label for="taxable_price">Taxable Price </label>
                <input id="taxable_price" value="0.00" readonly class="form-control" type="text" name="taxable_price"
                  data-rule-required="false">
              </div>
            </div>

          </div>
          <hr style="margin:10px -20px" class="d-none">
          <div class="form-row d-none">
            <div class="col-6">
              <div class="form-group">
                <label for="offer_price">Tax Type </label>
                <div class="form-radio mt-2">

                  <div class="radio radiofill radio-primary radio-inline">
                    <label class="mb-0 mx-2">
                      <input type="radio" name="tax_type" value="1" class="tax_type" checked="checked">
                      <i class="helper"></i>Inclusive
                    </label>
                    <label class="mb-0 mx-2">
                      <input type="radio" name="tax_type" value="0" class="tax_type">
                      <i class="helper"></i>Exclusive
                    </label>
                  </div>



                </div>
              </div>
            </div>
            <div class="col-3 ">
              {{-- <div class="form-group">
                <label for="taxable_percentage">Tax percentage </label>
                <div class="input-group">
                  <span class="input-group-prepend">
                    <label class="input-group-text"><i class="fa fa-percent"></i></label>
                  </span>
                  <input id="taxable_percentage" value="0.00" class="form-control" min="0.00" max="100" type="text"
                    name="taxable_percentage" data-rule-required="false">
                </div>
              </div> --}}
            </div>
          </div>


        </div>
      </div>

      {{-- Seo --}}

      <div class="card">
        <div class="card-body">
          <h6 class="text-mute"><strong>Search engine listing preview</strong> </h6>
          <small>Add a tittle and description to see how this products might appear in a search engine
            listing.</small>
          <hr>
          <div class="form-row">

            <div class="col-12">
              <div class="form-group">
                <label for="meta_title">Page Title </label>
                <input id="meta_title" class="form-control" type="text" name="meta_title" data-rule-required="false">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label for="meta_keywords">Meta Keywords </label>
                <input id="meta_keywords" class="form-control" type="text" name="meta_keywords"
                  data-rule-required="false">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label for="meta_description">Meta Description </label>
                <textarea name="meta_description" class="form-control" id="meta_description" cols="30"
                  rows="10"></textarea>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label for="meta_slug">URL and handle <span class="text-danger">*<span> </label>
                <input id="meta_slug" class="form-control" type="text" name="meta_slug" data-rule-required="true"
                  data-msg-required="URL is required" data-rule-remote="{{ route('admin.product.slug') }}"
                  data-msg-remote="Handle is already exist." data-rule-required="false">
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
    <div class="col-sm-4">

      {{-- image --}}
      {{-- <div class="card">
        <div class="card-body">
          <h6 class="text-mute"><strong>Product Image</strong> </h6>
          <hr>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>File upload</label>
                <input type="file" name="img[]" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> --}}


      <div class="card">
        <div class="card-body">
          <h6 class="text-mute"><strong>Organization</strong> </h6>
          <hr>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="category">Product category <span class="text-danger">*</span></label>
                <div class="input-group input-group-button">
                  <select class="form-control category-select2" name="category" id="category"
                    data-url="{{ route('admin.get.category') }}" data-rule-required="true"
                    data-placeholder="Select Product Category." data-msg-required="Product category is required.">
                    <option value="" selected>Select Category</option>
                  </select>
                  {{-- <div class="input-group-append">
                    <button class="btn btn-primary call-model" data-url="{{ route('admin.category.create') }}"
                      data-target-modal="#addcategory" type="button"><i class="fa fa-plus-circle"></i></button>
                  </div> --}}
                </div>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="sub-category">Product Sub category <span class="text-danger">*</span></label>
                <div class="input-group input-group-button">
                  <select class="form-control sub-category-select2" name="sub_category" id="sub-category"
                    data-url="{{ route('admin.get.sub-category') }}" data-target="#category" data-rule-required="true"
                    data-placeholder="Select Product Sub Category."
                    data-msg-required="Product Sub category is required.">
                    <option value="" selected>Select Sub Category</option>
                  </select>
                  {{-- <div class="input-group-append">
                    <button class="btn btn-primary call-model" data-url="{{ route('admin.category.create') }}"
                      data-target-modal="#addcategory" type="button"><i class="fa fa-plus-circle"></i></button>
                  </div> --}}
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <h6 class="text-mute"><strong>Related Products</strong> </h6>
          <hr>

          <div class="row">
            <div class="col-12">
              <div class="form-group mb-3">
                <div class="input-group input-group-button">
                  <select class="form-control buy-together-select2" name="buy_to_together[]" multiple
                    id="buy_to_together" data-url="{{ route('admin.get.product') }}"
                    data-placeholder="Select Related Products." data-rule-required="false"
                    data-msg-required="Product category is required.">
                    <option value="">Select Related Products</option>
                  </select>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
      {{-- Inventory --}}

      <div class="card">
        <div class="card-body">

          <h6 class="text-mute"><strong>Inventory</strong></h6>
          <hr>

          <div class="form-row">

            {{-- <div class="col">
              <div class="form-group">
                <label for="sku">SKU (Stock Keeping Unit ) </label>
                <input id="sku" class="form-control" type="text" name="sku" data-rule-required="false">
              </div>
            </div> --}}

            <div class="col">
              <div class="form-group">
                <label for="quantity">Quantity </label>
                <input id="quantity" class="form-control" type="text" name="quantity" data-rule-required="false"
                  value="1">
              </div>
            </div>

          </div>
          <div class="form-row">

            <div class="col">
              <div class="form-group">
                <label for="attachment">Number of Attachment </label>
                <input id="attachment" class="form-control" value="1" type="text" name="attachment"
                  data-rule-required="false" value=0">
              </div>
            </div>

          </div>

        </div>
      </div>

    </div>
  </div>
  <div class="row">
    <div class="col d-flex justify-content-end">
      <button name="save" class="btn btn-default mr-3" value="exit">Save & Exit </button>
      <button name="save" class="btn btn-success shadow" value="next">Save & Next </button>
    </div>
  </div>
</form>


<div id="load-modal"></div>

@endsection

{{-- @push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/dist/summernote-bs4.css') }}">
@endpush --}}

@push('js')
<script src="https://cdn.ckeditor.com/ckeditor5/19.1.1/classic/ckeditor.js"></script>
<script src="{{ asset('js/product.js') }}"></script>
<script src="{{ asset('js/category.js') }}"></script>
@endpush
