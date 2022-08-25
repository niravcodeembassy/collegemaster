<div class="lezada-testimonial single-item-testimonial-area testimonial-bg mb-65">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 mx-auto my-2">
        <h2 class="text-center text-uppercase font-weight-bold">CUSTOMER LOVE</h2>
        <div class="divider-custom">
          <div class="divider-custom-line-1"></div>
          <div class="divider-custom-icon">
            <i class="fa fa-circle" aria-hidden="true"></i>
          </div>
          <div class="divider-custom-line-1"></div>
        </div>
      </div>
      <div class="col-lg-6 mx-auto my-5 q-slick-slider">
        <!--=======  testmonial slider container  =======-->
        <div class="">
          <div class="lezada-slick-slider multi-testimonial-slider-container slick-slider "
            data-slick-setting='{
          "slidesToShow": 1,
          "arrows": false,
          "dots": false,
          "autoplay": true,
          "autoplaySpeed": 5000,
          "speed": 1000,
          "prevArrow": {"buttonClass": "slizck-prev", "iconClass": "ti-angle-left" },
          "nextArrow": {"buttonClass": "slick-next", "iconClass": "ti-angle-right" }
        }'
            data-slick-responsive='[
          {"breakpoint":1501, "settings": {"slidesToShow": 1} },
          {"breakpoint":1199, "settings": {"slidesToShow": 1} },
          {"breakpoint":991, "settings": {"slidesToShow": 3, "arrows": false} },
          {"breakpoint":767, "settings": {"slidesToShow": 1, "arrows": false} },
          {"breakpoint":575, "settings": {"slidesToShow": 1,  "arrows": false} },
          {"breakpoint":479, "settings": {"slidesToShow": 1: "arrows": false} }
        ]'>
            @foreach ($testimonial as $item)
              <!--=======  single product  =======-->
              <div class="testimonial my-2">
                <div class="rating text-center my-3">
                  @for ($i = 0; $i < $item->rating; $i++)
                    <i class="fa fa-star star fa-1x" aria-hidden="true"></i>
                  @endfor
                  @for ($i = 0; $i < 5 - $item->rating; $i++)
                    <i class="fa fa-star-o fa-1x" aria-hidden="true"></i>
                  @endfor
                </div>
                <p class="mb-4 text-center">
                  {{ $item->description }}
                </p>
                <p class="float-right"><b>- {{ $item->name }}</b></p>
              </div>

              <!--=======  End of single product  =======-->
            @endforeach

          </div>
        </div>
        <!--=======  End of testmonial slider container  =======-->
      </div>

    </div>
  </div>
</div>
