@extends('frontend.layouts.app')
@section('title')
  {{ $page->page_title }}
@endsection


@section('meta_title', $page->page_title)
@section('keywords', $page->meta_keywords)
@section('published_time', $page->created_at)
@section('description', $page->meta_desc)

@section('google_name', $page->meta_title)
@section('google_description', $page->meta_description)

@section('og-title', $page->page_title)
@section('og-url', url()->current())
@section('og-description', $page->meta_desc)

@section('twiter-title', $page->meta_title)
@section('twiter-description', $page->meta_desc)

@php
  $schema_organization = Schema::organizationSchema();
  $schema_local = Schema::localSchema();
  $review_schema = Schema::reviewSchema();

  $schema_review = json_encode($review_schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  $schema_organization = json_encode($schema_organization, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  $schema_local = json_encode($schema_local, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

  $schema = [$schema_organization, $schema_local, $schema_review];
@endphp

@section('schema')

  @foreach ($schema as $key => $list)
    <x-schema>
      {!! $list !!}
    </x-schema>
  @endforeach

@endsection

@push('css')
  <link href="{{ asset('front/assets/css/policy.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
  <section class="pt-100 pb-100">
    <div class="container">
      <div class="col-lg-12 col-md-12 col-12 mx-auto">
        <div class="card shadow-lg">
          <div class="card-header bg-gradient-primary p-5 position-relative">
            <h3 class="text-white mb-0">{{ $page->title ?? '' }}</h3>
            @if ($page->updated_at)
              <p class="text-white opacity-8 mb-4">{{ $page->updated_at->format('D M Y') }}</p>
            @endif
            <div class="position-absolute w-100 z-index-1 bottom-0 ms-n5">
              <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 40" preserveAspectRatio="none" shape-rendering="auto" style="height:7vh;min-height:50px;">
                <defs>
                  <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
                  </path>
                </defs>
                <g class="moving-waves">
                  <use xlink:href="#gentle-wave" x="48" y="-1" fill="rgba(255,255,255,0.40"></use>
                  <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.35)"></use>
                  <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.25)"></use>
                  <use xlink:href="#gentle-wave" x="48" y="8" fill="rgba(255,255,255,0.20)"></use>
                  <use xlink:href="#gentle-wave" x="48" y="13" fill="rgba(255,255,255,0.15)"></use>
                  <use xlink:href="#gentle-wave" x="48" y="16" fill="rgba(255,255,255,0.95"></use>
                </g>
              </svg>

            </div>
          </div>
          <div class="card-body pb-50">
            {!! $page->bodyhtml ?? '' !!}
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection



@push('script')
@endpush

@push('javascript')
  <script></script>
@endpush
