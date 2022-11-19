@extends('admin.layouts.app')

@section('title', $title)

@push('style')
    {{-- <style type="text/css">
    .layout-wrap .list-item.list-item-grid .card .card-img img {
        height: auto;
        width: inherit !important;
    }
    .p_ueM_I {
        flex: 1 1;
    }
    ._1z6sc {
        display: block;
        width: 100%;
        padding: 0;
        border: none;
        background: none;
        color: inherit;
        font: inherit;
        cursor: pointer;
        outline: inherit;
    }

    ._1IXIk {
        position: relative;
        box-sizing: initial;
        display: flex;
        justify-content: center;
        align-items: center;
        padding-bottom: 100%;
        border-radius: inherit;
        border: 1px solid #dddfe6;
        cursor: pointer;
    }

    .lFpg1 {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        display: block;
        max-width: 100%;
        max-height: 100%;
        margin: auto;
    }

</style> --}}
    <style>
        .card-img-top {
            width: 100%;
            height: 15vw;
            object-fit: cover;
        }

        .layout-wrap .list-item .list-actions a:hover,
        .layout-wrap .list-item .list-actions a:focus {
            background-color: inherit !important;
            color: inherit !important;
        }
    </style>
    <style class="cp-pen-styles">
        .product-description {
            transform: translate3d(0, 0, 0);
            transform-style: preserve-3d;
            perspective: 1000;
            backface-visibility: hidden;
        }

        hr {
            border-color: #e5e5e5;
            margin: 15px 0;
        }

        .secondary-text {
            color: #b6b6b6;
        }

        .list-inline {
            margin: 0;
        }

        .list-inline li {
            padding: 0;
        }

        .action-btn {
            position: absolute;
            opacity: 0;
        }

        .card-wrapper {
            position: relative;
            width: 100%;
            /* height: 390px; */
            height: 300px;
            border: 1px solid #e5e5e5;
            border-bottom-width: 2px;
            overflow: hidden;
            margin-bottom: 30px;
        }


        .card-wrapper:after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transition: opacity 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .card-wrapper:hover:after {
            opacity: 1;
        }

        .card-wrapper:hover .action-btn {
            opacity: 1;
            transition: all ease-in-out;
        }

        .card-wrapper:hover .image-holder:before {
            opacity: .75;
        }

        .card-wrapper:hover .image-holder:after {
            opacity: 1;
            transform: translate(-50%, -50%);
        }

        .card-wrapper:hover .image-holder--original {
            transform: translateY(-15px);
        }

        .card-wrapper:hover .product-description {
            height: 205px;
        }

        @media (min-width: 768px) {
            .card-wrapper:hover .product-description {
                height: 235px;
            }
        }

        .image-holder {
            display: block;
            position: relative;
            width: 100%;
            height: 310px;
            background-color: #ffffff;
            z-index: 1;
        }

        @media (min-width: 768px) {
            .image-holder {
                height: 325px;
            }
        }

        .image-holder:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #4CAF50;
            opacity: 0;
            z-index: 5;
            transition: opacity 0.6s;
        }

        /* .image-holder:after {
              content: '+';
              font-family: 'Raleway', sans-serif;
              font-size: 70px;
              color: #4CAF50;
              text-align: center;
              position: absolute;
              top: 92.5px;
              left: 50%;
              width: 75px;
              height: 75px;
              line-height: 75px;
              background-color: #ffffff;
              opacity: 0;
              border-radius: 50%;
              z-index: 10;
              transform: translate(-50%, 100%);
              box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
              transition: all 0.4s ease-out;
          } */

        @media (min-width: 768px) {
            .image-holder:after {
                top: 107.5px;
            }
        }

        .image-holder .image-holder__link {
            /* display: block; */
            position: relative;
            z-index: 5;
        }

        .image-holder .image-holder--original {
            transition: transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .image-liquid {
            width: 100%;
            height: 325px;
            background-size: cover;
            background-position: center center;
            object-fit: cover;
        }

        .product-description {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 80px;
            padding: 10px 15px;
            overflow: hidden;
            background-color: #fafafa;
            border-top: 1px solid #e5e5e5;
            transition: height 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
            z-index: 2;
        }

        @media (min-width: 768px) {
            .product-description {
                height: 40px;
            }
        }

        .product-description p {
            margin: 0 0 5px;
        }

        .product-description .product-description__title {
            font-family: 'Raleway', sans-serif;
            position: relative;
            white-space: nowrap;
            overflow: hidden;
            margin: 0;
            font-size: 18px;
            line-height: 1.25;
        }

        .product-description .product-description__title:after {
            content: '';
            width: 60px;
            height: 100%;
            position: absolute;
            top: 0;
            right: 0;
            background: linear-gradient(to right, rgba(255, 255, 255, 0), #fafafa);
        }

        .product-description .product-description__title a {
            text-decoration: none;
            color: inherit;
        }

        .product-description .product-description__category {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-description .product-description__price {
            color: #4CAF50;
            text-align: left;
            font-weight: bold;
            letter-spacing: 0.06em;
        }

        @media (min-width: 768px) {
            .product-description .product-description__price {
                text-align: right;
            }
        }

        .product-description .sizes-wrapper {
            margin-bottom: 15px;
        }

        .product-description .color-list {
            font-size: 0;
        }

        .product-description .color-list__item {
            width: 25px;
            height: 10px;
            position: relative;
            z-index: 1;
            transition: all .2s;
        }

        .product-description .color-list__item:hover {
            width: 40px;
        }

        .product-description .color-list__item--red {
            background-color: #F44336;
        }

        .product-description .color-list__item--blue {
            background-color: #448AFF;
        }

        .product-description .color-list__item--green {
            background-color: #CDDC39;
        }

        .product-description .color-list__item--orange {
            background-color: #FF9800;
        }

        .product-description .color-list__item--purple {
            background-color: #673AB7;
        }
    </style>
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

        .img-active {
            border: 3px solid #2dce89 !important;
            border-radius: 10px;
        }
    </style>
@endpush




@section('content')
    @component('component.heading',
        [
            'page_title' => $product->name,
            'icon' => 'fa fa-shopping-cart',
            'tagline' => 'Lorem ipsum dolor sit amet.',
            'action' => route('admin.image.index', $product->id),
            'action_icon' => 'fa fa-arrow-left',
            'text' => 'Back',
        ])
    @endcomponent
    @php
        $action = isset($variation) ? route('admin.variation.variation_update_form', ['product_id' => $product->id, 'id' => $variation->id]) : route('admin.variation.variation_add_save', ['product_id' => $product->id]);
        $imageData = $productvariant->map(function ($item) use ($product) {
            return [
                'productimage_id' => $item->productimage_id,
                'id' => $item->id,
            ];
        });
    @endphp
    <form action="{{ $action }}" enctype="multipart/form-data" method="POST" name="variation_form" id="variation_form"
        autocomplete="off">
        @csrf

        <div class="row layout-wrap" x-data="uploadImages()" x-init="init({{ $imageData }}, '{{ route('admin.product.image.saveVariantImages') }}')"
            data-save-url="{{ route('admin.product.image.saveVariantImages') }}">
            {{-- @each('admin.product.variation.productvariant', $productvariant,'item') --}}

            <div class="col-sm-6">
                <div class="row">
                    <div class="col-12">
                        <a name="" id="" class="btn btn-primary btn-sm float-right mb-3" href="#"
                            @click="hendleUpload()" role="button">Upload Image</a>
                    </div>
                </div>
                <template x-if="showupload === false">
                    <div>
                        @foreach ($productvariant as $item)
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('admin.variation.variation_edit', ['product_id' => $item->product_id, 'variation' => $item->id]) }}"
                                            style="width: 95%;margin-right: 5px;">
                                            <div
                                                class="align-items-center bg-white d-flex justify-content-between rounded px-1">
                                                <div class="col-1 p-0">
                                                    <img class="rounded shadow" src="{{ $item->image->variant_image }}"
                                                        style="width: 56px;height: 56px;object-fit: contain;background: #e2e8f0;">
                                                </div>
                                                <div class="d-flex col-7 flex-column product-details">
                                                    <span
                                                        class="font-weight-bold text-left">{{ $item->product->name }}</span>
                                                    <div class="d-flex flex-row product-desc">
                                                        <div class="size mr-1">

                                                            @if ($item->variantCombinationone)
                                                                @php
                                                                    $variant = $item->variantCombinationone->variants;
                                                                    $variant = collect($variant)
                                                                        ->map(function ($key, $item) {
                                                                            return '<span class="text-grey">' . $item . ' : </span><span class="font-weight-bold">&nbsp;' . $key . '</span>';
                                                                        })
                                                                        ->join('&nbsp;&nbsp;');
                                                                @endphp
                                                                {!! $variant !!}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row align-items-center qty">
                                                    <h5 class="text-grey mt-1 mr-1 ml-1">{{ $item->inventory_quantity }}
                                                    </h5>
                                                </div>
                                                <div>
                                                    <h5 class="text-grey">{{ $item->offer_price ?? $item->mrp_price }}</h5>
                                                </div>
                                            </div>
                                        </a>
                                        <a
                                            href="{{ route('admin.variation.deletevariant', ['product_id' => $item->product_id, 'id' => $item->id]) }}">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-trash mb-1 text-danger"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </template>
                <template x-if="showupload === true">
                    <div>
                        @foreach ($productvariant as $item)
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="align-items-center bg-white d-flex justify-content-between rounded px-1">
                                            <div class="col-1 p-0">
                                                <img class="rounded shadow" src="{{ $item->image->variant_image }}"
                                                    style="width: 56px;height: 56px;object-fit: contain;background: #e2e8f0;cursor: pointer;"
                                                    data-id="{{ $item->id }}">
                                            </div>
                                            <div class="d-flex col-7 flex-column product-details">
                                                <span class="font-weight-bold text-left">{{ $item->product->name }}</span>
                                                <div class="d-flex flex-row product-desc">
                                                    <div class="size mr-1">

                                                        @if ($item->variantCombinationone)
                                                            @php
                                                                $variant = $item->variantCombinationone->variants;
                                                                $variant = collect($variant)
                                                                    ->map(function ($key, $item) {
                                                                        return '<span class="text-grey">' . $item . ' : </span><span class="font-weight-bold">&nbsp;' . $key . '</span>';
                                                                    })
                                                                    ->join('&nbsp;&nbsp;');
                                                            @endphp
                                                            {!! $variant !!}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center qty">
                                                <h5 class="text-grey mt-1 mr-1 ml-1">{{ $item->inventory_quantity }}</h5>
                                            </div>
                                            <div>
                                                <h5 class="text-grey">{{ $item->offer_price ?? $item->mrp_price }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="align-items-center d-flex flex-wrap">
                                        @if ($product->images->count() > 0)
                                            @foreach ($product->images as $imgitem)
                                                <div class=" mb-3" style="width: 75px"
                                                    id="select-image-{{ $imgitem->id }}">
                                                    <i class="ikpos fa fa-check-circles d-none"></i>
                                                    <img src="{{ $imgitem->variant_image }}"
                                                        @click="imageClick({{ $item->id }},{{ $imgitem->id }})"
                                                        data-varint="{{ $item->id }}" data-id="{{ $imgitem->id }}"
                                                        class="w-100 rounded shadow card-img-top"
                                                        :class="{ 'img-active': hasSelected({{ $item->id }},
                                                                {{ $imgitem->id }}) }"
                                                        style="width: 56px;height: 56px;object-fit: contain;background: #e2e8f0;cursor: pointer;"
                                                        srcset="">
                                                </div>
                                            @endforeach
                                        @else
                                            <h4 class="text-center">Image not available.</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-success btn-sm float-right"
                                @click="saveImages()">Save</button>
                        </div>
                    </div>
                </template>
            </div>
            <div class="col-sm-5 offset-lg-1">
                <div class="form-row">

                    <div class="col-md-12 px-sm-3 px-2">

                        <h6 class="text-mute"><strong>Variation</strong></h6>
                        <hr class="my-2">
                        @if (isset($productvariantcombination) && $productvariantcombination->count() > 0)
                            @foreach ($productvariantcombination as $key => $item)
                                @php
                                    $option = $item->option;
                                    $optionval = $item->optionvalue;
                                @endphp
                                <input type="hidden" name="optionvalue_id[]" value="{{ $item->option_value_id }}">
                                <input type="hidden" name="combination_id[]" value="{{ $item->id }}">

                                <div class="repeter-list">
                                    <input type="hidden" name="option[]" value="{{ $option->id }}"
                                        id="option_id_{{ $option->id }}">
                                    <div class="form-group">
                                        <label class="text-capitalize"
                                            for="variants_name_{{ $loop->iteration }}">{{ $option->name }}</label>
                                        <select id="variants_id_{{ $loop->iteration }}" data-rule-required="true"
                                            data-target="#option_id_{{ $option->id }}"
                                            data-url="{{ route('admin.get.optionvalue') }}"
                                            name="variants_id[{{ $loop->index }}]"
                                            data-msg-required="Variation is required." style="width: 100%;"
                                            class="form-control text-lowercase variants_tags">
                                            @if ($item)
                                                <option value="{{ $optionval->id }}" selected>
                                                    {{ $optionval->name }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @if ($product->onlyoption->count() > 0)
                                @foreach ($product->onlyoption as $item)
                                    <div class="repeter-list">
                                        <input type="hidden" name="option[]" value="{{ $item->option->id }}"
                                            id="option_id_{{ $item->option->id }}">
                                        <div class="form-group">
                                            <label class="text-capitalize"
                                                for="variants_name_{{ $loop->iteration }}">{{ $item->option->name }}</label>
                                            <select id="variants_name_{{ $loop->iteration }}" data-rule-required="true"
                                                data-target="#option_id_{{ $item->option->id }}"
                                                data-url="{{ route('admin.get.optionvalue') }}"
                                                name="variants_id[{{ $loop->index }}]"
                                                data-msg-required="Variation is required." style="width: 100%;"
                                                class="form-control text-lowercase variants_tags">
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endif


                        {{-- @dump($productvariant) --}}

                        <h6 class="text-mute"><strong>Pricing</strong></h6>
                        <hr class="my-2">
                        <div class="row">
                            <div class="form-group col">
                                <label for="mrp_price">MRP <span class="text-danger">*</span> </label>
                                <input id="mrp_amount" class="form-control" data-rule-required="true"
                                    data-msg-required="MRP  is required." data-rule-number="true" type="text"
                                    value="{{ $variation->mrp_price ?? '' }}" name="mrp_amount">
                            </div>

                            <div class="form-group col">
                                <label for="offer_price">Offer Price</label>
                                <input id="offer_price" name="offer_price" value="{{ $variation->offer_price ?? '' }}"
                                    data-rule-required="false" data-rule-number="true" class="form-control"
                                    type="text" name="" value="">
                            </div>
                        </div>

                        <h6 class="text-mute"><strong>Inventory</strong></h6>
                        <hr class="my-2">


                        <div class="form-group">
                            <label for="inventory_quantity">Quantity <span class="text-danger">*</span></label>
                            <input id="my-input" class="form-control" data-rule-required="true"
                                value="{{ $variation->inventory_quantity ?? 1 }}"
                                data-msg-required="Quantity is required." type="text" id="quantity"
                                name="inventory_quantity">
                        </div>

                    </div>
                    <div class="col px-3">
                        <div class="card ">
                            <div class="card-body p-0 border show-img">

                                <div class="form-group">
                                    <div class="text-center">
                                        @if (isset($variation))
                                            <img src="{{ $variation->image->variant_image ? $variation->image->variant_image : asset('storage/default/default.png') }}"
                                                data-default="{{ asset('storage/default/default.png') }}" class="w-100 "
                                                style="height: 220px;object-fit: cover;" id="preview">
                                        @else
                                            <img src="{{ asset('storage/default/default.png') }}"
                                                data-default="{{ asset('storage/default/default.png') }}" class="w-100 "
                                                style="height: 220px;object-fit: cover;" id="preview">
                                        @endif

                                    </div>
                                </div>


                                <div class="form-group">
                                    <input type="file" name="slider_image" class=" d-none  file-upload-default"
                                        data-rule-accept="jpg,png,jpeg"
                                        data-msg-accept="Only image type jpg/png/jpeg is allowed."
                                        data-rule-required="false" data-rule-filesize="5000000" id="featured_image"
                                        data-msg-required="Image is required."
                                        data-msg-filesize="File size must be less than 5mb">
                                    {{-- <div class="input-group mb-2"> --}}
                                    <div class="justify-content-center d-flex mb-2">
                                        <button type="button" class="btn shadow btn-info " data-toggle="modal"
                                            data-target="#my-modal">Select Image</button>
                                        <input type="hidden" id="image_id" name="image_id"
                                            value="{{ $variation->productimage_id ?? '' }}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col d-flex justify-content-end">
                <button type="submit" name="save" value="save" class="btn btn-success mr-3 shadow">
                    {{ isset($variation) ? 'Update' : 'Save' }} </button>
                <a type="submit" href="{{ route('admin.product.index') }}" name="save" value="save_and_exit"
                    class="btn btn-outline-danger shadow">Exit</a>
            </div>
        </div>
    </form>


    <div id="load-modal"></div>

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
                                    <i class="ikpos fa fa-check-circles d-none"></i>
                                    <img src="{{ $item->variant_image }}" alt="" data-id="{{ $item->id }}"
                                        class="w-100 select-img  shadow-sm card-img-top" style="height:125px"
                                        srcset="">
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
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
@endpush
@push('scripts')
    <script>
        function uploadImages() {
            return {
                showupload: false,
                images: [],
                url: null,
                hendleUpload() {
                    this.showupload = !this.showupload;
                    console.log('this.showupload', this.showupload);
                },
                imageClick(itemId, imageId) {
                    const images = this.images.map((item) => {
                        if (itemId === item.id) {
                            item.productimage_id = imageId;
                        }
                        return item;
                    });
                    this.images = images;
                },
                hasSelected(itemId, imageId) {
                    const data = this.images;
                    return data.find((item) => {
                        return item.id == itemId && item.productimage_id == imageId
                    });
                },
                init(images, url) {
                    this.images = images;
                    this.url = url;
                },
                saveImages() {
                    window.loaders.show();
                    const data = JSON.parse(JSON.stringify(this.images));
                    console.log(data);
                    $.ajax({
                        type: "POST",
                        url: this.url,
                        data: {
                            data: data
                        }
                    }).always(function() {
                        window.loaders.hide();
                    }).done(function(res) {
                        toast.fire({
                            type: 'success',
                            title: 'Success',
                            text: res.message ? res.message : 'something went wrong please try again !'
                        }).then(function() {
                            window.location.reload();
                        });
                    });
                }
            }
        }
    </script>
@endpush
