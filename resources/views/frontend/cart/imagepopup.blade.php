<form action="{{ route('cart.image.store' ,['cart' => $cart->id , 'product' => $product->id]) }}"
    enctype="multipart/form-data" method="POST" name="product_form" id="product_form" autocomplete="off">
    @csrf
    <div class="row">
        <div class="col-sm-12">
            <div id="shortable"
                data-remove-url="{{ route('cart.productimage.remove' , ['cart' => $cart->id , 'product' => $product->id] ) }}"
                class="message dropzone">
            </div>
            {{-- <div class="text-danger mt-5">You should have to upload minimum  {{ $attachment }}1 image </div> --}}
        </div>
    </div>

</form>
<div id="preview" style="display: none;">
    <div class="dz-preview dz-file-preview previewImge">
        <div class="preview-short">
            <div class="dz-image"><img data-dz-thumbnail /></div>
            <div class="dz-details">
                <div class="dz-size"><span data-dz-size></span></div>
                {{-- <span class="fa fa-eye font-btn" data-toggle="modal" data-target="#show_image"></span> --}}
                {{-- <span class="font-btn btn-alt" data-toggle="modal" data-target="#modal-id">Alt</span> --}}
                <span class="fa fa-trash font-btn" data-dz-remove></span>
            </div>
        </div>
        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
        <div class="dz-error-message"><span data-dz-errormessage></span></div>
        <div class="dz-success-message"><span dz-success></span></div>
    </div>
</div>

<script type="text/javascript">
    var mokup = @json($mockup);
    var attachment = {{ $attachment }};
</script>


