@extends('frontend.layouts.app')
@section('title')
  {{ $title }}
@endsection

@php
$schema_organization = Schema::organizationSchema();
$schema_local = Schema::localSchema();

$schema_organization = json_encode($schema_organization, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$schema_local = json_encode($schema_local, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

$schema = [$schema_organization, $schema_local];
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
  <link href="{{ asset('front/assets/css/faq.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
  <section class="pt-100 pb-100">
    <div class="container">
      <div class="col-lg-9 col-md-10 mx-auto">
        <div class="card shadow-lg">
          <div class="card-header bg-gradient-primary p-5 position-relative">
            <h3 class="text-white mb-0">{{ $title ?? '' }}</h3>
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
          <div class="card-body p-sm-5 pt-0">
            @if ($faq->count() > 0)
              @foreach ($faq as $key => $item)
                <h4 class="my-4 ps-3">{{ $item->title ?? '' }}</h4>
                <div class="accordion" id="accordionFaq{{ $key }}">
                  @if ($item->children->count() > 0)
                    @foreach ($item->children as $key => $child)
                      <div class="accordion-item mb-3">
                        <h5 class="accordion-header" id="headingOne">
                          <button class="accordion-button collapsed border-bottom font-weight-bold" data-toggle="collapse" id="headingOne" href="#collapseOne{{ $child->id }}">
                            {{ $child->question }}
                          </button>
                        </h5>
                        <div id="collapseOne{{ $child->id }}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionFaq{{ $key }}">
                          <div class="accordion-body text-sm opacity-8">
                            {!! $child->answer !!}
                          </div>
                        </div>
                      </div>
                    @endforeach
                  @endif
                </div>
              @endforeach
            @else
              <h4 class="my-4 ps-3 text-center">FAQ NOT FOUND</h4>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection


@push('script')
  <script>
    // $('.accordion-button').click(function(e) {
    //   $(this).parent().next().addClass('show');
    // });

    // $('.collapse-close').click(function(e) {
    //   $(this).parent().parent().next().removeClass('show')
    //   $(this).removeClass('.collapse-close').addClass('collapse-open');
    // })
  </script>
@endpush
