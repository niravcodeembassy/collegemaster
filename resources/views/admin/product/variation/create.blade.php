@extends('admin.layouts.app')

@section('title', $title)

@push('css')
  <style>
    .card-img-top {
      width: 100%;
      height: 15vw;
      object-fit: cover;
    }

    .ikpos {
      position: absolute;
      top: 5px;
      left: 20px;
      color: #28a745;
      font-size: medium;
    }

    .b-success {
      border: 4px solid #2dce89 !important;
    }
  </style>
@endpush


@section('content')
  @component('component.heading',
      [
          'page_title' => 'Add Variant',
          'icon' => 'fa fa-shopping-cart',
          'tagline' => 'Lorem ipsum dolor sit amet.',
          // 'action' => route('admin.product.create') ,
          // 'action_icon' => 'fa fa-plus' ,
          'text' => 'Create',
      ])
  @endcomponent

  <form action="{{ route('admin.variation.store', ['product_id' => $product->id]) }}" id="variation_form" name="variation_form" class="repeater" method="post">

    @csrf

    <div class="row">
      @include('component.error')
      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">

            <div data-repeater-list="product_variants">

              <div class="repeter-list" data-repeater-item>
                <div class="form-row mt-15">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="option_name">Option name</label>
                      <select name="option_name" id="option_name" class="form-control optionnameselect2 text-lowercase" data-rule-required="true" data-placeholder="Select Option name" data-url="{{ route('admin.get.option') }}">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group" data-rule-required="true">
                      <label for="input">variation</label>
                      {{-- <input type="text" id="tags" class="form-control" value="London,Canada,Australia,Mexico,India"> --}}
                      {{-- <input  type="text" value=""
                                            id="variants_name"
                                            data-rule-required="true"
                                            data-msg-required="Variation is required."
                                            class="form-control col-12 variants_tags"
                                            > --}}

                      {{-- data-role="tagsinput" --}}

                      <select id="variants_name" data-rule-required="true" {{-- data-role="tagsinput" --}} multiple data-target=".optionnameselect2" data-url="{{ route('admin.get.optionvalue') }}" name="variants_name" data-msg-required="Variation is required."
                        style="width: 100%;" class="form-control text-lowercase variants_tags">
                      </select>

                    </div>
                  </div>
                  <div class="col-12">
                    <div class="mb-3">
                      <button type="button" data-repeater-delete class="btn social-btn btn-delelt-item btn-danger btn-sm shdow" value="Delete"><i class="fa fa-trash  text-white"></i>
                      </button>
                      {{-- <a data-repeater-delete class="btn btn-delelt-item btn-danger shdow" value="Delete"/><i class="fa fa-trash fa-2x text-white"></i></a> --}}
                    </div>
                  </div>
                </div>
                <hr>
              </div>

              {{-- <div class="repeter-list row"  style="margin-top:20px;"  data-repeater-item>
                                <div class="col-sm-12">
                                    <div class="col-md-5"  >
                                        <div class="contct-info">
                                            <div class="form-group">
                                                <label for="option_name">Option name</label>
                                                <input type="text" name="option_name" class="form-control" id="option_name"  placeholder="" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5" >
                                        <div class="contct-shop">
                                            <div>
                                                <label >Option values</label>
                                            </div>
                                            <div class="content_error">
                                                <select id="variants_name"
                                                    data-rule-required="false" name="variants_name" multiple="multiple"
                                                    data-msg-required="Product type is required."
                                                    style="width: 100%;"  class="variants_tags">
                                                </select>
                                                <span class="content-error pull-right"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-md-2" style="padding-top: 34px;">
                                        <a data-repeater-delete class="btn btn-delelt-item btn-info" value="Delete"/>Delete</a>
                                    </div>
                                </div>
                            </div> --}}

            </div>
            <div class="col row mt-15">
              <button type="button" data-repeater-create class="btn add-item-btn btn-success btn-sm shdow" value="Delete"><i class="fa  fa-plus-circle"></i> Add Option</button>
              {{-- <a data-repeater-create type="button" class="btn add-item-btn btn-info" value="Add"/>Add</a> --}}
            </div>
          </div>
        </div>
        <!-- Language - Comma Decimal Place table end -->
      </div>
      <div class="col-sm-8">
        <div class="card table-card hidden">
          <div class="card-block table-responsive">
            <table class="table table-hover mb-0 ">
              <thead>
                <tr>
                  <th class="w-5"></th>
                  <th class="w-25">Variants</th>
                  <th class="w-20">MRP </th>
                  <th class="w-20">Offer Price</th>
                  <th style="width:10%">Image</th>
                  <th>Inventory</th>
                </tr>
              </thead>
              <tbody class="variants_body">
              </tbody>
            </table>
          </div>
        </div>
        <!-- Language - Comma Decimal Place table end -->
      </div>
    </div>

    <div class="row">

      <div class="col d-flex justify-content-end">
        <a href="{{ route('admin.product.index') }}" name="submit" value="save_exit" class="btn btn-default btn-sm "><i class="fa fa-x"></i> Exit
        </a>&nbsp;&nbsp;&nbsp;

        <button type="submit" name="submit" value="save_add_variant" class="btn btn-success btn-sm shadow">
          <i class="fa fa-check-circless"></i> Save
        </button>
      </div>
    </div>

  </form>

  <div id="varinats_table" class="d-none hidden">
    <table>
      <tbody>
        <tr>
          <td class="align-middle ">
            <i class="fa fa-trash remove-row"></i>
          </td>
          <td class="align-middle">
            <span class="variants_name"></span>
            <input type="hidden" name="variants_name[]" value="">
          </td>
          <td class="align-middle">
            <div class="form-group mb-0">
              <input type="text" class="form-control required" data-rule-required="true" {{-- data-msg-required="MRP  is required." --}} data-msg-required=" " data-rule-number="true" data-rule-number="true" data-id="mrp_price" name="variant_price[]"
                value="{{ $product->productdefaultvariant->mrp_price ?? '0.00' }}" placeholder="">
            </div>
          </td>
          <td class="align-middle">
            <div class="form-group mb-0">

              <input type="text" class="form-control mb-0 required" data-id="Offer_price" data-rule-required="true" {{-- data-msg-required="Offer Price is required." --}} data-msg-required=" " value="{{ $product->productdefaultvariant->offer_price ?? '0.00' }}"
                name="variant_cmp_price[]" placeholder="">

            </div>
          </td>
          {{-- <td>
                    <div class="form-group">
                        <div class="">
                            <input type="text" class="form-control" name="variant_dealer_price[]" value="0.00" placeholder="">
                        </div>
                    </div>
                </td> --}}
          {{-- <td>
                    <div class="form-group">
                        <div class="form-radio ">
                            <div class="radio radiofill radio-success radio-inline">
                                <label>
                                    <input type="radio" name="tax[]" checked="checked">
                                    <i class="helper"></i>Include
                                </label>
                            </div>
                            <div class="radio radiofill radio-primary radio-inline">
                                <label>
                                    <input type="radio" name="tax[]" >
                                    <i class="helper"></i>Excluded
                                </label>
                            </div>
                            <input type="text" class="form-control" name="variant_sku[]" value="" placeholder="">
                        </div>
                    </div>
                </td> --}}
          <td class="align-middle">
            <div class="form-group mb-0">
              <div class="">
                <div>
                  <img src="{{ asset('storage/default/default.png') }}" data-toggle="modal" data-target="#my-modal" alt="" class="w-100 border  rounded shadow-sm card-img-top" style="height:35px" srcset="">
                  <input type="hidden" class="form-control-user required" data-id="image_id" name="image_id[]" value="" placeholder="">
                </div>
              </div>
            </div>
          </td>
          <td class="align-middle">
            <div class="form-group mb-0">
              <input type="text" class="form-control mb-0 required" data-rule-required="true" data-msg-required=" " data-id="variant_inventory" name="variant_inventory[]"
                value="{{ $product->productdefaultvariant->inventory_quantity ?? '0.00' }}" placeholder="">
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  {{-- <button class="btn btn-primary" type="button">Content</button> --}}

  <div id="my-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="my-modal-title">Select Image</h5>
          <button class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row d-flex justify-content-center image-container">
            @if ($product->images->count() > 0)
              @foreach ($product->images as $item)
                <div class="col-3 mb-3" id="select-image-{{ $item->id }}">
                  <i class="ikpos fa fa-check-circles hidden"></i>
                  <img src="{{ $item->variant_image }}" alt="" data-id="{{ $item->id }}" class="w-100 select-img  shadow-sm card-img-top" style="height:125px" srcset="">
                </div>
              @endforeach
            @else
              <h4 class="text-center">Image not available.</h4>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection


@push('js')
  <script src="{{ asset('js/variation.js') }}"></script>
  <script src="{{ asset('js/repeater.js') }}"></script>
@endpush
