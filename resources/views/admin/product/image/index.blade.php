@extends('admin.layouts.app')

@section('title' , $title)

@section('content')
@component('component.heading' , [
'page_title' => 'Upload Image',
'icon' => 'fa fa-shopping-cart' ,
'tagline' =>'Lorem ipsum dolor sit amet.' ,
'action' => route( request()->get('route' ,'admin.product.edit') , $product->id) ,
'action_icon' => 'fa fa-arrow-left' ,
'text' => 'Back',
])
@endcomponent

<form action="{{ route('admin.image.store' ,$product->id) }}" enctype="multipart/form-data" method="POST"
    name="product_form" id="product_form" autocomplete="off">
    @csrf
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-mute"><strong>Product Image</strong> </h6>
                    <hr>
                    <div class="form-group">
                        <div id="shortable" data-remove-url="{{ route('admin.product.image.remove' , ['product_id' =>  $product->id ] ) }}" data-position-url="{{ route('admin.product.image.position' , ['product_id' =>  $product->id ] ) }}" class="message dropzone">
                        </div>
                    </div>
                    <div class="pull-right">
                        <button type="submit" name="submit" id="save_exit"  value="save_exit"  class="btn btn-sm btn-info shadow ">
                           Upload
                        </button>
                    </div>


                </div>
            </div>
            <span class="text-danger">Note : Image must be 800 x 800 </span>
        </div>
    </div>
    <div class="dropzoneel">

    </div>
    <div class="row">
        <div class="col d-flex justify-content-end">

            <a href="{{ route( request()->get('route' ,'admin.product.index') , [ 'id'=> $product->id ]) }}" name="submit"
                value="save_exit" class="btn btn-outline-danger shadow"> Save & Exit
            </a>
            &nbsp;&nbsp;&nbsp;


                @if($productvariant > 1)
                    <a href="{{ route('admin.variation.variation_edit' , $product->id) }}" id="save_add_variant" name="submit" value="save_add_variant" class="btn btn-success shadow"> Goto Variation{{-- Update variation --}}
                    </a>
                @else
                {{-- <div class="wrap"> --}}
                    <a href="{{ route('admin.variation.create' , $product->id) }}" id="save_add_variant" name="submit" value="save_add_variant" class="btn btn-success shadow"> Add variation
                    </a>
                {{-- </div> --}}
                @endif

        </div>
    </div>
</form>

@include('admin.product.image.imagealt')
@include('admin.product.image.showimage')

{{--Dropzone Preview Template--}}
<div id="preview" style="display: none;">
    <div class="dz-preview dz-file-preview previewImge">
        <div class="preview-short">
            <div class="dz-image"><img data-dz-thumbnail /></div>
            <div class="dz-details">
                <div class="dz-size"><span data-dz-size></span></div>
                <span class="fa fa-eye font-btn" data-toggle="modal" data-target="#show_image"></span>
                <span class="font-btn btn-alt" data-toggle="modal" data-target="#modal-id">Alt</span>
                <span class="fa fa-trash font-btn" data-dz-remove></span>
            </div>
        </div>
        <div class="dz-error-message"><span data-dz-errormessage></span></div>
        <div class="dz-success-message"><span dz-success></span></div>
    </div>
</div>

{{--Dropzone Preview Template--}}
{{--<div id="preview" style="display: none;" >--}}

    {{--<div class="dz-preview dz-file-preview">--}}
        {{--<div class="dz-image"><img data-dz-thumbnail /></div>--}}

        {{--<div class="dz-details">--}}
            {{--<div class="dz-size"><span data-dz-size></span></div>--}}
            {{--<div class="dz-filename"><span data-dz-name></span></div>--}}
        {{--</div>--}}
        {{--<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>--}}
        {{--<div class="dz-error-message"><span data-dz-errormessage></span></div>--}}



        {{--<div class="dz-success-mark">--}}

            {{--<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">--}}
                {{--<!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->--}}
                {{--<title>Check</title>--}}
                {{--<desc>Created with Sketch.</desc>--}}
                {{--<defs></defs>--}}
                {{--<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">--}}
                    {{--<path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>--}}
                {{--</g>--}}
            {{--</svg>--}}

        {{--</div>--}}
        {{--<div class="dz-error-mark">--}}

            {{--<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">--}}
                {{--<!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->--}}
                {{--<title>error</title>--}}
                {{--<desc>Created with Sketch.</desc>--}}
                {{--<defs></defs>--}}
                {{--<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">--}}
                    {{--<g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">--}}
                        {{--<path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>--}}
                    {{--</g>--}}
                {{--</g>--}}
            {{--</svg>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--End of Dropzone Preview Template--}}
{{--End of Dropzone Preview Template--}}
<div id="load-modal"></div>

@endsection
@push('style')
<style>

 /*a[disabled="disabled"] {
        pointer-events: none;
    }*/
    /*.wrap {*/
    /*position: relative;*/
    /*cursor: text;   This is used */
    /*}*/
    /*.wrap:after {
        content: '';
        position: absolute;
        width: 100%; height: 100%;
        top: 0; left: 0;
    }*/
   /* .wrap a {
        pointer-events: none;
    }*/

    .select2-container--bootstrap .select2-selection--single,
        {
        height: 41px !important;
        line-height: 2 !important;
        padding: 6px 24px 6px 12px !important;
    }

    .select2-container--bootstrap .select2-selection--multiple {
        min-height: 42px;
        line-height: 2 !important;
        padding: 6px 5px;
    }

    .select2-container--bootstrap .select2-selection {
        border-radius: 0;
    }

    .page-heading {
        margin: 20px 0;
        color: #666;
        -webkit-font-smoothing: antialiased;
        font-family: "Segoe UI Light", "Arial", serif;
        font-weight: 600;
        letter-spacing: 0.05em;
    }

    #my-dropzone .message {
        font-family: "Segoe UI Light", "Arial", serif;
        font-weight: 600;
        color: #0087F7;
        font-size: 1.5em;
        letter-spacing: 0.05em;
    }

    .dropzone {
        border: 2px dashed #0087F7;
        background: white;
        border-radius: 5PX;
        min-height: 100px;
        padding: 10px 0;
        vertical-align: baseline;
    }

    .dropzone .dz-preview:hover .dz-details {
        bottom: 0;
        background: rgba(0, 0, 0, 0.5) !important;
        padding: 20px 0 0 0;
        cursor: move;
    }

    .dz-image {
        width: 150px;
        height: 150px;
    }

    .font-btn {
        color: white;
        font-size: 15px;
        position: relative;
        bottom: -25px;
        padding: 4px;
        /* text-align: center; */
        cursor: pointer !important;
    }


    .dz-remove {
        display: none !important;
    }

</style>
@endpush

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
@endpush

@push('js')

<script type="text/javascript">
    var mokup = @json($mockup);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/productimage.js') }}"></script>

@endpush

@push('scripts')

@endpush
