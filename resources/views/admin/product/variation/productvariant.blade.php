@include('component.error')
<div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4 list-item list-item-grid" id="data-cell-{{ $item->id }}">
    <article class="card-wrapper">
        <div class="image-holder">

            <div class="action-btn d-flex col justify-content-center my-3">
                <a href="#" class="btn call-model social-btn btn-primary variant-edit image-holder__link "
                    data-target-modal="#editLayoutItem"
                        data-url="{{ route('admin.variation.variation_edit_form' , ['product_id' => $product->id  , 'id'  => $item->id ]) }}"><i
                        class="ik ik-edit"></i> </a> &nbsp;&nbsp;
                <a href="#" class="btn social-btn btn-danger variant-remove image-holder__link "
                    data-url="{{ route('admin.variation.deletevariant' , ['product_id' => $product->id  , 'id'  => $item->id ]) }}"
                    data-id="{{ $item->id  }}"
                    ><i
                        class="ik ik-trash"></i></a>
            </div>

            <div class="image-liquid image-holder--original"
                style="background-image: url('{{ $item->image->variant_image }}')">

            </div>
        </div>
        <div class="product-description">
            <!-- title -->
            <h2 class="product-description__title">
                <a href="#" class="list-title ">
                    @if ($item->variantCombination->count() > 0)
                        @foreach ($item->variantCombination as $combination_item)
                            <span class="text-capitalize"> {{ $combination_item->optionvalue->name }} </span>
                            @if(!$loop->last)
                                |
                            @endif
                        @endforeach
                    @endif
                </a>
            </h2>

            <!-- divider -->
            <hr />

            @if ($item->variantCombination->count() > 0)
                @foreach ($item->variantCombination as $combination_item)
                    <div class="sizes-wrapper">
                        {{-- {{ $combination_item }} --}}
                        <b class="text-uppercase">{{ $combination_item->option->name }}  </b> &nbsp;&nbsp;
                        <span class="text-capitalize badge badge-pill badge-primary"> {{ $combination_item->optionvalue->name }} </span>
                    </div>
                @endforeach
            @endif

        </div>
    </article>
</div>
