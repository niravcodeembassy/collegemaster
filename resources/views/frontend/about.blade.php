@extends('frontend.layouts.app')
@section('title')
{{$page->title}}
@endsection

@section('title', $page->page_title)
@section('keywords', $page->meta_keywords)
@section('published_time', $page->created_at)
@section('description', $page->meta_desc)

@section('og-title', $page->page_title)
@section('og-url', url()->current())
@section('og-description',$page->meta_desc)

@section('twiter-title', $page->meta_title)
@section('twiter-description', $page->meta_desc)


@section('content')
<div class=" breadcrumb-area   pt-20 pb-20 mb-30" style="background-color: #f5f5f5;">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="breadcrumb-title">About Us</h1>

        <!--=======  breadcrumb list  =======-->

        <ul class="breadcrumb-list">
          <li class="breadcrumb-list__item"><a href="{{ url('/') }}">HOME</a></li>
          <li class="breadcrumb-list__item breadcrumb-list__item--active">About us</li>
        </ul>

        <!--=======  End of breadcrumb list  =======-->

      </div>
    </div>
  </div>
</div>
<div class="section-title-container mb-20">
  <div class="container">
    {!! $page->bodyhtml ?? '' !!}
  </div>
</div>

@endsection

@push('script')
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
  function onSubmit(token) {
        document.getElementById("contact-form").submit();
      }
</script>
<script>
  $(".alert").delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });
</script>
@endpush
