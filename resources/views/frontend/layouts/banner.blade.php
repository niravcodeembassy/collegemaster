<div class=" breadcrumb-area   pt-20 pb-20" style="background-color: #f5f5f5;">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="breadcrumb-title">{{ $pageTitel }}</h1>
        <ul class="breadcrumb-list">
          <li class="breadcrumb-list__item"><a href="{{ route('front.home') }}">HOME</a></li>
          <li class="breadcrumb-list__item breadcrumb-list__item--active">{{ $pageTitel }}</li>
        </ul>
      </div>
    </div>
  </div>
</div>
