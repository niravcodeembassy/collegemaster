<div class="border">
    <div class="main p-4">
        <div
            class="customer d-flex justify-content-between flex-wrap  {{ $review->count() > 0 ? 'border-bottom' : '' }}">
            <div class="">
                <h3>Customer Reviews</h3>
                <div class="display-flex cus_review">
                    <span>
                        @php
                            $r = (round($review_rating, 1) * 100) / 500;
                            $rating_percentage = $r * 100;
                        @endphp

                        <div class="rating-box">
                            <div class="rating" style="width:{{ $rating_percentage }}%;"></div>
                        </div>
                        <span class="font-weight-bold">({{ round($review_rating, 1) }})</span>
                        Based on {{ $product_review->count() }} reviews
                    </span>
                </div>
            </div>
            <div class="mt-3">
                <a class="lezada-button lezada-button--medium review_btn" data-toggle="collapse" href="#reviewForm"
                    role="button" aria-expanded="false" aria-controls="collapseExample">WRITE A REVIEW</a>
            </div>
        </div>

        <div class="collapse py-4 border-bottom border-top" id="reviewForm">
            <h3 class="review-title mb-20">write a review</h3>
            <p>Your email address will not be published. Required
                fields are marked *
            </p>

            <!--=======  review form  =======-->

            <div class="lezada-form lezada-form--review">
                <form method="POST" action="{{ route('product.review', $product->id) }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-20">
                            <input type="text" name="name" required placeholder="Name *" required>
                        </div>
                        <div class="col-lg-6 mb-20">
                            <input type="email" name="email" required placeholder="Email *" required>
                        </div>
                        <div class="col-lg-12 mb-20">
                            <span class="rating-title mr-30">YOUR RATING</span>
                            <span class="product-rating">

                                <select id="rating" name="rating">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </span>
                        </div>
                        <div class="col-lg-12 mb-20">
                            <textarea cols="30" rows="10" required name="message" placeholder="Your review *"></textarea>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="lezada-button lezada-button--medium">submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if ($review->count() > 0 && $review != null)
            <div id="review-data">
                @include('frontend.product.partial.review_data')
            </div>
            <h4 class="ajax-load pt-2 text-center" style="display: none"></h4>
            <div class="text-center mb-40 pt-4">
                <button class="lezada-button lezada-button--small review_load"
                    data-url="{{ route('product.review.list', ['product' => $product->id]) }}">Load More</button>
            </div>
        @endif
    </div>
</div>
