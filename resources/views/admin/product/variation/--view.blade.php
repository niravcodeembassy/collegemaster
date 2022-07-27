@extends('admin.layouts.app')

@section('title' , $title)

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

@endpush

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
@component('component.heading' , [
    'page_title' => $product->name ,
    'icon' => 'fa fa-shopping-cart' ,
    'tagline' =>'Lorem ipsum dolor sit amet.' ,
    'action' => route('admin.image.index', $product->id) ,
    'action_icon' => 'fa fa-arrow-left' ,
    'text' => 'Back'
])
<a href="" class="btn btn-outline-dark btn-sm btn-rounded ml-3 call-modal" data-target-modal="#editLayoutItem" data-url="{{ route('admin.variation.variation_add',[ 'product_id' => $product->id ]) }}" ><i class="fa fa-plus "></i> Add variant </a>
@endcomponent

<form action="{{ route('admin.product.store') }}" enctype="multipart/form-data" method="POST" name="product_form"
    id="product_form" autocomplete="off">
    @csrf
    <div class="row layout-wrap">
        {{-- @each('admin.product.variation.productvariant', $productvariant,'item') --}}
        @foreach ($productvariant as $item)        
            @include('admin.product.variation.productvariant' ,['item' => $item ] )
        @endforeach
    </div>
    
    <div class="row">
        <div class="col d-flex justify-content-end">
            <a href="{{ route('admin.product.index') }}" class="btn btn-outline-danger shadow" ><i class="fa fa-x"></i>Save & Exit</a>   
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
                    @if($product->images->count() > 0)
                        @foreach ($product->images as $item)
                            <div class="col-3 mb-3" id="select-image-{{$item->id}}">
                                <i class="ikpos fa fa-check-circles hidden"></i>
                                <img src="{{ $item->variant_image }}" alt="" data-id="{{$item->id}}" class="w-100 select-img  shadow-sm card-img-top" style="height:125px" srcset="">
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
<script src="{{ asset('js/plugins/repeater.js') }}"></script>
@endpush
