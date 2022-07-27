@extends('admin.layouts.app')

{{-- @section('title' , $title) --}}

@section('content')
@component('component.heading' , [
    'page_title' => 'Product Details',
    'icon' => 'fa fa-shopping-cart' ,
    'tagline' =>'Lorem ipsum dolor sit amet.' ,
    'action' => route('admin.product.index') ,
    'action_icon' => 'fa fa-arrow-left' ,
    'text' => 'Back'
])
@endcomponent

<form action="{{ route('admin.product.show' ,$product->id) }}" enctype="multipart/form-data" method="POST" name="product_form" id="product_form" autocomplete="off">
    @csrf
    <div class="row">
        @include('component.error')
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                    <h5 class="text-mute"><strong>{{ $product->name ?? '' }}</strong> </h5>
                    </div>
                    
                    @if(isset($product->defaultimage) && $product->defaultimage->count() > 0)
                    <div class="form-group">
                        <img src="{{  $product->defaultimage->variant_image  }}" height="100" width="100">
                    </div>
                    @else
                    <div class="form-group"></div>
                    @endif
                    <div class="form-group mb-0 ">
                        <label><b>Product category :</b></label>
                        <span>{{ $product->category->name }}</span>
                    </div>
                    
                    @php
                        $priceData = Helper::productPrice($product->productdefaultvariant);
                    @endphp
                    <label><h6><b>Pricing</b></h6></label>
 
                    <div class="row">
                    <div class="form-group col-sm-4">
                        <label><b>MRP  :</b></label>
                        <span>{!! Helper::priceFormate($product->productdefaultvariant->mrp_price ?? '') !!}</span>
                    </div>

                    <div class="form-group col-sm-4">
                        <label><b>Offer Price :</b></label>
                        <span>{!! Helper::priceFormate($product->productdefaultvariant->offer_price ?? '') !!}</span>
                    </div>

                    <div class="form-group col-sm-4">
                        <label><b>Taxable Price :</b></label>
                        <span>{!! Helper::priceFormate($product->productdefaultvariant->taxable_price ?? '') !!}</span>
                    </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label><b>Content :</b></label>
                        <span>{!! $product->content ?? '' !!}</span>
                    </div>
                    <hr>
                    <label><h6><b>Tax</b></h6></label>

                    <div class="row">
                    <div class="form-group col-sm-4">
                    <label><b>Tax Type :</b></label> 

                    @if($product->tax_type == 1 )
                    {{  $product->tax_type == 1 ?  'Inclusive' : '' }}
                    @else
                    {{  $product->tax_type == 0 ?  'Exclusive' : '' }}
                    @endif

                    </div>

                    <div class="form-group col-sm-4">
                    <label><b>Tax percentage :</b></label>
                    <span>{{  $product->tax ?? '0.00' }}</span>
                    </div>
               
                    </div>
                    <hr>
                    <label><h6><b>Search engine listing preview</b></h6></label>

                    <div class="form-group">
                        <label><b>Page Title :</b></label>
                        <span>{{ $product->meta_title ?? '' }}</span>
                    </div>

                    <div class="form-group">
                        <label><b>Meta Description :</b></label>
                        <span>{{ $product->meta_description ?? '' }}</span>
                    </div>

                    <div class="form-group">
                        <label><b>URL and handle :</b></label>
                        <span>{{ $product->meta_slug ?? '' }}</span>
                    </div>

                </div>
            </div>
        </div>

    @if(isset($productvariant->variantCombination) && count($productvariant->variantCombination) > 0)
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                    <h5 class="text-mute"><strong>Product Variant</strong> </h5>
                    </div>
                    <hr>

                    @foreach ($productvariant->variantCombination as $key => $combination_item)
                    <div style="margin-bottom: 10px;">
                        <div>
                            <label><b>MRP  :</b></label>
                            <span>{!! Helper::priceFormate($combination_item->variant->mrp_price ?? '') !!}
                            </span>
                        </div>

                        <div>
                            <label><b>Offer Price :</b></label>
                            <span>{!! Helper::priceFormate($combination_item->variant->offer_price ?? '') !!}</span>
                        </div>

                        <div>
                            <label><b>Quantity :</b></label>
                            <span>{{ $combination_item->variant->inventory_quantity ?? '1' }}</span>
                        </div>
                        <label for="option_{{$key}}"><b>{{ $combination_item->option->name }} :</b></label>

                        <span id="option_{{$key}}">
                            {{ $combination_item->optionvalue->name }}
                        </span>

                        <hr>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

</div>
</form>


<div id="load-modal"></div>

@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/dist/summernote-bs4.css') }}">
@endpush

@push('js')

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>        
    <script src="{{ asset('js/productimage.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
@endpush

