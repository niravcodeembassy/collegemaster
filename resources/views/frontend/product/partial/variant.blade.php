@if ($new_option_lable == 'size')
  @php
    $size_item = [];
    $frame = [];

    if (isset($variatoinList)) {
        foreach ($variatoinList as $key => $variatoins) {
            $option = \App\Model\Option::find($key);
            $productvariants = \App\Model\ProductVariant::whereProductId($product_id)->get();

            if ($new_option_lable == 'size' && $new_option_lable == $option->name) {
                foreach ($variatoins as $item) {
                    $new_price = [];
                  
                    foreach ($productvariants as $key => $productvariant) {
                        if ($productvariant->type == 'variant') {
                            $varint = json_decode($productvariant->variants);
                            $array = get_object_vars($varint);
                            $properties = array_keys($array);
                            if (in_array('size', $properties)) {
                                if ($item->name == $array[$option->name]) {
                                    array_push($new_price, $productvariant->offer_price);
                                }
                            }
                        }
                    }

                    $size_item[] = [
                        'id' => $item->id,
                        'optionvalue' => $item->name,
                        'option' => $option->name,
                        'price' => $new_price,
                    ];
                }
            } else {
                foreach ($variatoins as $item) {
                    $frame[] = [
                        'id' => $item->id,
                        'optionvalue' => $item->name,
                        'option' => $option->name,
                    ];
                }
            }
        }
    }

  @endphp

  <div class="form-group mb-25">
    <label for="variatoins_1" class="d-block shop-product__block__title"><b>{{ ucfirst('Size') }}</b> <span class="text-danger">*</span></label>
    <div class="d-block clearfix " style="width: 30%;">
      <select name="variatoins" class="form-control change-combination " id="variatoins_1" style="width: 250px;">
        @foreach ($size_item as $item)
          @php

          @endphp
          @if ($loop->first)
            <option value=""> Select </option>
          @endif
          <option value="{{ $item['id'] }}" data-optionvalue="{{ $item['optionvalue'] }}" data-option="{{ $item['option'] }}" @if ($item['optionvalue'] == $optionVal) {{ 'selected' }} @endif>
            {{ $item['optionvalue'] }} @if ($item['optionvalue'] != $optionVal)
              - (${{ min($item['price']) }} - ${{ max($item['price']) }})
            @endif
          </option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="form-group mb-25">
    <label for="variatoins_2" class="d-block shop-product__block__title"><b>{{ ucfirst('Printing options') }}</b> <span class="text-danger">*</span></label>
    <div class="d-block clearfix " style="width: 30%;">
      <select name="variatoins" class="form-control change-combination " id="variatoins_2" style="width: 250px;">
        @foreach ($new_option as $key => $item)
          @if ($loop->first)
            <option value=""> Select </option>
          @endif
          <option value="{{ $item }}" data-optionvalue="{{ $item }}" data-option="printing options">
            {{ $item }} - ${{ $price[$key] }}
          </option>
        @endforeach
      </select>
    </div>
  </div>
@else
  @php
    $size_item = [];
    $frame = [];

    if (isset($variatoinList)) {
        foreach ($variatoinList as $key => $variatoins) {
            $option = \App\Model\Option::find($key);
            $productvariants = \App\Model\ProductVariant::whereProductId($product_id)->get();

            if ($new_option_lable == 'printing options' && $new_option_lable == $option->name) {
                foreach ($variatoins as $item) {
                    $new_price = [];

                    foreach ($productvariants as $key => $productvariant) {
                        if ($productvariant->type == 'variant') {
                            $varint = json_decode($productvariant->variants);
                            $array = get_object_vars($varint);
                            $properties = array_keys($array);
                            if (in_array('printing options', $properties)) {
                                if ($item->name == $array[$option->name]) {
                                    array_push($new_price, $productvariant->offer_price);
                                }
                            }
                        }
                    }
                    $frame[] = [
                        'id' => $item->id,
                        'optionvalue' => $item->name,
                        'option' => $option->name,
                        'price' => $new_price,
                    ];
                }
            } else {
                foreach ($variatoins as $item) {
                    $size_item[] = [
                        'id' => $item->id,
                        'optionvalue' => $item->name,
                        'option' => $option->name,
                    ];
                }
            }
        }
    }

  @endphp



  <div class="form-group mb-25">
    <label for="variatoins_2" class="d-block shop-product__block__title"><b>{{ ucfirst('Size') }}</b> <span class="text-danger">*</span></label>
    <div class="d-block clearfix " style="width: 30%;">
      <select name="variatoins" class="form-control change-combination " id="variatoins_2" style="width: 250px;">
        @foreach ($new_option as $key => $item)
          @if ($loop->first)
            <option value=""> Select </option>
          @endif
          <option value="{{ $item }}" data-optionvalue="{{ $item }}" data-option="size">
            {{ $item }} - ${{ $price[$key] }}
          </option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="form-group mb-25">
    <label for="variatoins_1" class="d-block shop-product__block__title"><b>{{ ucfirst('Printing options') }}</b> <span class="text-danger">*</span></label>
    <div class="d-block clearfix " style="width: 30%;">
      <select name="variatoins" class="form-control change-combination " id="variatoins_1" style="width: 250px;">
        @foreach ($frame as $item)
          @if ($loop->first)
            <option value=""> Select </option>
          @endif
          <option value="{{ $item['id'] }}" data-optionvalue="{{ $item['optionvalue'] }}" data-option="{{ $item['option'] }}" @if ($item['optionvalue'] == $optionVal) {{ 'selected' }} @endif>
            {{ $item['optionvalue'] }} @if ($item['optionvalue'] != $optionVal)
              - (${{ min($item['price']) }} - ${{ max($item['price']) }})
            @endif
          </option>
        @endforeach
      </select>
    </div>
  </div>
@endif
