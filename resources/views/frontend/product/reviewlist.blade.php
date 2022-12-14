<!--=======  single review  =======-->
@foreach ($reviews as $item)
<div class="single-review pb-2">
    <div class="single-review__image">
        <img src="{{ $item->user->profile_src  }}" class="img-fluid"
            alt="user image" title="user image">
    </div>
    <div class="single-review__content">
        <!--=======  rating  =======-->

        <div class="shop-product__rating">
            <span class="product-rating">
                @foreach (range(1,$item->rating) as $rating)
                <i class="active ion-android-star"></i>
                @endforeach
            </span>
        </div>

        <!--=======  End of rating  =======-->

        <!--=======  username and date  =======-->

        <p class="username mb-1">{{ $item->name }} <span class="date">/
                {{ $item->created_at->format('M d Y')  }}</span></p>

        <!--=======  End of username and date  =======-->

        <!--=======  message  =======-->

        <p class="message">
            {{ $item->message }}
        </p>

        <!--=======  End of message  =======-->
    </div>
</div>
@endforeach
