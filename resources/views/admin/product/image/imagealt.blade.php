<div class="modal fade" id="modal-alt-id">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit image alt text</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-5">
                        <img src="" alt="" id="show-image" style="margin: auto;" class="img-responsive w-100">
                    </div>
                    <div class="col-sm-7">
                            <div class="contct-info">
                                <div class="form-group">
                                    <label for="alt_image">Image alt text</label>
                                    <input type="text" name="alt_image" class="form-control" id="alt_image">
                                    <input type="hidden" name="alt_image_id" id="alt_image_id">                                </div>
                            </div>
                        <p>Write a brief description of this image to improve search engine optimization (SEO) and accessibility for visually impaired customers.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-save btn-success shadow" id="save_image_alt" data-action="{{ route('admin.product.image.alt' ,['product_id' => $product->id ]) }}" name="save_image_alt" ><i class="ik ik-check-circle"></i> Save</button>                        
            </div>
        </div>
    </div>
</div>
