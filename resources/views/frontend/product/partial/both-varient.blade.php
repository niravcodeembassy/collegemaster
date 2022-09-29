@php

$productvariants = App\Model\Productvariant::whereProductId($product_id)->get();

foreach ($productvariants as $productvariant) {
    if ($productvariant->type == 'variant') {
        $varint = json_decode($productvariant->variants);
        $array = get_object_vars($varint);
        $properties = array_keys($array);

        if ($array['size'] == $selectBoxval['size'] && $array['printing options'] == $selectBoxval['printing options']) {
            $variant_id = $productvariant->id;
            $image_id = $productvariant->productimage_id;
            $product_id = $productvariant->product_id;
        }
    }
}

$cart = json_encode(['product_id' => $product_id, 'variant_id' => $variant_id, 'image_id' => $image_id]);

@endphp
<div style="display: none">
  <span id="new_main_price">{{ 'US$ ' . $mrp_price . '+' }}</span>
  <span id="new_discounted_price">{{ 'US$ ' . $new_price . '+' }}</span>
  <span id="product_varient_details">{{ $cart }}</span>
  <span id="product_varient_image">{{ $image_id }}</span>
  <span id="product_varient_discount">({{ intval($discount) }}% Off)</span>
</div>


<div class="form-group mb-25">
  <label for="variatoins_2" class="d-block shop-product__block__title"><b>{{ ucfirst('Size') }}</b> <span class="text-danger">*</span></label>
  <div class="d-block clearfix " style="width: 30%;">
    <select name="variatoins" class="form-control change-combination " id="variatoins_2" style="width: 350px;">
      @foreach ($size_new_option as $key => $item)
        @if ($loop->first)
          <option value=""> Select </option>
        @endif
        <option value="{{ $item }}" data-optionvalue="{{ $item }}" @if ($selectBoxval['size'] == $item) {{ 'selected' }} @endif data-option="size">
          {{ $item }} @if ($selectBoxval['size'] != $item)
            -
            ${{ $size_price[$key] }}
          @endif
        </option>
      @endforeach
    </select>
  </div>
</div>

<div class="form-group mb-25">
  <label for="variatoins_1" class="d-block shop-product__block__title"><b>{{ ucfirst('Printing options') }}</b> <span class="text-danger">*</span></label>
  <div class="d-block clearfix " style="width: 30%;">
    <select name="variatoins" class="form-control change-combination " id="variatoins_1" style="width: 350px;">
      @foreach ($printing_new_option as $key => $item)
        @if ($loop->first)
          <option value=""> Select </option>
        @endif
        <option value="{{ $item }}" data-optionvalue="{{ $item }}" @if ($selectBoxval['printing options'] == $item) {{ 'selected' }} @endif data-option="printing options">
          {{ $item }} @if ($selectBoxval['printing options'] != $item)
            - ${{ $printing_price[$key] }}
          @endif
        </option>
      @endforeach
    </select>
  </div>
</div>
