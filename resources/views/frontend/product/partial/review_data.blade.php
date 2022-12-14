@foreach ($review as $item)
  @php
    $name = isset($item->user) ? $item->user->name : $item->name;
    $user_url = 'https://ui-avatars.com/api/?name=' . $name;
  @endphp
  <div class="single-review pt-4 mb-0 ">
    <div class="single-review__image">
      <img src="{{ $user_url }}" class="img-fluid" alt="user image" title="user image">
    </div>
    <div class="single-review__content">
      <!--=======  rating  =======-->

      <div class="shop-product__rating">
        <span class="product-rating">
          @foreach (range(1, $item->rating) as $rating)
            <i class="active ion-android-star"></i>
          @endforeach
        </span>
      </div>

      <!--=======  End of rating  =======-->

      <!--=======  username and date  =======-->

      <p class="username">{{ isset($item->user) ? $item->user->name : $item->name }} <span class="date">|
          {{ date('d.m.Y', strtotime($item->created_at)) }}</span>


      </p>

      <!--=======  End of username and date  =======-->

      <!--=======  message  =======-->

      <p class="message">
        {{ $item->message }}
      </p>

      <!--=======  End of message  =======-->
    </div>


  </div>
@endforeach
