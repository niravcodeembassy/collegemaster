<div class="container">
  <div class="row">
    @if($product->buytogetherproducts->count()>0)
    <div class="col-lg-12 order-1 order-lg-2 mb-md-80 mb-sm-80">
      <h2 class="text-center my-4">Related Product</h2 >

      <div class="product-carousel-container product-carousel-container--smarthome mb-15 mb-md-0 mb-sm-0">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <!--=======  product carousel  =======-->

              <div class="lezada-slick-slider product-carousel product-carousel--smarthome" data-slick-setting='{
                "slidesToShow": 4,
                "slidesToScroll": 4,
                "arrows": true,
                "dots": true,
                "autoplay": false,
                "autoplaySpeed": 5000,
                "speed": 1000,
                "prevArrow": {"buttonClass": "slick-prev", "iconClass": "ti-angle-left" },
                "nextArrow": {"buttonClass": "slick-next", "iconClass": "ti-angle-right" }
              }' data-slick-responsive='[
                {"breakpoint":1501, "settings": {"slidesToShow": 4, "arrows": false} },
                {"breakpoint":1199, "settings": {"slidesToShow": 4, "arrows": false} },
                {"breakpoint":991, "settings": {"slidesToShow": 3,"slidesToScroll": 3, "arrows": false} },
                {"breakpoint":767, "settings": {"slidesToShow": 2, "slidesToScroll": 2, "arrows": false} },
                {"breakpoint":575, "settings": {"slidesToShow": 2, "slidesToScroll": 2,  "arrows": false} },
                {"breakpoint":479, "settings": {"slidesToShow": 1, "slidesToScroll": 1, "arrows": false} }
              ]'>
                @foreach ($product->buytogetherproducts as $item)
                <!--=======  single product  =======-->
                <div class="col">
                  @include('frontend.product.partial.singleproduct' ,[
                  'product' => $item
                  ])
                </div>
                <!--=======  End of single product  =======-->
                @endforeach

                <!--=======  End of single product  =======-->
              </div>

              <!--=======  End of product carousel  =======-->
            </div>
          </div>
        </div>
      </div>


    </div>
    @endif
  </div>

</div>
